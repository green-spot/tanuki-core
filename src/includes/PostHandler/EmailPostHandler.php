<?php

namespace GreenSpot\Tanuki\PostHandler;

use GreenSpot\Tanuki\PostHandlerInterface;

class EmailPostHandler implements PostHandlerInterface {
  public array $config = [];

  public function __construct(array $config = []) {
    $this->config = $config;
  }

  public function handle(array $formData): void {
    // Implementation for handling form data and sending email
  }
}
