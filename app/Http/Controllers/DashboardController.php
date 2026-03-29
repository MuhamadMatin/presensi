<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $is_presence_today = Presence::with('status')
      ->where('user_id', Auth::id())->whereDate(
        'entry',
        Carbon::today()->toDateString()
      )->first();

    return view('index', compact('is_presence_today'));
  }

  public function dataPresences()
  {
    $today = Carbon::today()->toDateString();
    $month_start = Carbon::now()->startOfMonth()->toDateString();
    $month_end = Carbon::now()->endOfMonth()->toDateString();
    $user_id = Auth::id();
    $is_admin = Auth::user()->role == "Admin" ? true : false;

    $query_today_raw = DB::table('presences as p')
      ->select(
        'st.name as status_name',
        DB::raw('COUNT(p.id_presence) as total')
      )
      ->leftJoin('statuses as st', 'st.id_status', '=', 'p.status_id')
      ->whereDate('p.entry', $today)
      ->whereNull('p.deleted_at');

    if (!$is_admin) {
      $query_today_raw->where('p.created_by', $user_id);
    }

    $today_raw = $query_today_raw->groupBy('st.id_status', 'st.name')->get()
      ->keyBy(fn($row) => strtolower($row->status_name ?? 'other'));

    $today_recap = [
      'present' => $today_raw->get('hadir')->total ?? 0,
      'sick' => $today_raw->get('sakit')->total ?? 0,
      'leave' => $today_raw->get('izin')->total ?? 0,
      'day_off' => $today_raw->get('cuti')->total ?? 0,
    ];

    $query_monthly_raw = DB::table('presences as p')
      ->select(
        'st.name as status_name',
        DB::raw('COUNT(p.id_presence) as total')
      )
      ->leftJoin('statuses as st', 'st.id_status', '=', 'p.status_id')
      ->whereBetween(DB::raw('DATE(p.entry)'), [$month_start, $month_end])
      ->whereNull('p.deleted_at');

    if (!$is_admin) {
      $query_today_raw->where('p.created_by', $user_id);
    }

    $monthly_raw = $query_monthly_raw->groupBy('st.id_status', 'st.name')->get()
      ->keyBy(fn($row) => strtolower($row->status_name ?? 'other'));

    $monthly_recap = [
      'present' => $monthly_raw->get('hadir')->total ?? 0,
      'sick' => $monthly_raw->get('sakit')->total ?? 0,
      'leave' => $monthly_raw->get('izin')->total ?? 0,
      'day_off' => $monthly_raw->get('cuti')->total ?? 0,
    ];

    $query_my_monthly_raw = DB::table('presences as p')
      ->select(
        'st.name as status_name',
        DB::raw('COUNT(p.id_presence) as total')
      )
      ->leftJoin('statuses as st', 'st.id_status', '=', 'p.status_id')
      ->where('p.user_id', $user_id)
      ->whereBetween(DB::raw('DATE(p.entry)'), [$month_start, $month_end])
      ->whereNull('p.deleted_at');

    if (!$is_admin) {
      $query_my_monthly_raw->where('p.created_by', $user_id);
    }

    $my_monthly_raw = $query_my_monthly_raw->groupBy('st.id_status', 'st.name')->get()
      ->keyBy(fn($row) => strtolower($row->status_name ?? 'other'));

    $my_monthly_recap = [
      'present' => $my_monthly_raw->get('hadir')->total ?? 0,
      'sick' => $my_monthly_raw->get('sakit')->total ?? 0,
      'leave' => $my_monthly_raw->get('izin')->total ?? 0,
      'day_off' => $my_monthly_raw->get('cuti')->total ?? 0,
    ];

    $my_presence_today = Presence::with('status')
      ->where('user_id', $user_id)->whereDate('entry', $today)->first();

    $recent_presences = Presence::with(['user', 'status'])
      ->latest('entry')->take(10)->get();

    return [
      'today_recap' => $today_recap,
      'monthly_recap' => $monthly_recap,
      'my_monthly_recap' => $my_monthly_recap,
      'my_presence_today' => $my_presence_today,
      'recent_presences' => $recent_presences,
    ];
  }
}
