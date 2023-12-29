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

    public function createKeyPair()
    {
        $compute = $this->openstack->computeV2(['region' => config('openstack.region')]);
        $keyPairName = 'my-keypair8';
        $publicKey= "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQDmM/kD9tQxZozw09CLaM2L8UvYNbsz8Cigzv3JwlYAHYjLzdD9r5Y2m6G7ZZ9cXCmJh/uV9jGG5dXKjpO+LClH/T4ZBFE1AeQhbZN1KlXAoVGkImbtuQ/a+7iYP+H3YBDLFOTW8kdznWBvZ3j1vWFZHSsig9gRYIxj/4mryOpvZ4Z4slPy6UT51xcUBR/lol0EmOxzNOsstB34bY+bH2MZ0tn/CkZHmo1Ytwi7UbJXncpAwagw6CWcgWg1AaUu7UkcUanVXboN+Asz1fcwmv90TxLGWF5V665IW68qJ/NefwhxYfQmL/E6GsUVFKEo4FVaMQY2tB0ZZJxPsqTUyoMsBUDIrtTYObqgiaes2WInf+rPOaUraZbHsgSUdynhVWIOyNeYE5AQOCKQSM9unz62JUu8g4Osik+L1x8Kyefdf36pZ06uRE3BTgtDgZK8MvyxyyTiQGGloe+yvIukqvyXZ9QHhzShUm5HfhBssDrKl55espKPveCUoHtYrOaO2Nc= root@controller";
        $keyPair = $compute->createKeypair([
            'name' => $keyPairName,
            'public_key' => $publicKey,
        ]);


        return $keyPair->getPrivateKey();
    }
}
