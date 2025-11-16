<?php

namespace GreenSpot\Tanuki;

class Validator {
  public array $validators = [];

  public function __construct() {
    $this->addValidator('required', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value)) {
        return !empty($value);
      }
      return trim($value) !== '';
    });

    $this->addValidator('email', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value)) {
        return false;
      }
      return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    });

    $this->addValidator('minLength', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value) || !isset($args[0]) || !is_numeric($args[0])) {
        return false;
      }
      $min = is_numeric($args[0]) ? $args[0] : 0;
      return strlen($value) >= $min;
    });

    $this->addValidator('maxLength', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value) || !isset($args[0]) || !is_numeric($args[0])) {
        return false;
      }
      $max = $args['max'];
      return strlen($value) <= $max;
    });

    $this->addValidator('matchField', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value) || !isset($args[0]) || !isset($postData[$args[0]])) {
        return false;
      }
      $otherValue = $postData[$args[0]] ?? null;
      return $value === $otherValue;
    });

    $this->addValidator('numeric', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value)) {
        return false;
      }
      return is_numeric($value);
    });

    $this->addValidator('inArray', function(string|array $value, array $postData, array|true $args = []): bool {
      if (!isset($args[0]) || !is_array($args[0])) {
        return false;
      }
      $options = $args[0];
      if (is_array($value)) {
        foreach ($value as $v) {
          if (!in_array($v, $options)) {
            return false;
          }
        }
        return true;
      } else {
        return in_array($value, $options);
      }
    });

    $this->addValidator('pattern', function(string|array $value, array $postData, array|true $args = []): bool {
      if (is_array($value) || !isset($args[0])) {
        return false;
      }
      $pattern = $args[0];
      return preg_match("|" . str_replace("|", "\\|", $pattern) . "|", $value) === 1;
    });
  }

  public function validate(string $validatorName, string|array $value, array $postData, array|true $args = []): bool {
    if (!isset($this->validators[$validatorName])) {
      throw new \Exception("Validator {$validatorName} not found");
    }

    $function = $this->validators[$validatorName];
    return $function($value, $postData, $args);
  }

  public function addValidator(string $name, callable $function): void {
    $this->validators[$name] = $function;
  }
}
