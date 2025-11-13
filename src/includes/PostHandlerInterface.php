<?php

namespace GreenSpot\Tanuki;

interface PostHandlerInterface {
  public function handle(array $formData): void;
}
