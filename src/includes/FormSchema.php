<?php

namespace GreenSpot\Tanuki;

use GreenSpot\Tanuki\Field\FieldInterface;

class FormSchema {
  public array $fields;

  public function __construct() {
  }

  public function addField(FieldInterface $field){
    $this->fields[] = $field;
  }
}
