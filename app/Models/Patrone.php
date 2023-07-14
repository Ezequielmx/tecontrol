<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrone extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'anio',
        'pdf'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
