<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  public $incrementing = false;

  protected $keyType = 'string';

  protected $primaryKey = 'id_setting';

  protected $table = 'settings';

  protected $fillable = [
    'id_setting',
    'name',
    'logo',
    'description',
  ];
}
