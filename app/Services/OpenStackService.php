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
            'region' => config('openstack.region'),
            'user' => [
                'name' => config('openstack.username'),
                'password' => config('openstack.password'),
                'domain' => ['id' => 'default'],
            ],
            'scope' => ['project' => ['id' => config('openstack.project_id')]],
        ]);
    }

    public function createKeyPair()
    {
        $identity = $this->openstack->identityV3(['region' => config('openstack.region')]);

        $credential = $identity->getCredential('credentialId');
        return $credential->retrieve();
    }
}
