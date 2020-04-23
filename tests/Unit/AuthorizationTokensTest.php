<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\AuthorizationTokens;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class AuthorizationTokensTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/AuthorizationTokens/index.json')),
        ]);

        $authorizationTokens = new AuthorizationTokens(['mock' => $mock]);

        $response = $authorizationTokens->index('organization-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }
}
