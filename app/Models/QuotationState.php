<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationState extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
