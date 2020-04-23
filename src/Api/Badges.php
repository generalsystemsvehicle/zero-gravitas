<?php

namespace GeneralSystemsVehicle\Acclaim\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use GeneralSystemsVehicle\Acclaim\Guzzle\Api;

class Badges extends Api
{
    /**
     * Get the badges index.
     * https://www.youracclaim.com/docs/issued_badges#get-issued-badges
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function index($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->get('v1/organizations/'.$organizationId.'/badges', [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }

    /**
     * Get the badges index in bulk high volume data set.
     * https://www.youracclaim.com/docs/issued_badges#get-badges-in-bulk
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function indexBulk($organizationId, $payload = [])
    {
        return $this->try(function() use ($organizationId, $payload)
        {
            $nextPageUrl = Arr::get(
                $payload,
                'next_page_url',
                'v1/organizations/'.$organizationId.'/high_volume_issued_badge_search'
            );

            return $this->client->get($nextPageUrl, [
                'query' => Arr::get($payload, 'query', []),
            ]);
        });
    }

    /**
     * Issue / create a badge.
     * https://www.youracclaim.com/docs/issued_badges#issue-a-badge
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function issue($organizationId, $payload = [])
    {
        return $this->create($organizationId, $payload);
    }

    /**
     * Issue / create a badge.
     * https://www.youracclaim.com/docs/issued_badges#issue-a-badge
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function create($organizationId, $payload = [])
    {
        if (! Arr::has($payload, 'recipient_email')) {
            return null;
        }

        if (! Arr::has($payload, 'issued_to_first_name')) {
            return null;
        }

        if (! Arr::has($payload, 'issued_to_last_name')) {
            return null;
        }

        if (! Arr::has($payload, 'badge_template_id')) {
            return null;
        }

        if (! Arr::has($payload, 'issued_at')) {
            return null;
        }

        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->post('v1/organizations/'.$organizationId.'/badges', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Issue / create a batch of badges.
     * https://www.youracclaim.com/docs/issued_badges#issue-a-batch-of-badges
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function issueBatch($organizationId, $payload = [])
    {
        return $this->createBatch($organizationId, $payload);
    }

    /**
     * Issue / create a batch of badges.
     * https://www.youracclaim.com/docs/issued_badges#issue-a-batch-of-badges
     *
     * @param  string $organizationId
     * @param  array  $payload
     * @return array|null
     */
    public function createBatch($organizationId, $payload = [])
    {
        if (! Arr::has($payload, 'badges')) {
            return null;
        }

        return $this->try(function() use ($organizationId, $payload)
        {
            return $this->client->post('v1/organizations/'.$organizationId.'/badges/batch', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Replace a badge.
     * https://www.youracclaim.com/docs/issued_badges#replace-a-badge
     *
     * @param  string $organizationId
     * @param  string $badgeId
     * @param  array  $payload
     * @return array|null
     */
    public function replace($organizationId, $badgeId, $payload = [])
    {
        if (! Arr::has($payload, 'badge_template_id')) {
            return null;
        }

        if (! Arr::has($payload, 'issued_at')) {
            return null;
        }

        return $this->try(function() use ($organizationId, $badgeId, $payload)
        {
            return $this->client->post('v1/organizations/'.$organizationId.'/badges/'.$badgeId.'/replace', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Revoke a badge.
     * https://www.youracclaim.com/docs/issued_badges#revoke-a-badge
     *
     * @param  string $organizationId
     * @param  string $badgeId
     * @param  array  $payload
     * @return array|null
     */
    public function revoke($organizationId, $badgeId, $payload)
    {
        if (! Arr::has($payload, 'reason')) {
            return null;
        }

        return $this->try(function() use ($organizationId, $badgeId, $payload)
        {
            return $this->client->put('v1/organizations/'.$organizationId.'/badges/'.$badgeId.'/revoke', [
                'body' => json_encode($payload),
            ]);
        });
    }

    /**
     * Delete a badge.
     * https://www.youracclaim.com/docs/issued_badges#delete-a-badge
     *
     * @param  string $organizationId
     * @param  string $badgeId
     * @return array|null
     */
    public function delete($organizationId, $badgeId)
    {
        return $this->try(function() use ($organizationId, $badgeId)
        {
            return $this->client->delete('v1/organizations/'.$organizationId.'/badges/'.$badgeId);
        });
    }
}
