<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  protected $keyType = 'string';

  protected $primaryKey = 'id_status';

  protected $table = 'statuses';

  protected $fillable = [
    'id_status',
    'name',
    'description',
    'created_by',
    'created_at',
    'updated_by',
    'updated_at',
  ];

  public function presences(): HasMany
  {
    return $this->hasMany(Presence::class);
  }
}
