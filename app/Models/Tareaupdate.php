<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareaupdate extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'detail'];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }
}
