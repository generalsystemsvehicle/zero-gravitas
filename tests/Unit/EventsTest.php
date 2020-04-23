<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\Events;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class EventsTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Events/index.json')),
        ]);

        $events = new Events(['mock' => $mock]);

        $response = $events->index('organization-uuid', [
            'query' => [
                'page' => 1,
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_gets_a_single_record()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Events/get.json')),
        ]);

        $events = new Events(['mock' => $mock]);

        $response = $events->get('organization-uuid', 'event-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }
}
