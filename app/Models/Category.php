<?php

namespace App\Models;

use Mubu\Database\Model;

class Category extends Model
{
  protected $table = 'categories';

  public function photos()
  {
    return $this->hasMany('App\Models\Page', 'c_id');
  }
}
