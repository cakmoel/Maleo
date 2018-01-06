<?php

class IndexController extends MaleoController
{
  public function index()
  {
    $post_title = "Hello World, My name is Maleo";
    $post_subtitle = "I am from Sulawesi, Indonesia";
    
    $this->view->post_title = $post_title;
    $this->view->post_subtitle = $post_subtitle;
    
  }
}