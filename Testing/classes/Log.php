<?php

class Log
{
 
  public $path;
 
  public function __construct($path)
  {
    $this->path = $path;   
  }
 
  public function message($messages)
  {
    $file = fopen($this->path, 'a');
    fwrite($file, $messages . "\n");
    fclose($file);
  }
 
}