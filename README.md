# CLSI Client Library

For sending LaTeX files to a compile server using the "Common LaTeX Service Interface"-API.

This library creates psr7-compatible http requests, so you can use any psr7-compatible http client for sending the
created requests. You may take a look <a href="https://packagist.org/providers/psr/http-message-implementation">here</a>
for finding an http client.

For a CLSI server implementation see https://github.com/sharelatex/clsi-sharelatex

## Usage

### Guzzle client example

For the guzzle http client there is the GuzzleCompileRequestSender class included.
It takes care of transforming the CompileRequest into an http request and also transforming
the http response back into a CompileResponse.

You will need to require the suggested ``guzzlehttp/guzzle`` composer package.

```php
require __DIR__.'/vendor/autoload.php';

use Kaiwa\Clsi as Clsi;

$compileRequest = new Clsi\Request\CompileRequest(
    'http://myclsiserver.com:3013',
    'myprojectId',
    new Clsi\Request\Resource\TextFileResource(__DIR__.'/test.tex')
);

// Optional: Add more resources
// $compileRequest->addResources(
//      new Clso\Request\Resource\UrlResource('logo.png', 'http://myserver.com/logo.png')
// );

$sender = new Clsi\Bridge\Guzzle\GuzzleCompileRequestSender();
$compileResponse = $sender->send($compileRequest);

$compiledPdfUrl = $compileResponse->getOutputFile('pdf');
```

### Any other psr7-compatible http client example

If you want to use any other psr7-compatible http client (or a particular Guzzle instance) you have to transform the CompileRequest
into an http request and the http response into a CompileResponse manually.

```php
require __DIR__.'/vendor/autoload.php';

use Kaiwa\Clsi as Clsi;

$compileRequest = new Clsi\Request\CompileRequest(
    'http://myclsiserver.com:3013',
    'myprojectId',
    new Clsi\Request\Resource\TextFileResource(__DIR__.'/test.tex')
);

// Optional: Add more resources
// $compileRequest->addResources(
//      new Clso\Request\Resource\UrlResource('logo.png', 'http://myserver.com/logo.png')
// );

$compileRequestFactory  = new Clsi\Psr\PsrCompileRequestFactory();
$compileResponseFactory = new Clsi\Psr\PsrCompileResponseFactory();

// initiate your http client
$httpClient = new HttpClient();

// Transform the CompileRequest into an http request
$httpRequest = $compileRequestFactory->makePsrRequest($compileRequest);

// Send the http request with your client and get the response
$httpResponse    = $httpClient->send($httpRequest);

// Transform the http response into a CompileResponse
$compileResponse = $compileResponseFactory->makeCompileResponse($httpResponse);

// Work with the CompileResponse
$compiledPdfUrl = $compileResponse->getOutputFile('pdf');
```
