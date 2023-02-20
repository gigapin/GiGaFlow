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

namespace Src\Validation;

use App\Models\Post;
use Src\Http\Request;
use Src\Http\Redirect;
use Src\Session\Session;

/**
 * 
 * @package GiGaFlow\Validation
 * @author Giuseppe Galari <gigaprog@proton.me>
 * @version 1.0.0
 */
class ValidateRequest
{
  /** 
   * Storing errors.
   * 
   * @static
   * @var array  
   */
  public static array $errors = [];

  /**
   * The field is mandatory.
   * 
   * @param string $input
   * @param string|null $value
   * @param string $rule
   * @static
   * @return void
   */
  public static function required(string $input, string|null $value, string $rule): void
  {
    if (((int) $rule === 1 && $value === '') || ((int) $rule === 1 && $value === null)) {
      self::$errors[] = "$input: Field is required";
    }
  }

  /**
   * Length minimum of characters available.
   * 
   * @param string $input
   * @param string $value
   * @param string $rule
   * @static
   * @return void
   */
  public static function min(string $input, string $value, string $rule): void
  {
    if (strlen($value) < (int) $rule) {
      self::$errors[$input] = "$input is too short";
    }
  }

  /**
   * Length maximum of characters available.
   * 
   * @param string $input
   * @param string $value
   * @param int $rule
   * @static
   * @return void
   */
  public static function max(string $input, string $value, int $rule): void
  {
    if (strlen($value) > $rule) {
      self::$errors[$input] = "$input is too long";
    }
  }

  /**
   * Validation for email address.
   * 
   * @param string $input
   * @param string $value
   * @static
   * @return void
   */
  public static function email(string $input, string $value): void
  {
    if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
      self::$errors[$input] = "Email address not valid";
    }
  }

  /**
   * Set rules for create a valid title of posts.
   * 
   * @param string $input
   * @param string $value
   * @static
   * @return void
   */
  public static function title(string $input, string $value): void
  {
    if (!preg_match("/^([a-z0-9\s]+)([\?!]*)([a-z]*)$/i", $value)) {
      self::$errors[$input] = "Allowed only alpha characters, question and exclamation mark";
    }
  }

  /**
   * Rule that allowed of enterd only alpha characters.
   * 
   * @param string $input
   * @param string $value
   * @static
   * @return void
   */
  public static function string(string $input, string $value): void
  {
    if (!preg_match("/^([a-z]+)$/i", $value)) {
      self::$errors[$input] = "Allowed only alpha characters";
    }
  }

  /**
   * Rule that allowed of enterd only numeric characters.
   * 
   * @param string $input
   * @param string $value
   * @static
   * @return void
   */
  public static function number(string $input, string $value): void
  {
    if (preg_match("/^([a-z]+)$/i", $value)) {
      self::$errors[$input] = "Allowed only number characters";
    }
  }

  /**
   * Check if a date entered is older of the current time.
   *
   * @param string $input
   * @param string $value
   * @static
   * @return void
   */
  public static function now(string $input, string $value): void
  {
    $time = date_timestamp_get(date_create($value));
    if ($time < time()) {
      self::$errors[$input] = "The date cannot be older of the current time";
    }
  }

  /**
   * Check if the value of a record is unique.
   *
   * @param string $input
   * @param string $value
   * @param array $rule
   * @return void
   */
  public static function unique(string $input, string $value, array $rule)
  {
    $obj = $rule[1];
    $record = $obj->findWhere($input, $value);
    // Check if the second part of the URI is composed by numbers, ID of resource. 
    if (! preg_match("/\/([a-z]+)\/([0-9]+)/", Request::uri())) {
      if ($record !== false) {
        self::$errors[$input] = "$value has been already used, change it";
      }
    } 
  }

  /**
   * Verify if the field password is matched with the field password-confirm.
   *
   * @return void
   */
  public static function match_password(): void
  {
    if (Request::post('password') !== Request::post('password-confirm')) {
			$errors[] = "Password not matched!";
		}
  }

  /**
   * Display all errors stored.
   *
   * @static
   * @return mixed
   */
  public static function getErrors(): mixed
  {
    if (count(self::$errors) > 0) {
      if (Session::has('errors')) {
        unset($_SESSION['errors']);
      }
      return Session::set('errors', self::$errors);
    }

    return null;
   
  }

   /**
   * Storing data in a session get from a form.
   * 
   * @param array $errors
   * @param string $path
   * @static
   * @return void
   */
  public static function storingSession(array $errors, string $path): void
  {
    Request::validate($errors);
    Session::set('data-form', Request::all());
    Redirect::to($path); 
  }

  /**
   * Remove the session generated by errors from validation of a form
   * and remove the session contained the data enteed in a form before
   * of the message of error.
   *
   * @static
   * @return void
   */
  public static function unsetSession(): void
  {
    Session::remove('errors');
    Session::remove('data-form');
  }

  /**
   * Update sessions for validation data.
   *
   * @param object $updatePost
   * @static
   */
  public static function updateSession(object $updatePost, array $errors, string $path)
  {
    if (Request::validate($errors) !== null) {
      return redirect($path . $updatePost->post_name);
    } elseif (Session::has('errors')) {
      Session::remove('errors');
    } else {
      return null;
    }
  }
}
