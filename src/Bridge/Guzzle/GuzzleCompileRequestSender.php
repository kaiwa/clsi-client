<?php

namespace Kaiwa\Clsi\Bridge\Guzzle;

use Kaiwa\Clsi\Psr\PsrCompileRequestFactory;
use Kaiwa\Clsi\Psr\PsrCompileResponseFactory;
use Kaiwa\Clsi\Request\CompileRequest;

use GuzzleHttp;

class GuzzleCompileRequestSender
{
    private $guzzleClient;
    private $psrRequestFactory;
    private $psrResponseFactory;

    public function __construct($guzzleConfig = array())
    {
        $this->guzzleClient       = new GuzzleHttp\Client($guzzleConfig);
        $this->psrRequestFactory  = new PsrCompileRequestFactory();
        $this->psrResponseFactory = new PsrCompileResponseFactory();
    }

    public function send(CompileRequest $request)
    {
        $httpRequest     = $this->psrRequestFactory->makePsrRequest($request);
        $psrResponse     = $this->guzzleClient->send($httpRequest);
        $compileResponse = $this->psrResponseFactory->makeCompileResponse($psrResponse);

        return $compileResponse;
    }
}