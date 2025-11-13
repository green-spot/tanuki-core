<?php

namespace GreenSpot\Tanuki\FormSchemaProvider;

use GreenSpot\Tanuki\Factory\FieldFactory;
use GreenSpot\Tanuki\FormSchema;
use GreenSpot\Tanuki\FormSchemaProviderInterface;

class JsonFormSchemaProvider implements FormSchemaProviderInterface {
  public string $schemaDir;

  public function __construct(string $schemaDir) {
    $this->schemaDir = rtrim($schemaDir, "/") . "/";
  }

  public function supports(string $identifier): bool {
    $path = $this->getFilePath($identifier);
    return is_file($path) && is_readable($path);
  }

  public function getSchema(string $identifier, FieldFactory $fieldFactory): FormSchema {
    $path = $this->getFilePath($identifier);
    $data = json_decode(file_get_contents($path), true);

    $schema = new FormSchema;

    foreach($data as $_field){
      $schema->addField($fieldFactory->create($_field));
    }

    return $schema;
  }

  private function getFilePath(string $identifier): string {
    return $this->schemaDir . $identifier . ".json";
  }
}
