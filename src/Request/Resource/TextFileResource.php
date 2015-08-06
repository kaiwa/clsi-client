<?php

namespace Kaiwa\Clsi\Request\Resource;

class TextFileResource implements ResourceInterface
{
    public $path;
    public $content;

    public function __construct($filepath)
    {
        $file = new \SplFileObject($filepath);

        $this->path = $file->getFilename();

        while (!$file->eof()) {
            $this->content .= $file->fgets();
        }
    }

    public function getPath()
    {
        return $this->path;
    }
}