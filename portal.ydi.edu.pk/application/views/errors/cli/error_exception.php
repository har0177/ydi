<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo "\nException: " . get_class($exception) . "\nMessage: $message\nFile: " . $exception->getFile() . "\nLine: " . $exception->getLine() . "\n";
