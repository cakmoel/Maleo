<?php

class PostGateway extends BaseGateway
{
    
 public function __construct($dbAdapter)
 {
  parent::__construct($dbAdapter);      
 }
 
 protected function findObjectName()
 {
   return "Post";  
 }
    
 protected function findTableName()
 {
   return "Posts";  
 }
    
 protected function findOrderFields()
 {
   return "post_title";
 }
 
 public function findPosts()
 {
     
 }
}