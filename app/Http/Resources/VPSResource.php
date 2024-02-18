<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VPSResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'server_name' => $this->server_name,
            'description' => $this->description,
            'instance' => $this->instance,
            'ipv4' => $this->ipv4,
            'os_id' => $this->os_id,
            'config_id' => $this->config_id,
        ];
    }
}
