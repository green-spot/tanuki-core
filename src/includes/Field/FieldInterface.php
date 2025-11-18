<?php

namespace GreenSpot\Tanuki\Field;

interface FieldInterface {
  public function __construct(string $name, string $label);
  public function getType(): string;
  public function addValidation(string $name, mixed $args = null): self;
  public function addValidations(array $validations): self;
  public function normalize(mixed $value): mixed;
}
