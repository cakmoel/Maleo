<?php
/**
 * abstrac class BaseController
 * @author maoelana
 *
 */

abstract class BaseController
{
 protected $registry;
 protected $db;
 public $view;
 public $linkBuilder;
 
 public function __construct($registry)
 {
   $this->registry = $registry;
   $this->db = $registry->db;
   $this->view = $registry->view;
   $this->linkBuilder = new LinkBuilder();
   //$this->linkBuilder->add('Home', APP_URL);
 }
 
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