<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareaper extends Model
{
    use HasFactory;

    protected $table = 'tareaspers';
    protected $fillable = ['title', 'description'];

    public function updates()
    {
        return $this->hasMany(Tareapersupdate::class, 'tareapers_id');
    }
}
