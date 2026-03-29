<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  /**
   * The current password being used by the factory.
   */
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id_user' => uniqid(),
      'name' => fake()->name(),
      'username' => fake()->unique()->name(),
      'email' => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password' => Hash::make(env('NEW_USER_PASSWRORD')),
      'remember_token' => Str::random(10),
      'phone_number' => $this->faker->phoneNumber(),
      'role_id' => Role::where('name', '!=', 'Admin')->inRandomOrder()->first()->id_role,
      'created_at' => now(),
      'created_by' => 'Migrations',
      'updated_at' => NULL,
      'updated_by' => NULL,
      'deleted_at' => NULL,
      'deleted_by' => NULL,
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   */
  public function unverified(): static
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
