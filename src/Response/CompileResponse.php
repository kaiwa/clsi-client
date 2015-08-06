<?php

namespace Kaiwa\Clsi\Response;

class CompileResponse
{
    private $status;
    private $error;
    private $outputFiles;

    public function __construct($status, array $outputFiles, $error = null)
    {
        $this->outputFiles = $outputFiles;
        $this->status      = $status;
        $this->error       = $error;
    }

    public function getOutputFiles()
    {
        return $this->outputFiles;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isSuccess()
    {
        return ($this->status === 'success');
    }

    public function hasOutputFile($type)
    {
        return (isset($this->outputFiles[$type]));
    }

    public function getOutputFile($type)
    {
        if (isset($this->outputFiles[$type])) {
            return $this->outputFiles[$type];
        }

        return null;
    }

    public function getError()
    {
        return $this->error;
    }
}