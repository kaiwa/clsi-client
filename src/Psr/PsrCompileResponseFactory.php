<?php

namespace Kaiwa\Clsi\Psr;

use Kaiwa\Clsi\Response\CompileResponse;
use Kaiwa\Clsi\Response\Exception as ResponseException;
use Kaiwa\Clsi\Response\OutputFile;

use Psr\Http\Message\ResponseInterface;

/**
 * Builds a CompileResponse from a psr-7 http response object
 */
class PsrCompileResponseFactory
{
    /**
     * Builds a CompileResponse from a psr-7 http response object
     *
     * @param ResponseInterface $response PSR-7 http response
     *
     * @throws ResponseException\InvalidResponseException
     * @throws ResponseException\CompileFailureException
     * @throws ResponseException\ErrorResponseException
     *
     * @return CompileResponse
     */
    public function makeCompileResponse(ResponseInterface $response)
    {
        $body = $response->getBody()->getContents();

        $decoded = json_decode($body, false);

        if (!$decoded ||
            !isset($decoded->compile) ||
            !isset($decoded->compile->status) ||
            !isset($decoded->compile->outputFiles)) {
            throw new ResponseException\InvalidResponseException('The server returned a not parsable response: '.$body);
        }

        if ($decoded->compile->status != 'success') {
            throw new ResponseException\CompileFailureException(
                'The LaTeX compiler failed. Please see the server-side compiler log file for details.'
            );
        }

        if ($decoded->compile->error != '') {
            throw new ResponseException\ErrorResponseException(
                'The server returned an error message: '.$decoded->compile->error
            );
        }

        $outputFiles = array();
        foreach ($decoded->compile->outputFiles as $outputFile) {
            $outputFiles[$outputFile->type] = new OutputFile($outputFile->url, $outputFile->type, $outputFile->build);
        }

        $compileResponse = new CompileResponse(
            $decoded->compile->status,
            $outputFiles,
            $decoded->compile->error
        );

        return $compileResponse;
    }
}