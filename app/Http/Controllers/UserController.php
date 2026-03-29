<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $roles = Role::all();

    return view('Users.index', compact('roles'));
  }

  public function indexDatatable(Request $request)
  {
    $users = User::with('role')->orderBy('created_at', 'desc');

    if ($request->filled('role')) {
      $users->where('role_id', $request->role);
    }

    return Datatables::of($users)
      ->addIndexColumn()
      ->filter(function ($query) use ($request) {
        if ($request->filled('search')) {
          $query->where('id_user', 'like', '%' . $request->search . '%')
            ->orWhere('name', 'like', '%' . $request->search . '%')
            ->orWhere('username', 'like', '%' . $request->search . '%')
            ->orWhere('phone_number', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%');
        }
      })
      ->addColumn(
        'role',
        function ($item) {
          return $item->role->name ?? '-';
        }
      )
      ->addColumn('action', function ($item) {
        return $data = [
          'id' => $item->id_user
        ];
      })
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $roles = Role::all();
    return view('Users.create', compact('roles'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validators = Validator::make($request->all(), [
      'nama' => 'required',
      'email' => 'sometimes|unique:users,email',
      'username' => 'required|unique:users,username',
      'phone_number' => 'required|min:10|max:15',
      'role' => 'required|exists:roles,id_role',
    ]);

    if ($validators->fails()) {
      return redirect()->route('users.create')->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      $user = User::create([
        'id_user' => strtotime(now()) . uniqid(),
        'name' => $request->nama,
        'username' => $request->username,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'password' => Hash::make(env('NEW_USER_PASSWRORD')),
        'role_id' => $request->role,
        'created_at' => now(),
        'created_by' => Auth::id(),
        'updated_at' => null,
      ]);

      DB::commit();
      return redirect()->route('users.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('User creation failed', ['error' => $e->getMessage()]);
      return redirect()->route('users.create')->withErrors(['error' => 'Gagal create user'])->withInput();
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    $roles = Role::all();

    return view('Users.edit', compact('user', 'roles'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    $validators = Validator::make($request->all(), [
      'nama' => 'required',
      'email' => ['sometimes', Rule::unique('users', 'email')->ignore($user->id_user, 'id_user')],
      'username' => ['required', Rule::unique('users', 'username')->ignore($user->id_user, 'id_user')],
      'phone_number' => 'required|min:10|max:15',
      'role' => 'required|exists:roles,id_role',
    ]);

    if ($validators->fails()) {
      return redirect()->route('users.edit', $user->id_user)->withErrors($validators->errors())->withInput();
    }

    DB::beginTransaction();
    try {
      $user->update([
        'name' => $request->nama,
        'username' => $request->username,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'role_id' => $request->role,
        'updated_by' => Auth::id(),
        'updated_at' => now(),
      ]);

      DB::commit();
      return redirect()->route('users.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('User update failed', ['error' => $e->getMessage()]);
      return redirect()->route('users.edit', $user->id_user)->withErrors(['error' => 'Gagal update user'])->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    DB::beginTransaction();
    try {
      $user->deleted_at = now();
      $user->deleted_by = Auth::id();
      $user->save();
      $user->delete();

      DB::commit();
      return redirect()->route('users.index')->withSuccess('Success delete user');
    } catch (\Throwable $e) {
      DB::rollback();
      return redirect()->route('users.index')->withErrors(['error' => 'Gagal delete user']);
    }
  }
}
