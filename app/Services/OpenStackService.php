<?php

namespace App\Services;

use OpenStack\OpenStack;
use App\Models\Flavor;

class OpenStackService
{
    protected $openstack;

    public function __construct()
    {
        $this->openstack = new OpenStack([
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
    }

    public function createKeyPair($name)
    {
        $compute = $this->openstack->computeV2(['region' => config('openstack.region')]);
        $keyPairName = $name;
        $keyPair = $compute->createKeypair([
            'name' => $name,
            //'publicKey' => $publicKey,
        ]);

        return ['name' => $keyPair->name, 'privateKey' => $keyPair -> privateKey , 'publicKey' => $keyPair -> publicKey , 'finger_print' => $keyPair -> fingerprint ];
    }


    public function listAllFlavors()
{
    $compute = $this->openstack->computeV2(['region' => config('openstack.region')]);
    $flavors = iterator_to_array($compute->listFlavors());

    $flavorsWithDetails = [];

    foreach ($flavors as $flavor) {
        // Use getFlavor to create a local Flavor object with the given ID
        $flavorDetails = $compute->getFlavor(['id' => $flavor->id]);

        // Use retrieve() to refresh the local Flavor object with the latest details
        $flavorDetails->retrieve();

        $flavorsWithDetails[] = [
            'id' => $flavorDetails->id,
            'name' => $flavorDetails->name,
            'flavorDetails' => [
                'disk' => $flavorDetails->disk,
                'ram' => $flavorDetails->ram,
                'swap' => $flavorDetails->swap,
                'vcpus' => $flavorDetails->vcpus,
                'links' => $flavorDetails->links,
            ],
        ];
    }

    return $flavorsWithDetails;
}
public function storeChosenFlavor($flavorId,$name)
    {
        $compute = $this->openstack->computeV2(['region' => config('openstack.region')]);
        $flavorDetails = $compute->getFlavor(['id' => $flavorId]);
        $flavorDetails->retrieve();
        $swapValue = ($flavorDetails->swap !== '' && $flavorDetails->swap !== null) ? $flavorDetails->swap : 0;
        // Store flavor in the "flavors" table
        $createdFlavor = Flavor::create([
            'stackId'=> $flavorDetails->id,
            'name' => $name,
            'nameInStack' => $flavorDetails->name,
            'disk' => $flavorDetails->disk,
            'ram' => $flavorDetails->ram,
            'swap' => $swapValue,
            'vcpus' => $flavorDetails->vcpus,
            
        ]);

        return $createdFlavor;
    }

    public function listAllImages()
{
    $compute = $this->openstack->computeV2(['region' => config('openstack.region')]);
    $images = iterator_to_array($compute->listImages());

    $imagesWithDetails = [];

    foreach ($images as $image) {
        
        $imageDetails = $compute->getImage(['id' => $image->id]);
        $imageDetails->retrieve();

        $ImagesWithDetails[] = [
            'id' => $imageDetails->id,
            'name' => $imageDetails->name
        ];
    }

    return $ImagesWithDetails;
}

    public function getImageDetails($imageId){
        $compute = $this->openstack->computeV2(['region' => config('openstack.region')]);
        $imageDetails = $compute->getImage(['id' => $imageId]);
        $imageDetails->retrieve();
        $imageWithDetails[] = [
            'id' => $imageDetails->id,
            'name' => $imageDetails->name
        ];
        return $imageDetails;

    }

}


