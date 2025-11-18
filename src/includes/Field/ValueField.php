<?php

namespace GreenSpot\Tanuki\Field;

class ValueField extends AbstractField {
  protected string $type = 'value';

  public function normalize(mixed $value): mixed {
    return is_string($value) ? $value : (string)$value;
  }
}
