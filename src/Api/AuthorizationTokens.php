<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class AuthorizationTokens extends Api
{
    /**
     * Get the authorization tokens index.
     * https://www.youracclaim.com/docs/organizations#list-an-organizations-authorization-tokens
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function index($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/authorization_tokens', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }
}
