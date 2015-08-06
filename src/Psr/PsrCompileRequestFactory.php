<?php

namespace Kaiwa\Clsi\Psr;

use Kaiwa\Clsi\Request\CompileRequest;
use Kaiwa\Clsi\Request\RequestBodyEncoderInterface;

use GuzzleHttp\Psr7\Request;

/**
 * Creates a PSR-7 http request from a CompileRequest
 */
class PsrCompileRequestFactory
{
    /***
     * Creates a PSR-7 http request from a CompileRequest
     *
     * @param CompileRequest $request
     *
     * @return Request PSR-7 compatible http request
     */
    public function makePsrRequest(CompileRequest $request)
    {
        $psrRequest = new Request(
            'POST',
            $request->getOption('url'),
            array(
                'Content-Type' => 'application/json'
            ),
            $this->serializeBody($request)
        );

        return $psrRequest;
    }

    /**
     * Creates the JSON representation of a CompileRequest which will be sent in the body of the HTTP POST request
     *
     * @param CompileRequest $compileRequest
     *
     * @return string JSON representation of the CompileRequest
     */
    private function serializeBody(CompileRequest $compileRequest)
    {
        $json = json_encode(array(
            'compile' => array(
                'options'          => $compileRequest->getOptions(),
                'rootResourcePath' => $compileRequest->getRootResourcePath(),
                'resources'        => array_values($compileRequest->getResources())
            )
        ));

        return $json;
    }
}