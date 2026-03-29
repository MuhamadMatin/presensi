<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  protected $keyType = 'string';

  protected $primaryKey = 'id_role';

  protected $table = 'roles';

  protected $fillable = [
    'id_role',
    'name',
    'description',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function users(): HasMany
  {
    return $this->hasMany(User::class, 'role_id');
  }
}
