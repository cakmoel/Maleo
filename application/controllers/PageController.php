<?php

class PageController extends MaleoController
{
   public function index()
   {
       
   }
   
   public function notfound()
   {
     $this->view->title = 'Page Not Found';
     $this->view->message = 'Page Not Found';
     
   }
   
}