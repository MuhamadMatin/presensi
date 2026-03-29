<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function profile(Request $request)
  {
    $user = Auth::user();
    // $user->load('role');
    return view('Auth.profile', compact('user'));
  }

  public function login()
  {
    if (!session()->has('name') || !session()->has('logo')) {
      $setting = Setting::select('name', 'logo')->first();

      session([
        'name' => $setting->name,
        'logo' => $setting->logo
      ]);
    }

    return view('Auth.login');
  }

  public function resetPassword(Request $request)
  {
    $user = User::where('id_user', $request->id_user)->first();
    try {
      $user->update([
        'password' => Hash::make(env('RESET_PASSWRORD')),
        'updated_at' => now(),
        'updated_by' => Auth::id(),
      ]);

      return response()->json(['message' => 'Berhasil reset password']);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Gagal reset password']);
    }
  }

  public function updatePassword(Request $request)
  {
    $user = User::where('id_user', Auth::id())->first();

    $validators = Validator::make($request->all(), [
      'new_password' => ['required', 'confirmed'],
    ]);

    if (Auth::id() == $request->id_user) {
      DB::beginTransaction();
      try {
        $user->update([
          'password' => Hash::make($request->new_password),
          'updated_at' => now(),
          'updated_by' => Auth::id(),
        ]);
        DB::commit();
        return back()->with('success', 'Password berhasil diubah');
      } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('gagal', 'Password gagal diubah');
      }
    } else {
      $user->logout();
    }
  }

  public function updateProfil(Request $request)
  {
    $user = User::where('id_user', Auth::id())->first();
    if (Auth::id() == $request->id_user) {
      $user->update([
        'username' => $request->username,
        'name' => $request->name,
        'number_phone' => $request->phone,
        'email' => $request->email,
        'updated_at' => now(),
        'updated_by' => Auth::id(),
      ]);
      return redirect()->route('profile');
    } else {
      $user->logout();
    }
  }

  public function storeLogin(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    if ($validator->fails()) {
      return redirect()->route('login')->withErrors($validator)->withInput();
    }

    $user = User::where('username', $request->username)->first();

    if (!$user) {
      return redirect()->route('login')
        ->withErrors(['username' => 'Username tidak ada'])->withInput();
    } else {
      if (Hash::check($request->password, $user->password)) {
        Auth::loginUsingId($user->id_user);

        return redirect()->route('index');
      } else {
        return redirect()->route('login')->withErrors(['password' => 'Password salah'])->withInput();
      }
    }
  }

  public function logout(Request $request)
  {
    Session::flush();
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }
}
