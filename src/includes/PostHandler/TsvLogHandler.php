<?php

namespace GreenSpot\Tanuki\PostHandler;

use GreenSpot\Tanuki\PostHandlerInterface;

class TsvLogHandler implements PostHandlerInterface {
  public array $config = [];

  public function __construct(array $config = []) {
    $this->config = $config;
  }

  public function handle(array $formData): void {
    $path = rtrim($this->config['path'] ?? dirname($_SERVER['SCRIPT_FILENAME']), '/') . '/log.tsv';
    $output = fopen($path, 'a');
    fputcsv($output, $formData, "\t");
    fclose($output);
  }
}
