<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isAdmin'])->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $distributions = Distribution::all();

        return response()->json([
            'success' => true,
            'data' => $distributions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $distribution = Distribution::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $distribution,
        ], 201); // 201 Created status code
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $distribution = Distribution::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $distribution,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $distribution = Distribution::findOrFail($id);
        $distribution->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $distribution,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $distribution = Distribution::findOrFail($id);
        $distribution->delete();

        return response()->json([
            'success' => true,
            'message' => 'Distribution deleted successfully',
        ]);
    }
}
