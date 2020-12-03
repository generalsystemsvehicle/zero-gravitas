<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class Issuers extends Api
{
    /**
     * Get the issuers index.
     * https://www.youracclaim.com/docs/issuer_authorizations#get-issuers
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function index($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/issuers', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }

    /**
     * Delete / deauthorize an issuer.
     * https://www.youracclaim.com/docs/issuer_authorizations#deauthorize-an-issuer
     *
     * @param  string $organizationId
     * @param  string $issuerId
     * @return array|null
     */
    public function deauthorize($organizationId, $issuerId)
    {
        return $this->delete($organizationId, $issuerId);
    }

    /**
     * Delete / deauthorize an issuer.
     * https://www.youracclaim.com/docs/issuer_authorizations#deauthorize-an-issuer
     *
     * @param  string $organizationId
     * @param  string $issuerId
     * @return array|null
     */
    public function delete($organizationId, $issuerId)
    {
        return $this->try(function() use ($organizationId, $issuerId)
        {
            return $this->client->delete('v1/organizations/'.$organizationId.'/issuers/'.$issuerId);
        });
    }
}
