<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::orderBy('id', 'desc')->get();

        return view('area', compact('areas'));
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
    public function store(StoreAreaRequest $request)
    {
        Area::create($request->validated());

        return redirect()->back()->with('success', 'Area Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, Area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->back()->with('success', 'Area Deleted Successfully');
    }
}
