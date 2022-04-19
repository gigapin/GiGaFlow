<?php
/*
 * This file is part of the GiGaFlow package.
 *
 * (c) Giuseppe Galari <giga.webdev@protonmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Src\Http;

use Exception;
use Src\Validation\ValidateRequest;

/**
 * Manage request to application
 *
 * @package Src\Http
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
class Request
{
    use ValidateRequest;

    /**
     * All requests
     *
     * @return array
     */
    public function all(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $request[] = filter_input_array(INPUT_POST);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $request[] = filter_input_array(INPUT_GET);
        } else {
            $request[] = null;
        }

        return $request;
    }

    /**
     * Request GET
     *
     * @param $value
     * @return mixed
     */
    public static function get($value)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return filter_input(INPUT_GET, $value);
        }
    }

    /**
     * Request POST
     *
     * @param $value
     * @return mixed
     */
    public static function post($value)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return filter_input(INPUT_POST, $value);
        }
    }

    /**
     * Delete all requests.
     */
    public static function refresh()
    {
        $_POST = [];
        $_GET = [];
        $_FILES = [];
    }

    /**
     * Call methods to get validation rules.
     *
     * @param $data array Rules written in controller
     * @param $method string Name about type of the rule and of the method to call in ValidateRequest class
     * @param $input string Name input field
     * @param $value string Value of the input field
     * @param string $rule string Rule
     * @return void
     */
    public function callRule(array $data, string $method, string $input, string $value, string $rule): void
    {
        $obj = "Src\ValidateRequest";
        if (method_exists($obj, $method)) {
            call_user_func_array(array($obj, $method), [$input, $value, $rule]);
        }
    }

    /**
     * Process to validation data. Call rules method in ValidateRequest class.
     *
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function validate(array $data): array
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
                throw new Exception('Input field not exists');
            }
        }
        foreach ($input as $k => $v) {
            for ($x = 0; $x < count($v['method']); $x++) {
                if ($v['method'][$x] === 0) {
                    $v['method'][$x] = $v['rule'][$x];
                }
                $this->callRule($data, $v['method'][$x], $k, $v['value'], $v['rule'][$x]);
            }
        }

        return ValidateRequest::getErrors();
    }

}
