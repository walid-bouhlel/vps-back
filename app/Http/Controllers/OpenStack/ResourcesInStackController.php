<?php

namespace App\Http\Controllers\OpenStack;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenStack\OpenStack;
use App\Services\OpenStackService;
class ResourcesInStackController extends Controller
{   
    protected $openstack;
  

    public function index()
    {
        $openstack = new OpenStack([
            'authUrl' => config('openstack.auth_url'),
            'region'  => config('openstack.region'),
            'user'    => [
                'id'       => config('openstack.user_id'),
                'password' => config('openstack.password'),
                'domain' => ['id' => config('openstack.domain_id')],
            ],
            'scope' => [
                'project' => [
                    'id' => config('openstack.project_id')
                ]
            ]
        ]);
        $identity = $openstack->identityV3();
        $compute = $openstack->computeV2(['region' => config('openstack.region')]);
        $keyPairName = 'my-keypair5';
        $keyPair = $compute->createKeypair([
            'name' => $keyPairName,
        ]);
        $publicKey = $keyPair->getAliases();
        
        
        //$servers = $compute->listServers(true);
        //foreach ($servers as $server) {
        //$listservers[] = $server;
        //}

        //foreach ($identity->listUsers() as $user) {
        //    $users[] = $user;
        //
        //}

        return response()->json($publicKey);
    }
    public function getFlavorsInStack(Request $request, OpenStackService $openStackService)
    {
        return response()->json($openStackService->listAllFlavors());

    }

    public function getImagesInStack(Request $request, OpenStackService $openStackService)
    {
        return response()->json($openStackService->listAllImages());

    }

    public function index3(Request $request, OpenStackService $openStackService)
    {
        $flavorId = $request->input('flavorId');
        $createdFlavor = $openStackService->storeChosenFlavor($flavorId);

        return response()->json([
            'message' => 'Chosen flavor stored successfully',
            'flavor' => [
                'id' => $createdFlavor->id,
                'Stackid' => $createdFlavor->stackId,
                'name' => $createdFlavor->name,
                'disk' => $createdFlavor->disk,
                'ram' => $createdFlavor->ram,
                'swap' => $createdFlavor->swap,
                'vcpus' => $createdFlavor->vcpus,
            ],
        ]);
        
    }

    public function test(Request $request, OpenStackService $openStackService)
    {
        $imageId = $request->input('imageId');
        return response()->json($openStackService->getImageDetails($imageId));
    }

    public function testcreateServer(Request $request, OpenStackService $openStackService)
    {
        $imageId = $request->input('imageId');
        $flavorId = $request->input('flavorId');
        $userId = $request->input('userId');


        return response()->json($openStackService->createServer($userId,$imageId,$flavorId));
    }

    public function testretrieveServer(Request $request, OpenStackService $openStackService)
    {
        $serverId = $request->input('serverId');
        return response()->json($openStackService->getServerDetails($serverId));
    }

}
