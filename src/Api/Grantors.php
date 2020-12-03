<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class Grantors extends Api
{
    /**
     * Get the grantors index.
     * https://www.youracclaim.com/docs/issuer_authorizations#get-grantors
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function index($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/grantors', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }
}
