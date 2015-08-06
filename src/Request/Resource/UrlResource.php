<?php

namespace Kaiwa\Clsi\Request\Resource;

/**
 * A resource which is available for download at the given URL
 *
 * This is the correct resource type to use for images for example.
 */
class UrlResource implements ResourceInterface
{
    public $path;
    public $url;
    public $modified;

    /**
     * @param string   $path     Local path reference used inside the tex document
     * @param string   $url      Remote url where the resource is available for download
     * @param null|int $modified Unix timestamp of last modification
     */
    public function __construct($path, $url, $modified = null)
    {
        $this->path = $path;
        $this->url  = $url;
        $this->modified = $modified;
    }

    /**
     * Local path reference used inside the tex document
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}