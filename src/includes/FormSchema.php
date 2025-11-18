<?php

namespace GreenSpot\Tanuki;

use GreenSpot\Tanuki\Field\AbstractField;

class FormSchema {
  /** @var AbstractField[] */
  public array $fields;

  public function __construct() {
  }

  public function addField(AbstractField $field){
    $this->fields[] = $field;
  }
}
