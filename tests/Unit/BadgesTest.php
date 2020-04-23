<?php

namespace GeneralSystemsVehicle\Acclaim\Tests\Unit;

use GeneralSystemsVehicle\Acclaim\Api\Badges;
use GeneralSystemsVehicle\Acclaim\Tests\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BadgesTest extends TestCase
{
    /** @test */
    function it_returns_a_paginated_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Badges/index.json')),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->index('org-uuid', [
            'query' => [
                'filter' => 'state::accepted',
                'sort' => 'created_at',
                'page' => 1,
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_returns_a_high_volume_index()
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Badges/index-bulk.json')),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->indexBulk('org-uuid', [
            'query' => [
                'filter' => 'state::active',
                'badge_format' => 'minimal',
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_issues_or_creates_a_badge()
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Badges/issue.json')),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->issue('org-uuid', []);

        $this->assertNull($response);

        $response = $badges->issue('org-uuid', [
            'recipient_email' => 'test@example.com',
        ]);

        $this->assertNull($response);

        $response = $badges->issue('org-uuid', [
            'recipient_email' => 'test@example.com',
            'issued_to_first_name' => 'Earner First Name',
        ]);

        $this->assertNull($response);

        $response = $badges->issue('org-uuid', [
            'recipient_email' => 'test@example.com',
            'issued_to_first_name' => 'Earner First Name',
            'issued_to_last_name' => 'Earner Last Name',
        ]);

        $this->assertNull($response);

        $response = $badges->issue('org-uuid', [
            'recipient_email' => 'test@example.com',
            'issued_to_first_name' => 'Earner First Name',
            'issued_to_last_name' => 'Earner Last Name',
            'badge_template_id' => 'cfaf2910-ea5f-46f1-89a5-db525dad6e58',
        ]);

        $this->assertNull($response);

        $response = $badges->issue('org-uuid', [
            'recipient_email' => 'test@example.com',
            'issued_to_first_name' => 'Earner First Name',
            'issued_to_last_name' => 'Earner Last Name',
            'badge_template_id' => 'cfaf2910-ea5f-46f1-89a5-db525dad6e58',
            'issued_at' => '2014-04-01 09:41:00 -0500',
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_issues_or_creates_batch_of_badges()
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Badges/issue-batch.json')),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->issueBatch('org-uuid', []);

        $this->assertNull($response);

        $response = $badges->issueBatch('org-uuid', [
            'badges' => [
                [
                  'recipient_email' => 'user971@example.com',
                  'issued_to_first_name' => 'Alfred',
                  'issued_to_last_name' => 'Skiles',
                  'badge_template_id' => '6c32280e-eb8c-4f9a-89c2-2dc3ac7c1861',
                  'issued_at' => '2014-04-01 09:41:00 -0500',
                ],
                [
                  'recipient_email' => 'user972@example.com',
                  'issued_to_first_name' => 'Alfred',
                  'issued_to_last_name' => 'Skiles',
                  'badge_template_id' => '6c32280e-eb8c-4f9a-89c2-2dc3ac7c1861',
                  'issued_at' => '2014-04-01 09:41:00 -0500',
                ],
            ],
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_replaces_a_badge()
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Badges/replace.json')),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->replace('org-uuid', 'badge-uuid', []);

        $this->assertNull($response);

        $response = $badges->replace('org-uuid', 'badge-uuid', [
            "badge_template_id" => "4008b9b1-1251-40a3-ba90-1bbc9720fc37",
        ]);

        $this->assertNull($response);

        $response = $badges->replace('org-uuid', 'badge-uuid', [
            "badge_template_id" => "4008b9b1-1251-40a3-ba90-1bbc9720fc37",
            "issued_at" => "2014-04-01 09:41:00 -0500",
            "issued_to_first_name" => "Firstname",
            "issued_to_last_name" => "Lastname",
            "issuer_earner_id" => "earner-1",
            "expires_at" => null,
            "country_name" => "United States of America",
            "state_or_province" => "Minnesota",
            "evidence" => [
                [
                    "type" => "UrlEvidence",
                    "value" => "http://www.example.com/evidence",
                    "description" => "Description in URL evidence is optional",
                    "name" => "Evidence",
                ],
            ],
            "notification_message" => "Lorem ipsum dolor",
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_revokes_a_badge()
    {
        $mock = new MockHandler([
            new Response(201, ['Content-Type' => 'application/json'], file_get_contents(__DIR__.'/../Fixtures/Badges/revoke.json')),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->revoke('org-uuid', 'badge-uuid', []);

        $this->assertTrue(is_null($response));

        $response = $badges->revoke('org-uuid', 'badge-uuid', [
            'reason' => 'Check bounced',
            'suppress_revoke_notification_email' => false,
        ]);

        $this->assertTrue(is_array($response));
        $this->assertTrue(array_key_exists('data', $response));
        $this->assertTrue(array_key_exists('metadata', $response));
    }

    /** @test */
    function it_deletes_a_badge()
    {
        $mock = new MockHandler([
            new Response(204, ['Content-Type' => 'application/json']),
        ]);

        $badges = new Badges(['mock' => $mock]);

        $response = $badges->delete('org-uuid', 'badge-uuid');

        $this->assertTrue(is_null($response));
    }
}
