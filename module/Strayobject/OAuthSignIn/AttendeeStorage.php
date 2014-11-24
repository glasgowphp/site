<?php

namespace Module\Strayobject\OAuthSignIn;

use Mizzencms\Core\Base;
use Mizzencms\Core\Exception\FileNotFoundException;

class AttendeeStorage extends Base
{
    private $fileLocation;
    private $data;

    public function __construct($location)
    {
        parent::__construct();

        $this->setFileLocation($location);
        $this->retrieve();
    }

    protected function retrieve()
    {
        if (!file_exists($this->getFileLocation())) {
            if (!$this->makeFileLocation()) {
                throw new FileNotFoundException(
                    'File and/or path does not exist and it is not possible
                    to create it.'
                );
            }
        }

        if (!is_readable($this->getFileLocation())) {
            throw new AccessDeniedException('File is not readable.');
        }

        $data = file_get_contents($this->getFileLocation());

        $this->setData($data);
    }
    /**
     * Method that creates file and required directories if they don't exist.
     * Last element is always considered to be a file
     *
     * @return bool
     */
    public function makeFileLocation()
    {
        $path = substr(
            $this->getFileLocation(),
            0,
            strrpos($this->getFileLocation(), DIRECTORY_SEPARATOR)
        );

        if (file_exists($path)) {
            $isDir = true;
        } else {
            $isDir = mkdir($path, 0777, true);
        }

        if ($isDir) {
            if ($f = fopen($this->getFileLocation(), 'w')) {
                fclose($f);

                return true;
            }
        }

        return false;
    }
    /**
     * Gets the value of fileLocation.
     *
     * @return mixed
     */
    public function getFileLocation()
    {
        return $this->fileLocation;
    }

    /**
     * Sets the value of fileLocation.
     *
     * @param mixed $fileLocation the file location
     *
     * @return self
     */
    public function setFileLocation($fileLocation)
    {
        $this->fileLocation = $fileLocation;

        return $this;
    }

    /**
     * Gets the value of data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the value of data.
     *
     * @param mixed $data the data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}