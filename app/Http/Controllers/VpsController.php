<?php

namespace App\Http\Controllers;
use App\Models\Vps;
use App\Services\OpenStackService;
use App\Http\Resources\VPSResource;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class VpsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VPSResource::collection(
            Vps::where('user_id', Auth::user()->id)->get()
        );
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
       $os_id = $request->input('os_id');
       $config_id = $request->input('config_id');



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
       $vps->os_id = $os_id;
       $vps->config_id = $config_id;
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
