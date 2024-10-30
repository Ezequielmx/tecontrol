<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    public function quotationType(){
        return $this->belongsTo('App\Models\QuotationType');
    }

    public function quotationState(){
        return $this->belongsTo('App\Models\QuotationState');
    }

    public function quotationPriority(){
        return $this->belongsTo('App\Models\QuotationPriority');
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function quotationDetails(){
        return $this->hasMany('App\Models\QuotationDetail');
    }

    public function quotationDocs(){
        return $this->hasMany('App\Models\QuotationDoc');
    }

    public function contact(){
        return $this->belongsTo('App\Models\ClientsContact', 'contacto');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->quotationDetails as $detail) {
            $total += $detail->cantidad * $detail->precio * $detail->cotizacion;
        }
        return $total;
    }
}
