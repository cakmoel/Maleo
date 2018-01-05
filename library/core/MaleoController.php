<?php
namespace Maleo\core;

use Maleo\helper\LinkBuilder;

/**
 * class MaleoController
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 */
class MaleoController
{
 /**
  * Registry Object
  * 
  * @var string
  */
 protected $registry;
 
 /**
  * Database
  * 
  * @var string
  */
 protected $db;
 
 /**
  * View
  *  
  * @var string
  */
 public $view;
 
 /**
  * link builder
  *  
  * @var string
  */
 public $linkBuilder;
 
 /**
  * constructor
  * 
  * @param string $registry
  */
 public function __construct($registry)
 {
   $this->registry = $registry;
   $this->db = $registry->db;
   $this->view = $registry->view;
   $this->linkBuilder = new LinkBuilder();
   //$this->linkBuilder->add('Home', APP_URL);
 }
 
 /**
  * Finding request as registry object
  * 
  * @return string
  */
 protected function findRequest()
 {
   return $this->registry->request;
 }
 
 /**
  * pre dispatching view
  */
 public function preDispatch()
 {
   $this->view->linkBuilder = $this->linkBuilder;
   $this->view->title = $this->linkBuilder->getTitle();
 }
 
 /**
  * destructor
  */
 public function __destruct()
 {
   $this->preDispatch();
   $this->view->dispatch();
 }
 
}