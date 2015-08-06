<?php

namespace Kaiwa\Clsi\Request\Resource;

class StringResource implements ResourceInterface
{
    public $path;
    public $content;

    public function __construct($path, $content)
    {
        $this->path    = $path;
        $this->content = $content;
    }

    public function getPath()
    {
        return $this->path;
    }
}