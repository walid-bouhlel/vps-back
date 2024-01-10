<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OS;
use App\Services\OpenStackService;

class OSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OpenStackService $openStackService)
    {
        $imageDetails = $openStackService->getImageDetails($request->input('imageId'));
        $nameInStack = $imageDetails->name;
        $idInStack = $imageDetails->id;
        $OS = new OS();
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $OS->nameInStack = $nameInStack;
        $OS->idInStack = $idInStack;
        $OS->fill($request->all());
        $OS->save();
        //$OS = OS::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $OS,
        ], 201); // 201 Created status code
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
