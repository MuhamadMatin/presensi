<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('Roles.index');
  }

  public function indexDatatable(Request $request)
  {
    $roles = Role::orderBy('created_at', 'desc');

    return Datatables::of($roles)
      ->filter(function ($roles) use ($request) {
        if ($request->filled('search')) {
          $roles->where(function ($q) use ($request) {
            $q->where('id_role', 'like', '%' . $request->search . '%')
              ->orWhere('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
          });
        }
      })
      ->addColumn('action', function ($item) {
        return $data = [
          'id' => $item->id_role
        ];
      })
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('Roles.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validators = Validator::make($request->all(), [
      'nama' => 'required',
      'deskripsi' => 'sometimes|max:255',
    ]);

    if ($validators->fails()) {
      return redirect()->route('roles.create')->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      $role = Role::create([
        'id_role' => strtotime(now()) . uniqid(),
        'name' => $request->nama,
        'description' => $request->deskripsi,
        'created_at' => now(),
        'created_by' => Auth::id(),
        'updated_at' => null,
      ]);

      DB::commit();
      return redirect()->route('roles.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('Role creation failed', ['error' => $e->getMessage()]);
      return redirect()->route('roles.create')->withErrors(['error' => 'Gagal create role'])->withInput();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Role $role)
  {
    return view('Roles.edit', compact('role'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Role $role)
  {
    $validators = Validator::make($request->all(), [
      'nama' => 'required',
      'deskripsi' => 'sometimes|max:255',
    ]);

    if ($validators->fails()) {
      return redirect()->route('roles.edit', $role->id_role)->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      $role->update([
        'name' => $request->nama,
        'description' => $request->deskripsi,
        'updated_by' => Auth::id(),
        'updated_at' => now(),
      ]);

      DB::commit();
      return redirect()->route('roles.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('Role update failed', ['error' => $e->getMessage()]);
      return redirect()->route('roles.edit', $role->id_role)->withErrors(['error' => 'Gagal update role'])->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Role $role)
  {
    DB::beginTransaction();
    try {
      $role->deleted_at = now();
      $role->deleted_by = Auth::id();
      $role->save();
      $role->delete();

      DB::commit();
      return redirect()->route('roles.index')->withSuccess('Success delete role');
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('roles.index')->withErrors(['error' => 'Gagal delete role']);
    }
  }
}
