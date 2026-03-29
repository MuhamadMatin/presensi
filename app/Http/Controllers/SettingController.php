<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use function Symfony\Component\Clock\now;

class SettingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('Setting.index');
  }

  public function indexDatatable(Request $request)
  {
    $settings = Setting::orderBy('created_at', 'desc');

    return Datatables::of($settings)
      ->addIndexColumn()
      ->addColumn('action', function ($item) {
        return $data = [
          'id' => $item->id_setting
        ];
      })
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('Setting.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Setting $setting)
  {
    return view('Setting.edit', compact('setting'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Setting $setting)
  {
    $validators = Validator::make($request->all(), [
      'nama' => 'required',
      'logo' => 'sometimes|image|mimes:jpeg,png,jpg,ico|max:2048',
    ]);

    if ($validators->fails()) {
      return redirect()->route('settings.edit', $setting->id_setting)->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      if ($request->hasFile('logo')) {
        if ($setting->logo) {
          Storage::disk('public')->delete($setting->logo);
        }

        $file_path = $request->logo->storeAs('/', "favicon.ico", 'public');
      } else {
        $file_path = $setting->logo;
      }

      $setting->update([
        'name' => $request->nama,
        'logo' => $file_path,
        'updated_by' => Auth::id(),
        'updated_at' => now(),
      ]);

      DB::commit();
      return redirect()->route('settings.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('Setting update failed', ['error' => $e->getMessage()]);
      return redirect()->route('settings.create', $setting->id_setting)->withErrors(['error' => 'Gagal update setting'])->withInput();
    }
  }
}
