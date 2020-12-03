<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class Organizations extends Api
{
    /**
     * Get the organizations index.
     * https://www.youracclaim.com/docs/organizations#list-organizations
     *
     * @param  array  $payload
     * @return array|null
     */
    public function index($payload = [])
    {
        return $this->try(function() use ($payload)
        {
            return $this->client->get('v1/organizations', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }

    /**
     * Get an organization.
     * https://www.youracclaim.com/docs/organizations#get-an-organization
     *
     * @param  string $organizationId
     * @return array|null
     */
    public function get($organizationId)
    {
        return $this->try(function() use ($organizationId)
        {
            return $this->client->get('v1/organizations/'.$organizationId);
        });
    }

    /**
     * Update an organization.
     * https://www.youracclaim.com/docs/organizations#update-an-organization
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function update($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->put('v1/organizations/'.$organizationId, [
                'body' => json_encode($payload),
            ]);
        });
    }
}
