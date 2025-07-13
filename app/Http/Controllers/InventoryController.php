<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Area;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::orderBy('id', 'desc')->get();

        return view('inventory', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryRequest $request)
    {
        $serial = $request->serial;

        // 1. Generate barcode image
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($serial, $generator::TYPE_CODE_128);

        // 2. Define file path
        $barcodePath = "public/barcode/{$serial}.png";

        // 3. Save to storage
        Storage::put($barcodePath, $barcode);

        // 4. Optional: save barcode path in DB
        Inventory::create([
            'serial' => $serial,
            'status' => $request->status,
            'placelocated' => $request->placelocated,
            'category' => $request->category,
            'itemname' => $request->itemname,
            'receivedby' => $request->receivedby,
            'receivedfrom' => $request->receivedfrom,
            'description' => $request->description,
            'barcode' => "storage/barcode/{$serial}.png", // store public path
        ]);

        return redirect()->back()->with('success', 'Item added and barcode saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    public function search(Request $request)
    {
        // Validate the input, ensure serial is provided
        $request->validate([
            'serial' => 'required|string|max:255',
        ]);

        // Search for the inventory item by serial number
        $inventory = Inventory::where('serial', $request->serial)->first();

        // Return the result to the view
        return view('dashboard', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        $areas = Area::all();
        $categories = Category::all();

        return view('editInventory', compact('inventory', 'areas', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        // Validate the request
        $validated = $request->validated();

        // Update the inventory record with the validated data
        $inventory->status = $validated['status'];
        $inventory->placelocated = $validated['placelocated'];
        $inventory->category = $validated['category'];
        $inventory->itemname = $validated['itemname'];
        $inventory->receivedby = $validated['receivedby'];
        $inventory->receivedfrom = $validated['receivedfrom'];
        $inventory->description = $validated['description'];

        // Save the changes to the database
        $inventory->save();

        // Flash a success message to the session
        return redirect()->back()->with('success', 'Inventory item updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        // Delete barcode image if exists
        if ($inventory->barcode) {
            $storagePath = str_replace('storage/', 'public/', $inventory->barcode);
            Storage::delete($storagePath);
        }

        // Delete the inventory record
        $inventory->delete();

        return redirect()->back()->with('success', 'Inventory item and barcode image deleted successfully.');
    }
}
