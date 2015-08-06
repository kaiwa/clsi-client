<?php

namespace Kaiwa\Clsi\Response;

class OutputFile
{
    private $url;
    private $type;
    private $build;

    /**
     * @param string $url
     * @param string $type
     * @param int    $build
     */
    public function __construct($url, $type, $build)
    {
        $this->url   = $url;
        $this->type  = $type;
        $this->build = $build;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getBuild()
    {
        return $this->build;
    }

    public function __toString()
    {
        return $this->url;
    }
}