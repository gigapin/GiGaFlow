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

namespace Src\Http;

use Exception;
use Src\CSRFToken;
use Src\Validation\ValidateRequest;

/**
 * 
 * @package GiGaFlow\Http
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class Request
{
  //use ValidateRequest;

  /**
   * Storing $_REQUEST value.
   * 
   * @access protected
   * @var array
   */
  protected array $data;

  /**
   * Constructor.
   */
  public function __construct()
  {
    if (!empty($_REQUEST)) {
      $this->data = $_REQUEST;
    }
  }

  /**
   * All request methods.
   *
   * @param array $data
   * @static
   * @return array
   */
  public static function all(array $data = []): array
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $request = filter_input_array(INPUT_POST);
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $request = filter_input_array(INPUT_GET);
    } else {
      $request = null;
    }
    
    if (count($data) > 0) {
      foreach ($data as $key => $value) {
        $request[$key] = $value;
      }
    }
    if (array_key_exists('_token', $request)) {
      unset($request['_token']);
    }
    return $request;
  }

  /**
   * Create a method called as field name.
   *
   * @param string $name
   * @return mixed
   */
  public function __get(string $name): mixed
  {
    return isset($this->data[$name]) ? $this->data[$name] : null;
  }

  /**
   * Request GET method.
   *
   * @param string $value
   * @static
   * @return mixed
   */
  public static function get(string $value): mixed
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      return filter_input(INPUT_GET, $value);
    }
  }

  /**
   * Request POST method.
   *
   * @param string $value
   * @static
   * @return mixed
   */
  public static function post(string $value): mixed
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      CSRFToken::verifyToken();
      return filter_input(INPUT_POST, $value, FILTER_SANITIZE_SPECIAL_CHARS);
    }
  }

  /**
   * Get data from POST method where name attribute is an array of values.
   *
   * @param string $values
   * @static
   * @return mixed
   */
  public static function multiPost(string $values): mixed
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      CSRFToken::verifyToken();
      return filter_input(INPUT_POST, $values, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    }
  }

  /**
   * Return a value from a HTTP file upload variable.
   *
   * @param string $value
   * @static
   * @return mixed
   */
  public static function file(string $value): mixed
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      CSRFToken::verifyToken();
      return $_FILES[$value];
    }
  }

  /**
   * Delete all requests.
   * 
   * @static
   * @return void
   */
  public static function refresh(): void
  {
    $_POST = [];
    $_GET = [];
    $_FILES = [];
  }

  /**
   * Get what type of method has been request.
   *
   * @static
   * @return string
   */
  public static function method(): string
  {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  /**
   * Return URI.
   * @static
   * @return string
   */
  public static function uri(): string
  {
    return $_SERVER['REQUEST_URI'];
  }

  /**
   * Get name of the server host.
   *
   * @static
   * @return string
   */
  public static function site(): string
  {
    return $_SERVER['SERVER_NAME'] . "/";
  }

  /**
   * Call methods to get validation rules.
   *
   * @param $data array Rules written in controller
   * @param $method string Name about type of the rule and of the method to call in ValidateRequest class
   * @param $input string Name input field
   * @param $value string Value of the input field
   * @param string $rule string Rule
   * @static
   * @return void
   */
  public static function callRule(array $data, string $method, string $input, string|null $value, mixed $rule): void
  {
    $obj = "Src\Validation\ValidateRequest";

    if (method_exists($obj, $method)) {
      call_user_func_array(array($obj, $method), [$input, $value, $rule]);
    }
  }

  /**
   * Process to validation data. Call rules method in ValidateRequest class.
   *
   * @param array $data
   * @return mixed
   * @throws \Exception
   */
  public static function validate(array $data): mixed
  {
    $input = array();
    
    foreach ($data as $k => $v) {
      if (array_key_exists($k, $data)) {
        $value = self::post($k);
        $array[$k] = $v;
        $method = array_keys($array[$k]);
        $rule = array_values($array[$k]);
        $input[$k] = ['value' => $value, 'method' => $method, 'rule' => $rule];
      } else {
        throw new \Exception('Input field not exists');
      }
    }
    
    foreach ($input as $k => $v) {
      for ($x = 0; $x < count($v['method']); $x++) {
        if ($v['method'][$x] === 0) {
          $v['method'][$x] = $v['rule'][$x];
        }

        self::callRule($data, $v['method'][$x], $k, $v['value'], $v['rule'][$x]);
      }
    }

    return ValidateRequest::getErrors($input);
  }
}
