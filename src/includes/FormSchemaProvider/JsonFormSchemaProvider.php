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
    $path = $this->findSchemaPath($identifier);
    return is_file($path) && is_readable($path);
  }

  public function getSchema(string $identifier, FieldFactory $fieldFactory): FormSchema {
    $path = $this->findSchemaPath($identifier);
    $data = json_decode(file_get_contents($path), true);

    $schema = new FormSchema;

    foreach($data as $_field){
      $schema->addField($fieldFactory->create($_field));
    }

    return $schema;
  }

  private function findSchemaPath(string $identifier): ?string {
    $base = $this->schemaDir;

    $candidates = [
      // contact.json
      "{$base}{$identifier}.json",

      // contact/schema.json
      "{$base}{$identifier}/schema.json",

      // contact/contact.json
      "{$base}{$identifier}/{$identifier}.json",
    ];

    foreach ($candidates as $path) {
      if (is_file($path) && is_readable($path)) {
        return $path;
      }
    }

    return null;
  }
}
