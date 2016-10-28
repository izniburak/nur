<?php

namespace App\Models;

use Mubu\Database\Model;

class Page extends Model
{
  protected $table = 'pages';

  public function category()
  {
      return $this->belongsTo('App\Models\Category', 'id');
  }
}
