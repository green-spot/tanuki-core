<?php

namespace GreenSpot\Tanuki;

class PostHandlerPipeline {
  /** @var PostHandlerInterface[] */
  private array $handlers = [];

  public function addHandler(PostHandlerInterface $handler): void {
    $this->handlers[] = $handler;
  }

  public function handle(array $formData): void {
    foreach($this->handlers as $handler) {
      $handler->handle($formData);
    }
  }
}
