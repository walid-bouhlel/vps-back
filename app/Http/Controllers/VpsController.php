<?php

namespace App\Http\Controllers;
use App\Models\Vps;
use App\Services\OpenStackService;

use Illuminate\Http\Request;

class VpsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json('Vpss of');
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
    public function store(Request $request, OpenStackService $openStackService)
    {
       //
       $flavorId = $request->input('flavorId');
       $imageId = $request->input('imageId');
       $userId = $request->input('userId');
       $description = $request->input('description');
       $instance = $request->input('instance');


       $server=$openStackService->createServer($userId,$imageId,$flavorId);
       while ($server->status === 'BUILD') {
        $server->retrieve();
        sleep(2);
        $ipv44 = $openStackService->getIpv4Addressbyid($server->id);
    }


       $vps = new Vps();
       $vps->instance_id = $server->id;
       $vps->flavor_id = $flavorId;
       $vps->image_id = $imageId;
       $vps->user_id = $userId;
       $vps->server_name = $server->name;
       $vps->description = $description;
       $vps->instance = $instance;
       $vps->ipv4 = $ipv44;
       $vps->fill($request->all());
       $vps->save();
       return response()->json($vps);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, OpenStackService $openStackService)
    {

        $vps = Vps::findOrFail($id);
        $instance_id= $vps->instance_id;
        $server=$openStackService->getServerDetails($instance_id);
        $ipv4 = $openStackService->getIpv4Address($server);
        $vps->update([
            'ipv4' => $ipv4
        ]);
        return response()->json(['message' => 'VPS updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
