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
        $os = OS::getAllOSs();
        return response()->json($os);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OpenStackService $openStackService)
    {
        $imageId=$request->input('imageId');
        $imageDetails = $openStackService->getImageDetails($imageId);
        $nameInStack = $imageDetails->name;
        $existingImage = $this->checkImageByStackId($imageId);
        if ($existingImage) {
            return response()->json(['error' => 'Image with the given Id already exists.'], 409);
        }
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
        $os = OS::deleteOS($id);

        if ($os) {
            return response()->json(['message' => 'OS deleted successfully']);
        } else {
            return response()->json(['error' => 'OS not found'], 404);
        }
    }
    public function checkImageByStackId($stackId): ?OS
    {
        return OS::where('idInStack', $stackId)->first();
    }

    public static function getOS(int $OSId)
    {
        return self::find($OSId);
    }
}
