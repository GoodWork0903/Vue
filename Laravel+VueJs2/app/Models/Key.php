<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $guarded = ['id'];

    public function lock() {
        return $this->belongsTo(Lock::class);
    }

    public function employees() {
        return $this->belongsToMany(Employee::class);
    }
}
