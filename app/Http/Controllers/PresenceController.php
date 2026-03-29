<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\PresenceImage;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PresenceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $statuses = Status::all();

    return view('Presences.index', compact('statuses'));
  }

  public function presenceOut()
  {
    $user = Auth::id();
    $presence_today = Presence::with('status')
      ->where('user_id', $user)->whereDate(
        'entry',
        Carbon::today()->toDateString()
      )->first();

    try {
      $presence_today->update([
        'out' => now(),
        'updated_by' => $user,
        'updated_at' => now(),
      ]);
      return response()->json(['message' => 'Presensi keluar berhasil'], 200);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Presensi keluar gagal']);
    }
  }

  public function indexDatatable(Request $request)
  {
    if (Auth::user()->hasRole(['Admin'])) {
      $presences = Presence::with('user', 'status')->orderBy('created_at', 'desc');
    } else {
      $presences = Presence::with('user', 'status')->where('created_by', Auth::id())->orderBy('created_at', 'desc');
    }

    if ($request->filled('status')) {
      $presences->where('status_id', $request->status);
    }

    return Datatables::of($presences)
      ->addIndexColumn()
      ->filter(function ($query) use ($request) {
        if ($request->filled('search')) {
          $query->where(function ($q) use ($request) {
            $q->where('id_presence', 'like', '%' . $request->search . '%')
              ->orWhere('entry', 'like', '%' . $request->search . '%')
              ->orWhere('out', 'like', '%' . $request->search . '%')
              ->orWhere('location', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%')
              ->orWhere(function ($subq) use ($request) {
                $subq->whereHas('user', function ($subsubq) use ($request) {
                  $subsubq->where('name', 'like', '%' . $request->search . '%');
                });
              });
          });
        }
      })
      ->addColumn(
        'status',
        function ($item) {
          return $item->status->name ?? '-';
        }
      )
      ->addColumn(
        'user_name',
        function ($item) {
          return $item->user->name ?? '-';
        }
      )
      ->addColumn('action', function ($item) {
        return $data = [
          'id' => $item->id_presence
        ];
      })
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $statuses = Status::all();

    return view('Presences.create', compact('statuses'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $status_presence = Status::where('name', 'Hadir')->first();
    $is_presence = $request->status == $status_presence->id_status;

    $validators = Validator::make($request->all(), [
      'lokasi' => [Rule::requiredIf($is_presence)],
      'keterangan' => 'sometimes',
      'status' => 'required|exists:statuses,id_status',
      'foto' => ['array', 'max:3', Rule::requiredIf($is_presence)],
      'foto.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validators->fails()) {
      return redirect()->route('presences.create')->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      $presence = Presence::create([
        'id_presence' => strtotime(now()) . uniqid(),
        'entry' => now(),
        'out' => $is_presence ? null : now(),
        'location' => $is_presence ? $request->lokasi : null,
        'description' => $request->deskripsi,
        'user_id' => Auth::id(),
        'status_id' => $request->status,
        'created_at' => now(),
        'created_by' => Auth::id(),
        'updated_at' => null,
      ]);

      foreach ($request->file('foto', []) as $image) {
        $file_name = uniqid() . '.' . $image->getClientOriginalExtension();
        $file_path = $image->storeAs('presence/image', $file_name, 'public');

        PresenceImage::create([
          'id_presence_image' => strtotime(now()) . uniqid(),
          'image' => $file_path,
          'presence_id' => $presence->id_presence,
          'created_at' => now(),
          'created_by' => Auth::id(),
        ]);
      }

      DB::commit();
      return redirect()->route('presences.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('Presensi creation failed', ['error' => $e->getMessage()]);
      return redirect()->route('presences.create')->withErrors(['error' => 'Gagal create presensi'])->withInput();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Presence $presence)
  {
    $presence->load('images');
    $statuses = Status::all();

    return view('Presences.edit', compact('presence', 'statuses'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Presence $presence)
  {
    $validators = Validator::make($request->all(), [
      'masuk' => 'sometimes',
      'keluar' => 'sometimes',
      'lokasi' => [Rule::requiredIf($request->status == Status::where('name', 'Hadir')->value('id_status'))],
      'keterangan' => 'sometimes',
      'status' => 'required|exists:statuses,id_status',
    ]);

    if ($validators->fails()) {
      return redirect()->route('presences.edit', $presence->id_presence)->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      $presence->update([
        'entry' => $request->masuk,
        'out' => $request->keluar ?? null,
        'location' => $request->lokasi,
        'description' => $request->deskripsi,
        'user_id' => Auth::id(),
        'status_id' => $request->status,
        'updated_by' => Auth::id(),
        'updated_at' => now(),
      ]);

      DB::commit();
      return redirect()->route('presences.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('Presensi update failed', ['error' => $e->getMessage()]);
      return redirect()->route('presences.edit', $presence->id_presence)->withErrors(['error' => 'Gagal update presensi'])->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Presence $presence)
  {
    DB::beginTransaction();
    try {
      $presence->deleted_at = now();
      $presence->deleted_by = Auth::id();
      $presence->save();
      $presence->delete();

      DB::commit();
      return redirect()->route('presences.index')->withSuccess('Success delete presensi');
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('presences.index')->withErrors(['error' => 'Gagal delete presensi']);
    }
  }
}
