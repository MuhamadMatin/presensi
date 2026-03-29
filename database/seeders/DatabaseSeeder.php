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

    $role_admin = Role::where('name', 'Admin')->first();
    $role_freelance = Role::where('name', 'Freelance')->first();
    $role_pegawai = Role::where('name', 'Pegawai Tetap')->first();
    $role_internship = Role::where('name', 'Internship')->first();

    User::factory()->create([
      'name'     => 'Admin',
      'username' => 'admin',
      'email'    => 'admin@gmail.com',
      'password' => Hash::make('passwordadmin'),
      'role_id'  => $role_admin->id_role,
    ]);

    User::factory()->create([
      'name'     => 'Internship',
      'username' => 'internship',
      'email'    => 'internship@gmail.com',
      'password' => Hash::make('passwordinternship'),
      'role_id'  => $role_internship->id_role,
    ]);

    User::factory()->create([
      'name'     => 'Freelance',
      'username' => 'freelance',
      'email'    => 'freelance@gmail.com',
      'password' => Hash::make('passwordfreelance'),
      'role_id'  => $role_freelance->id_role,
    ]);

    User::factory()->create([
      'name'     => 'Pegawai',
      'username' => 'pegawai',
      'email'    => 'pegawai@gmail.com',
      'password' => Hash::make('passwordpegawai'),
      'role_id'  => $role_pegawai->id_role,
    ]);

    User::factory(10)->create();

    Setting::create([
      'id_setting' => strtotime(now()) . uniqid(),
      'name' => 'presensi'
    ]);
  }
}
