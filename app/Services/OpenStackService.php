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
}
