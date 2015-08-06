<?php

namespace Kaiwa\Clsi\Request;

use Kaiwa\Clsi\Request\Resource\ResourceInterface;

class CompileRequest
{
    private $resources = array();
    private $options;
    private $rootResourcePath;

    const COMPILER_LATEX    = 'latex';
    const COMPILER_PDFLATEX = 'pdflatex';
    const COMPILER_XELATEX  = 'xelatex';
    const COMPILER_LUALATEX = 'lualatex';

    /**
     * @param string $baseUrl Base url of the CLSI server (may include the port if it is not 80)
     * @param string $projectId An arbitrary project identifier
     * @param ResourceInterface $rootResource The main LaTeX file
     */
    public function __construct($baseUrl, $projectId, ResourceInterface $rootResource)
    {
        $this->options = array(
            'url'      => "$baseUrl/project/$projectId/compile",
            'compiler' => self::COMPILER_PDFLATEX,
            'timeout'  => 40
        );

        $this->addResource($rootResource);
        $this->rootResourcePath = $rootResource->getPath();
    }

    /**
     * Sets the LaTeX compiler name which will be used by the CLSI server
     *
     * @param string $compiler
     */
    public function setCompiler($compiler)
    {
        $this->options['compiler'] = $compiler;
    }

    /**
     * Sets the maximum processing time the server will spent for compiling the LaTeX file
     *
     * @param $timeout
     */
    public function setTimeout($timeout)
    {
        $this->options['timeout'] = (int) $timeout;
    }

    /**
     * Add a resource (e.g. an image or an included tex file)
     *
     * @param ResourceInterface $resource
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[$resource->getPath()] = $resource;
    }

    /**
     * Add multiple resources at once (e.g. images or included tex files)
     *
     * @param array $resources
     */
    public function addResources(array $resources)
    {
        foreach ($resources as $resource) {
            $this->addResource($resource);
        }
    }

    /**
     * Get all compile options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get a particular compile option by name
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getOption($name)
    {
        return $this->options['url'];
    }

    /**
     * Return all embedded resources
     *
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Returns the name of the main LaTeX file
     *
     * @return string
     */
    public function getRootResourcePath()
    {
        return $this->rootResourcePath;
    }
}