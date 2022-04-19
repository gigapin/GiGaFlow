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

namespace Src\Validation;

/**
 * Manage validation about request
 *
 * @package Src\Validation
 * @author GiGa <giga.webdev@protonmail.com>
 * @version 1.0.0
 */
trait ValidateRequest
{
    /** @var array  */
    public static array $errors = [];

    /**
     * @param string $input
     * @param string $value
     * @param string $rule
     */
    public static function required(string $input, string $value, string $rule)
    {
        if ((int) $rule === 1 && $value === '') {
            self::$errors[] = "$input Field is required";
        }
    }

    /**
     * @param string $input
     * @param string $value
     * @param string $rule
     */
    public static function min(string $input, string $value, string $rule)
    {
        if (strlen($value) < (int) $rule) {
            self::$errors[$input] = "$input is too short";
        }
    }

    /**
     * @param string $input
     * @param string $value
     * @param string $rule
     */
    public static function max(string $input, string $value, string $rule)
    {
        if (strlen($value) > (int) $rule) {
            self::$errors[$input] = "$input is Too long";
        }
    }

    /**
     * @param string $input
     * @param string $value
     * @param string $rule
     */
    public static function email(string $input, string $value, string $rule)
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$errors[$input] = "Email address not valid";
        }
    }

    /**
     * @param string $input
     * @param string $value
     * @param string $rule
     */
    public static function string(string $input, string $value, string $rule)
    {
        if (preg_match("/^([0-9]+)$/", $value)) {
            self::$errors[$input] = "Allowed only string characters";
        }
    }

    /**
     * @param string $input
     * @param string $value
     * @param string $rule
     */
    public function number(string $input, string $value, string $rule)
    {
        if (preg_match("/^([a-z]+)$/i", $value)) {
            self::$errors[$input] = "Allowed only number characters";
        }
    }

    /**
     * Display all errors stored
     *
     * @return array
     */
    public static function getErrors(): array
    {
        return self::$errors;
    }
}