<?php

namespace GreenSpot\Tanuki;

use GreenSpot\Tanuki\FormSchemaProvider\JsonFormSchemaProvider;

class Tanuki {
  public Factory\FieldFactory $fieldFactory;
  public FormSchemaProviderInterface $formSchemaProvider;
  public Validator $validator;

  public function __construct(array $config=[]) {
    $this->fieldFactory = isset($config["fieldFactory"]) ? $config["fieldFactory"] : new Factory\FieldFactory();
    $this->validator = isset($config["validator"]) ? $config["validator"] : new Validator();

    if(!isset($config["schemaDir"])) {
      throw new \InvalidArgumentException("'schemaDir' is required in config");
    }
    $this->formSchemaProvider = new JsonFormSchemaProvider(rtrim($config["schemaDir"], "/") . "/");
  }

  public function createForm(string $name): Form {
    $schema = $this->formSchemaProvider->getSchema($name, $this->fieldFactory);
    $form = new Form($name, $schema, $this->validator);

    return $form;
  }
}
