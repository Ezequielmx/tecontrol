<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Services\CotizacionBna;
use Barryvdh\DomPDF\Facade\Pdf;

class CotizacionController extends Controller
{
    public function index(){
        $cot = new CotizacionBna();
        $cot->getCotiz();
        return view('admin.quotation.index');
    }

    public function create(){
        return view('admin.quotation.create');
    }

    public function edit($quotation_id){
        $quotation = Quotation::find($quotation_id);
        return view('admin.quotation.edit', compact('quotation'));
    }

    public function print($quotation_id){
        $quotation = Quotation::find($quotation_id);

        //return view('admin.quotation.print', compact('quotation'));
        $pdf = PDF::loadView('admin.quotation.print', compact('quotation'));
        return $pdf->stream('cotizacion.pdf');

        return view('admin.quotation.print', compact('quotation'));
    }
}
