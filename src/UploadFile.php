<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <gigaprog@proton.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Src;

/**
 * @package GiGaCMS\UploadFile
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
trait UploadFile
{
  /**
   * Set name of the file.
   * 
   * @access protected
   * @var string
   */
  protected string $name;

  /**
   * Set type of the file.
   * 
   * @access protected
   * @var string
   */
  protected string $type;

  /**
   * Set temporary name.
   * 
   * @access protected
   * @var string
   */
  protected string $tmp_name;

  /**
   * Set error type of the file.
   * 
   * @access protected
   * @var string
   */
  protected int $error;

  /**
   * Set size.
   * 
   * @access protected
   * @var int
   */
  protected int $size;

  /**
   * Set maximum dimension of the file to upload.
   * 
   * @access protected
   * @var int
   */
  protected int $max_size = 2000000;

  /**
   * Get mime type allowed.
   * 
   * @access protected
   * @var array|string[] 
   */
  protected array $mime_type = [
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
  ];

  /** 
   * Set path to storing file.
   * 
   * @access protected
   * @static
   * @var string 
   */
  protected static string $path_file;

  /**
   * Set directory where storing file uploaded.
   * 
   * @access protected
   * @var string
   */
  protected string $move_path_file;

  /**
   * Get file name.
   * 
   * @return string
   */
  public function getName(): string
  {
    return str_replace(' ', '-', $this->name);
  }

  /**
   * Set file name.
   * 
   * @param array $fileName
   * @return void
   */
  public function setName(array $fileName): void
  {
    $this->name = $fileName['name'];
  }

  /**
   * Get file type.
   * 
   * @return string
   */
  public function getType(): string
  {
    return $this->type;
  }

  /**
   * Set file type.
   * 
   * @param array $fileName
   * @return void
   */
  public function setType(array $fileName): void
  {
    $this->type = $fileName['type'];
  }

  /**
   * Get temporary file name.
   * 
   * @return string
   */
  public function getTmpName(): string
  {
    return $this->tmp_name;
  }

  /**
   * Set temporary file name.
   * 
   * @param array $fileName
   * @return void
   */
  public function setTmpName(array $fileName): void
  {
    $this->tmp_name = $fileName['tmp_name'];
  }

  /**
   * Get error.
   * 
   * @return string
   */
  public function getError(): mixed
  {
    return $this->error;
  }

  /**
   * Manage the errors.
   * 
   * @param array $fileName
   * @return void
   * @throws \RuntimeException
   */
  public function setError(array $fileName): void
  {
    $this->error = $fileName['error'];
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
   * Get file size.
   * 
   * @return int
   */
  public function getSize(): int
  {
    return $this->size;
  }

  /**
   * Set file size.
   * 
   * @param array $fileName
   * @return void
   * @throws \RuntimeException
   */
  public function setSize(array $fileName): void
  {
    $this->size = $fileName['size'];
    if ($this->size > $this->max_size) {
      throw new \RuntimeException('Exceeded filesize limit');
    }
  }

  /**
   * Get path to storing file uploaded.
   *
   * @static
   * @return string
   */
  public static function getPathFile(): string
  {
    return self::$path_file;
  }

  /**
   * Set path to file uploaded.
   *
   * @static
   * @return void
   */
  public static function setPathFile(): void
  {
    self::$path_file = "/../public";
  }

  /**
   * Get directory name where storing files uploaded.
   *
   * @return string
   */
  public function getMovePathFile(): string
  {
    return $this->move_path_file;
  }

  /**
   * Set directory name where files uploaded have to been stored.
   *
   * @return void
   */
  public function setMovePathFile(): void
  {
    $this->move_path_file = "/../public/uploads";
  }

  /**
   * Move file uploaded to path assigned.
   * 
   * @static
   * @param array $fileName
   * @return mixed
   */
  public static function move(array $fileName): mixed
  {
    $dir = __DIR__ . self::getPathFile();

    if ($fileName['error'] === 0) {
      $baseName = basename($fileName['name']);
      move_uploaded_file($fileName['tmp_name'], "$dir/$baseName");
    } else {
      echo $fileName['error'];
    }
  }

  /**
   * Checks format file.
   *
   * @param array $fileName
   * @return void
   * @throws \RuntimeException
   */
  protected function mimeType(array $fileName): void
  {
    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
      $finfo->file($fileName['tmp_name']),
      $this->mime_type,
      true
    )) {
      throw new \RuntimeException('Invalid format file.');
    }
  }

  /**
   * If file uploaded hasn't errors it will be stored within directory selected.
   * 
   * @param array $fileName
   * @return  void
   * @throws \RuntimeException
   */
  public function moveUploadedFile(array $fileName): void
  {
    $dir = __DIR__ . "/../public/uploads";
    if (! is_dir($dir)) {
      mkdir($dir);
    }
   
    try {
      $this->setTmpName($fileName);
      $this->setName($fileName);
      $this->setSize($fileName);
      $this->mimeType($fileName);
      $this->setError($fileName);
      
      if ($this->getError() === 0) {
        $baseName = basename($this->getName());
        move_uploaded_file($this->getTmpName(), "$dir/$baseName");
      }
    } catch (\RuntimeException $exc) {
      printf("%s", $exc->getMessage());
    }
  }
}
