<?php
/**
 * abstract class DomainObject
 * References:
 * http://martinfowler.com/eaaCatalog/rowDataGateway.html
 * https://github.com/codeinthehole/domain-model-mapper
 * http://www.devshed.com/c/a/PHP/PHP-Services-Layers-Data-Mappers
 * 
 * @author lakota developer community
 * @copyright contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 1.0
 * 
 */

abstract class DomainObject
{

/**
 * fields on each domain object within array
 * @var array
 */
protected $fields = [];
/**
 * exception handling
 * @var string
 */
protected $exceptionHandling = true;

/**
 * Error
 * @var string
 */
protected $error;
  
public function __construct($data = [], $exceptionHandling)
{
 $this->exceptionHandling = $exceptionHandling;
 
 foreach ($data as $key => $value) {
     $this->$key = $value;
 }
 
}

/**
 * @method fieldNameList
 * @return string
 */
public static function fieldNameList()
{
  $classNameStatic = get_called_class();
  return implode(",", $classNameStatic::findFieldNames());
}

/**
 * 
 * @param string $name
 * @return boolean
 */
protected function isFieldNameExist($name)
{
 $className = get_class($this);
 return in_array($name, $className::findFieldNames());
}

/**
 * checking field name
 * @param string $name
 * @throws Exception
 */
private function checkFieldName($name)
{
 try {
     
   if (!$this->isFieldNameExist($name) && $this->exceptionHandling) {
      throw new Exception("The field {$name} is not allowed");
   }
   
 } catch (Exception $e) {
    
   $this->error = LogError::newMessage($e);
   $this->error = LogError::customErrorMessage();
   
 }
 
}

public function __get($name)
{
 try {
     
   $accessor = 'find' . ucfirst($name);
   if (method_exists($this, $accessor) && is_callable(array($this, $accessor))) {
      return $this->$accessor;
   }
     
   if (isset($this->fields[$name])) {
      return $this->fields[$name];
   }
   
   if ($this->exceptionHandling) {
     throw new Exception("The field {$name} has not been set yet");
   } else {
     return null;
   }
   
 } catch (Exception $e) {
     
   $this->error = LogError::newMessage($e);
   $this->error = LogError::customErrorMessage();
   
 }
 
}

public function __set($name, $value)
{
 $this->isFieldNameExist($name);
 $mutator = 'set' . ucfirst($name);
 if (method_exists($this, $mutator) && is_callable(array($this, $mutator))) {
    
     $this->$mutator($value);
 
 } else {
  
   if (!is_null($value)) {
      
      $this->fields[$name] = $value;
      
   } else {
     
      $this->fields[$name] = null;

   }
   
 }
 
}

public function __isset($name)
{
 $this->isFieldNameExist($name);
 return isset($this->fields[$name]);
}

public function __unset($name)
{
 $this->isFieldNameExist($name);
  if (isset($this->fields[$name])) {
    unset($this->fields[$name]);
  }
}

public function findXML()
{
 $className = get_class($this);
 $xml = '<'.$className.'>';
 foreach ($className::findFieldNames() as $field) {
    $lower = strtolower($field); 
    if ($this->isFieldNameExist($field)) {
        if (!empty($this->$field)) {
            $xml .= '<'.$lower.'>'.htmlentities($this->$field).'<'.$lower.'>';
        }
    }
 }
 
 $xml .= '</'.$className.'>';
 return $xml;
 
}

}