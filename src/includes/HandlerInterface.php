<?php

namespace GreenSpot\Tanuki;

interface HandlerInterface {
  public function handle(Form $form, HandlerPipelineContext $context): HandlerResult;
}
