<?php

namespace App\Services;

use OpenStack\OpenStack;

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

}


