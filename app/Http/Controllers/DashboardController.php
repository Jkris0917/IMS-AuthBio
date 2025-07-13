<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function search(Request $request)
    {
        $serial = $request->input('serial');  // Get the serial number from the query string
        $inventory = null;

        if ($serial) {
            // Search for the inventory item by serial number
            $inventory = Inventory::where('serial', $serial)->first(); // Adjust the model name if needed
        }

        return view('dashboard', compact('inventory'));
    }
}
