<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\Issuers;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class IssuersTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Issuers/index.json')),
        ]);

        $issuers = new Issuers(['mock' => $mock]);

        $response = $issuers->index('organization-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_deauthorizes_an_issuer()
    {
        $mock = new MockHandler([
            new Response(204, ['Content-Type' => 'application/json']),
        ]);

        $issuers = new Issuers(['mock' => $mock]);

        $response = $issuers->deauthorize('org-uuid', 'issuer-uuid');

        $this->assertTrue(is_null($response));
    }
}
