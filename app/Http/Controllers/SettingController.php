<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use EragLaravelPwa\Facades\PWA;
use EragLaravelPwa\Core\PWA as corePwa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
      'logo' => 'sometimes|image|mimes:png|max:1024',
      'deskripsi' => 'sometimes',
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

        $file_path = $request->logo->storeAs('/', "logo.png", 'public');
        $paw_logo = corePwa::processLogo($request);
      } else {
        $file_path = $setting->logo;
      }

      $setting->update([
        'name' => $request->nama,
        'logo' => $file_path,
        'description' => $request->deskripsi,
        'updated_by' => Auth::id(),
        'updated_at' => now(),
      ]);

      $pwa = PWA::update([
        'name' => $request->nama,
        'short_name' => 'PS',
        'background_color' => '#6777ef',
        'display' => 'fullscreen',
        'description' => $request->deskripsi,
        'theme_color' => '#6777ef',
        'icons' => [
          [
            'src' => 'logo.png',
            'sizes' => '512x512',
            'type' => 'image/png',
          ],
        ],
      ]);

      DB::commit();
      return redirect()->route('settings.index');
    } catch (\Throwable $e) {
      DB::rollback();
      Log::error('Setting update failed', ['error' => $e->getMessage()]);
      return redirect()->route('settings.edit', $setting->id_setting)->withErrors(['error' => 'Gagal update setting'])->withInput();
    }
  }
}
