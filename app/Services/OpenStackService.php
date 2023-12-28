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
                'id' => config('openstack.user_id'),
                'name' => config('openstack.username'),
                'password' => config('openstack.password'),
                'domain' => ['id' => config('openstack.domain_id')],
            ],
            'scope' => ['project' => ['id' => config('openstack.project_id')]],
        ]);
    }

    public function createKeyPair()
    {
        $identity = $this->openstack->identityV3();

        $credential = $identity->getCredential('credentialId');
        return $credential->retrieve();
    }
}
