<?php

namespace GreenSpot\Tanuki\Factory;

use GreenSpot\Tanuki\Field\FieldInterface;
use GreenSpot\Tanuki\Field\TextField;
use GreenSpot\Tanuki\Field\EmailField;
use GreenSpot\Tanuki\Field\TextAreaField;

class FieldFactory
{
  /** @var array<string, string> */
  private array $typeMap = [];

  public function __construct() {
    $this->registerField('text', TextField::class);
    $this->registerField('email', EmailField::class);
    $this->registerField('textarea', TextAreaField::class);
  }

  /**
   * * @param string $type フィールドタイプ識別子 (例: 'image')
   * @param string $className FieldInterfaceを実装したクラス名
   */
  public function registerField(string $type, string $className): void{
    if (!is_a($className, FieldInterface::class, true)) {
      throw new \InvalidArgumentException("Class {$className} must implement FieldInterface.");
    }
    $this->typeMap[$type] = $className;
  }

  public function create(array $fieldData): FieldInterface {
    $type = $fieldData['type'] ?? null;

    if (!isset($this->typeMap[$type])) {
      throw new \InvalidArgumentException("Unsupported field type: {$type}. Is the field registered?");
    }

    $className = $this->typeMap[$type];
    $field = new $className($fieldData['name'], $fieldData['label']);

    foreach($fieldData['validation'] as $name => $args){
      $field->addValidation($name, $args);
    }

    return $field;
  }
}
