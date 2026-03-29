<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PresenceImage extends Model
{
  use SoftDeletes;

  public $incrementing = false;

  protected $keyType = 'string';

  protected $primaryKey = 'id_presence_image';

  protected $table = 'presence_images';

  protected $fillable = [
    'id_presence_image',
    'image',
    'presence_id',
    'created_at',
    'created_by',
    'updated_at',
  ];

  public function presence(): BelongsTo
  {
    return $this->belongsTo(Presence::class);
  }
}
