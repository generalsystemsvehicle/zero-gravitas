<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\Obi;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class ObiTest extends TestCase
{
    /** @test */
    function it_returns_a_single_badge_assertion()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Obi/badge-assertion.json')),
        ]);

        $obi = new Obi(['mock' => $mock]);

        $response = $obi->badgeAssertion('badge-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('@context', $response));
        $this->assertTrue(array_key_exists('badge', $response));
        $this->assertTrue(array_key_exists('expires', $response));
        $this->assertTrue(array_key_exists('evidence', $response));
    }

    /** @test */
    function it_returns_a_single_badge_class_or_template()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Obi/badge-class-or-template.json')),
        ]);

        $obi = new Obi(['mock' => $mock]);

        $response = $obi->badgeClass('template-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('@context', $response));
        $this->assertTrue(array_key_exists('criteria', $response));
        $this->assertTrue(array_key_exists('description', $response));
    }

    /** @test */
    function it_returns_a_single_issuer()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Obi/issuer.json')),
        ]);

        $obi = new Obi(['mock' => $mock]);

        $response = $obi->issuer('issuer-uuid');

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('@context', $response));
        $this->assertTrue(array_key_exists('email', $response));
        $this->assertTrue(array_key_exists('description', $response));
    }
}
