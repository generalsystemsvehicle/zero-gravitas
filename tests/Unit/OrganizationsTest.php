<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\Organizations;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class OrganizationsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Organizations/index.json')),
        ]);

        $organizations = new Organizations(['mock' => $mock]);

        $response = $organizations->index();

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Organizations/get.json')),
        ]);

        $organizations = new Organizations(['mock' => $mock]);

        $response = $organizations->get('organization-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_updates_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Organizations/update.json')),
        ]);

        $organizations = new Organizations(['mock' => $mock]);

        $response = $organizations->update('organization-uuid', [
            'name' => 'Example Organization',
            'website_url' => 'https://www.example.com',
            'webhook_url' => 'https://example.com/webhook_endpoint',
            'location' => 'East Junius, Ohio',
            'zip_or_postal_code' => '55437',
            'contact_email' => 'info@example.com',
            'organization_type' => 'Auto Parts Reseller',
            'bio' => 'Since 1994',
            'twitter_url' => 'https://twitter.com/example',
            'facebook_url' => 'https://www.facebook.com/example',
            'photo' => 'https://cdn.example.com/path/to/image.png',
            'city' => 'Bloomington',
            'state_or_province' => 'Minnesota',
            'country' => 'United States',
            'address' => '1313 Mockingbird Lane',
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }
}
