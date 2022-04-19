<?php


namespace Src;


use http\Exception\RuntimeException;
use RuntimeException as GlobalRuntimeException;

/**
 * Class UploadFile
 * @package Src
 */
class UploadFile
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string
     */
    protected string $tmp_name;

    /**
     * @var string
     */
    protected string $error;

    /**
     * @var int
     */
    protected int $size;

    /**
     * @var int
     */
    protected int $max_size = 2000000;

    /**
     * @var array|string[] 
     */
    protected array $mime_type = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $filename
     */
    public function setName($filename): void
    {
        $this->name = $_FILES[$filename]['name'];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param $filename
     */
    public function setType($filename): void
    {
        $this->type = $_FILES[$filename]['type'];
    }

    /**
     * @return string
     */
    public function getTmpName(): string
    {
        return $this->tmp_name;
    }

    /**
     * @param $filename
     */
    public function setTmpName($filename): void
    {
        $this->tmp_name = $_FILES[$filename]['tmp_name'];
    }

    /**
     * @return int
     */
    public function getError(): int
    {
        return $this->error;
    }

    /**
     * @param $filename
     */
    public function setError($filename): void
    {
        $this->error = $_FILES[$filename]['error'];
        switch ($this->error) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \RuntimeException('No file sent');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \RuntimeException('Exceeded filesize limit');
            default:
                throw new \RuntimeException('Unknown errors');
        }
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param $filename
     */
    public function setSize($filename): void
    {
        $this->size = $_FILES[$filename]['size'];
        if ($this->size > $this->max_size) {
            throw new \RuntimeException('Exceeded filesize limit');
        }
    }

    /**
     * @param $fileName
     */
    public static function move($fileName)
    {
        $dir = __DIR__ . "/../public/uploads";

        if ($_FILES[$fileName]['error'] === 0) {
            $baseName = basename($_FILES[$fileName]['name']);
            move_uploaded_file($_FILES[$fileName]['tmp_name'], "$dir/$baseName");
        } else {
            echo $_FILES[$fileName]['error'];
        }
    }

    protected function mimeType($filename)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES[$filename]['tmp_name']),
            $this->mime_type,
            true
        )) {
            throw new \RuntimeException('Invalid file format.');
        }
    }

    /**
     * @param $filename
     */
    public function moveUploadedFile($filename)
    {
        $dir = __DIR__ . "/../public/uploads";
       
        try {
            $this->setTmpName($filename);
            $this->setName($filename);
            $this->setSize($filename);
            $this->mimeType($filename);
            $this->setError($filename);
            
            if ($this->getError() === 0) {
                $baseName = basename($this->getName());
                move_uploaded_file($this->getTmpName(), "$dir/$baseName");
                echo "File uploaded correctly";
            }
        } catch (\RuntimeException $exc) {
            echo $exc->getMessage();
        }
    }
}