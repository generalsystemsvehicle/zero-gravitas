<?php

namespace GeneralSystemsVehicle\Acclaim\Guzzle;

use GeneralSystemsVehicle\Acclaim\Events\RequestExceptionWasThrown;
use GeneralSystemsVehicle\Acclaim\Guzzle\Backoff;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Initialize the instance.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $stack = HandlerStack::create(Arr::get($options, 'mock'));

        $middlewares = Arr::get($options, 'middleware', [
            Middleware::retry(Backoff::decider(), Backoff::delay()),
        ]);

        foreach($middlewares as $middleware) {
            $stack->push($middleware);
        }

        $this->client = new Client([
            'base_uri' => Config::get('acclaim.base_uri'),
            'handler' => $stack,
            'headers' => [
                // https://www.youracclaim.com/docs/web_service_api#authentication
                'Authorization' => 'Basic ' . base64_encode(Config::get('acclaim.api_key') . ':'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Try a Guzzle request.
     * @param  callable $response
     * @return array|null
     */
    protected function try(callable $response) {
        try {
            return $this->handleReponse($response());
        } catch (RequestException $exception) {
            return $this->handleBadResponse($exception);
        }
    }

    /**
     * Handles a response from the Guzzle client.
     *
     * @param  ResponseInterface $response
     * @return array|null
     */
    protected function handleReponse(ResponseInterface $response)
    {
        $body = $response->getBody()->getContents();

        $isXml = false;
        if ($response->hasHeader('Content-Type')) {
            $isXml = strstr($response->getHeader('Content-Type')[0], 'application/xml');
        }

        if ($body && $isXml) {
            $xml = new SimpleXMLElement($body);
            $body = json_encode($xml);
        }

        return json_decode($body ?: '', true);
    }

    /**
     * Handles an exception from the Guzzle client.
     *
     * @param  RequestException $exception
     * @return null
     */
    protected function handleBadResponse(RequestException $exception)
    {
        $response = $exception->getResponse();

        // 404 Not Found
        if ($response && $response->getStatusCode() == 404) {
            return null;
        }

        // 422 Unprocessable Entity
        if ($response && $response->getStatusCode() == 422) {
            return null;
        }

        Event::dispatch(new RequestExceptionWasThrown($exception));

        throw $exception;
    }
}
