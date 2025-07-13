<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeController extends Controller
{
    public function generate($serial)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($serial, $generator::TYPE_CODE_128);

        return response($barcode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="barcode.png"',
        ]);
    }
}
