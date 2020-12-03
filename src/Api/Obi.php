<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class Obi extends Api
{
    /**
     * Get the badge assertion / badge.
     * https://www.youracclaim.com/docs/obi_specified_endpoints#get-badge-assertion
     *
     * @param  string $badgeId
     * @return array|null
     */
    public function badgeAssertion($badgeId)
    {
        return $this->try(function() use ($badgeId)
        {
            return $this->client->get('v1/obi/v2/badge_assertions/'.$badgeId);
        });
    }

    /**
     * Get the badge class / template.
     * https://www.youracclaim.com/docs/obi_specified_endpoints#get-badge-class
     *
     * @param  string $templateId
     * @return array|null
     */
    public function badgeClass($templateId)
    {
        return $this->try(function() use ($templateId)
        {
            return $this->client->get('v1/obi/v2/badge_classes/'.$templateId);
        });
    }

    /**
     * Get the issuer.
     * https://www.youracclaim.com/docs/obi_specified_endpoints#get-issuer
     *
     * @param  string $issuerId
     * @return array|null
     */
    public function issuer($issuerId)
    {
        return $this->try(function() use ($issuerId)
        {
            return $this->client->get('v1/obi/v2/issuers/'.$issuerId);
        });
    }
}
