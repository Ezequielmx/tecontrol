<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $fillable = ['title', 'description', 'value', 'category'];

    public function updates()
    {
        return $this->hasMany(Tareaupdate::class, 'task_id');
    }
}
