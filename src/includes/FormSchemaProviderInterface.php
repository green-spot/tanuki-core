<?php

namespace GreenSpot\Tanuki;

use GreenSpot\Tanuki\Factory\FieldFactory;

interface FormSchemaProviderInterface
 {
  public function supports(string $identifier): bool;
  public function getSchema(string $identifier, FieldFactory $fieldFactory): FormSchema;
}
