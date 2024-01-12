<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    protected $guarded = ['id'];

    public function keys() {
        return $this->hasMany(Key::class);
    }
}
