<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presence extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  protected $keyType = 'string';

  protected $primaryKey = 'id_presence';

  protected $table = 'presences';

  protected $fillable = [
    'id_presence',
    'entry',
    'out',
    'location',
    'description',
    'user_id',
    'status_id',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function images(): HasMany
  {
    return $this->hasMany(PresenceImage::class, 'presence_id');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id_user');
  }

  public function status(): BelongsTo
  {
    return $this->belongsTo(Status::class, 'status_id', 'id_status');
  }
}
