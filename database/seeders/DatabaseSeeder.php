<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Setting;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $roles = ['Admin', 'Freelance', 'Pegawai Tetap', 'Internship'];

    foreach ($roles as $role) {
      Role::factory()->create([
        'name' => $role,
      ]);
    }

    $statuses = ['Hadir', 'Sakit', 'Izin', 'Cuti'];

    foreach ($statuses as $status) {
      Status::factory()->create([
        'name' => $status,
      ]);
    }

    $role = Role::where('name', 'admin')->first();

    User::factory()->create([
      'name' => 'admin',
      'username' => 'admin',
      'email' => 'admin@gmail.com',
      'password' => Hash::make('passwordadmin'),
      'role_id' => $role->id_role,
    ]);

    User::factory(10)->create();

    Setting::create([
      'id_setting' => strtotime(now()) . uniqid(),
      'name' => 'presensi'
    ]);
  }
}
