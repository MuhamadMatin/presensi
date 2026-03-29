<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable, SoftDeletes;

  public $incrementing = false;

  public $timestamps = true;

  protected $primaryKey = 'id_user';

  protected $keyType = 'string';

  protected $table = 'users';

  protected $fillable = [
    'id_user',
    'name',
    'username',
    'email',
    'password',
    'phone_number',
    'role_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function role(): BelongsTo
  {
    return $this->belongsTo(Role::class, 'role_id', 'id_role');
  }

  public function hasRole($role): bool
  {
    return in_array($this->role->name, $role);
  }
}
