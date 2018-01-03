<?php
/**
 * abstrac class BaseController
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 1.0
 */

abstract class BaseController
{
 /**
  * Registry Object
  * @var string
  */
 protected $registry;
 
 /**
  * Database
  * @var string
  */
 protected $db;
 
 /**
  * View 
  * @var string
  */
 public $view;
 
 /**
  * link builder 
  * @var string
  */
 public $linkBuilder;
 
 public function __construct($registry)
 {
   $this->registry = $registry;
   $this->db = $registry->db;
   $this->view = $registry->view;
   $this->linkBuilder = new LinkBuilder();
   //$this->linkBuilder->add('Home', APP_URL);
 }
 
 /**
  * @method findRequest
  * @return request
  */
 protected function findRequest()
 {
   return $this->registry->request;
 }
 
 public function preDispatch()
 {
   $this->view->linkBuilder = $this->linkBuilder;
   $this->view->title = $this->linkBuilder->getTitle();
 }
 
 public function __destruct()
 {
   $this->preDispatch();
   $this->view->dispatch();
 }
 
}