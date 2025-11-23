<?php

namespace GreenSpot\Tanuki;

use GreenSpot\Tanuki\Factory\FieldFactory;
use GreenSpot\Tanuki\Field\AbstractField;

class FormSchema {
  /** @var AbstractField[] */
  public array $fields;

  public function __construct() {
  }

  public function addField(AbstractField $field){
    $this->fields[] = $field;
  }

  public static function fromArray(array $schema, FieldFactory $fieldFactory): self {
    $formSchema = new self;

    foreach($schema as $_field){
      $formSchema->addField($fieldFactory->create($_field));
    }

    return $formSchema;
  }
}
