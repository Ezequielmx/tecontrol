<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareapersupdate extends Model
{
    use HasFactory;

    protected $fillable = ['tareapers_id', 'detail'];

    public function tarea()
    {
        return $this->belongsTo(Tareaper::class, 'tarea_id');
    }

}
