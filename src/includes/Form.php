<?php

namespace GreenSpot\Tanuki;

class Form {
  public string $name;
  private FormSchema $schema;
  private Validator $validator;
  private PostHandlerPipeline $postHandlers;

  public array $postData;
  public array $validationErrors = [];
  public array $handleErorrs = [];

  public function __construct(string $name, FormSchema $schema, Validator $validator) {
    $this->name = $name;
    $this->schema = $schema;
    $this->validator = $validator;
  }

  public function addPostHandler(PostHandlerInterface $postHandler){
    $this->postHandlers->addHandler($postHandler);
  }

  public function bind(array $data){
    $this->postData = [];

    foreach($this->schema->fields as $field){
      $this->postData[$field->name] = $data[$field->name] ?? null;
    }
  }

  public function validate(){
    $success = true;

    foreach($this->schema->fields as $field){
      $value = $this->postData[$field->name] ?? '';

      foreach($field->validators as $validatorName => $args){
        $isValid = $this->validator->validate($validatorName, $value, $this->postData, $args);
        if(!$isValid){
          $success = false;
          $this->addValidationError($field->name, $validatorName);
        }
      }
    }

    return $success;
  }

  public function send(){
    return $this->postHandlers->handle($this->postData);
  }

  private function addValidationError(string $field, string $vname){
    if(isset($this->errors[$field])){
      $this->validationErrors[$field] = [$vname];
    }else{
      $this->validationErrors[$field][] = $vname;
    }
  }
}
