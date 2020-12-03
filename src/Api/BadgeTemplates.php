<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class BadgeTemplates extends Api
{
    /**
     * Get the badge templates index.
     * https://www.youracclaim.com/docs/badge_templates#get-badge-templates
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function index($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/badge_templates', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }

    /**
     * Get a badge template.
     * https://www.youracclaim.com/docs/badge_templates#get-a-single-badge-template
     *
     * @param  string $organizationId
     * @param  string  $badgeTemplateId
     * @return array|null
     */
    public function get($organizationId, $badgeTemplateId)
    {
        return $this->try(function() use ($organizationId, $badgeTemplateId)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/badge_templates/'.$badgeTemplateId);
        });
    }
}
