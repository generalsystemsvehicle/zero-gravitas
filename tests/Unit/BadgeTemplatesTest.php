<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\BadgeTemplates;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BadgeTemplatesTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/BadgeTemplates/index.json')),
        ]);

        $templates = new BadgeTemplates(['mock' => $mock]);

        $response = $templates->index('896bcba9-ff7a-46c5-a226-9dc0ab0d9a1', [
            'query' => [
                'filter' => 'state::active',
                'sort' => 'created_at',
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
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/BadgeTemplates/get.json')),
        ]);

        $templates = new BadgeTemplates(['mock' => $mock]);

        $response = $templates->get('b4deef45-9e00-4809-be6b-a6835a8f350e', '823a5e0c-1d8d-4801-a5c8-bd4e3a776a4c');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }
}
