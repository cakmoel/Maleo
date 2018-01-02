<?php

class LinkBuilder
{
 private $_trail = [];
 private $_title;
 
 public function add($title, $link = '')
 {
   
  $this->_title = $title;
  $this->_trail[] = array('title' => $title, 'link' => $link);
   
 }
 
 public function getTrail()
 {
   return $this->_trail;
 }
 
 public function getTitle()
 {
   if (count($this->_trail) == 0) return null;
   
   return $this->_trail[count($this->_trail) - 1]['title'];
   
 }
 
}