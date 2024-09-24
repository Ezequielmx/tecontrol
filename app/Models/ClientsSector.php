<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsSector extends Model
{
    use HasFactory;

    protected $table = 'clientssectors';

    protected $fillable = [
        'sector'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function certificados()
    {
        return $this->hasMany('App\Models\Detallehoja', 'clientssector_id');
    }
}
