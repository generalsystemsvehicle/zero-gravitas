<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class Events extends Api
{
    /**
     * Get the events index.
     * https://www.youracclaim.com/docs/organizations#list-all-events-belonging-to-an-organization
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function index($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/events', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }

    /**
     * Get an event.
     * https://www.youracclaim.com/docs/organizations#get-an-event-belonging-to-an-organization
     *
     * @param  string $organizationId
     * @param  string $eventId
     * @return array|null
     */
    public function get($organizationId, $eventId)
    {
        return $this->try(function() use ($organizationId, $eventId)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/events/'.$eventId);
        });
    }
}
