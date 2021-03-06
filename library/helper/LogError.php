<?php 
/**
 * Class LogError
 * Handling Error Log
 *
 * @author    Maoelana Noermoehammad
 * @license   MIT
 * @version   Beta
 * @since     Since Release Betae
 */
class LogError
{
	/**
	 *
	 * @var string
	 */
	private static $_printError = false;
	
	protected $logError = APP_SYSPATH . APP_PATH . DS . 'log';
	
	/**
	 * @method customErrorMessage
	 */
	public static function customErrorMessage()
	{
		 
	echo '<section class="row page-header">
          <div class="container">
           <h4>ERROR</h4>
          </div>
          </section>';
	    
	  echo '<section class="row blog-content page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                            
   <div class="alert alert-danger alert-dismissable">
			
          <h3>ERROR!</h3>	
          <p> 
           Please check your error log and send it to - email: webdev@kartatopia.com </p>
				
    </div>      
                     
                </div>
             </div>
        </div>
    </section>';
	  
	  exit();
			
	}
	
	/**
	 * exception handler
	 *
	 * @method exceptionHandler
	 * @param string $e
	 */
	public static function exceptionHandler($e)
	{
		self::newMessage($e);
		self::customErrorMessage();
	}
	
	
	/**
	 *
	 * errorHandler
	 *
	 * @method errorHandler
	 * @param integer $errorNumber
	 * @param string $errorString
	 * @param string $file
	 * @param string $line
	 * @return number
	 */
	public static function errorHandler($errorNumber, $errorString, $file, $line)
	{
		
	  if (!(error_reporting() & $errorNumber)) {
		  
	      return false;
	  }
		  
	  switch ($errorNumber) {
		    
	      case E_PARSE:
	      case E_ERROR:
	      case E_CORE_ERROR:
	      case E_COMPILE_ERROR:
		  case E_USER_ERROR:
		        
		       $errorMessage = "<b>ERROR: </b> [$errorNumber] - $errorString<br />\n";
		       $errorMessage .= " Fatal error on line $line in file $file";
		       $errorMessage .= " PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
		       
		       self::errorMessage($errorMessage);
		       self::customErrorMessage();
		       
		       break;
		      
		   case E_WARNING:
		   case E_COMPILE_WARNING:
		   case E_RECOVERABLE_ERROR:
		   case E_USER_WARNING :
		        
		       $errorMessage = "<b>WARNING: </b> [$errorNumber] - $errorString<br />\n";
		       
		         self::errorMessage($errorMessage);
		         self::customErrorMessage();
		       
		         break;
		      
		   case E_NOTICE:
		   case E_USER_NOTICE :
		        
		      $errorMessage = "<b>NOTICE: </b> [$errorNumber] - $errorString";
		        
		       self::errorMessage($errorMessage);
		       self::customErrorMessage();
		       
		       break;
		       
		   default:
		        
		        $errorMessage =  "Unknown error type: [$errorNumber] - $errorString<br />\n";
		        
		        self::errorMessage($errorMessage);
		        self::customErrorMessage();
		        
		        break;
		}
		
		/* Don't execute PHP internal error handler */
		return true;
		
	}
	
	/**
	 * @static method newMessage
	 * @param Exception $exception
	 * @param string $_printError
	 * @param string $clear
	 * @param string $error_file
	 */
	
	public static function newMessage(Exception $exception, $_printError = false, $clear = false, $error_file = 'logerror.html')
	{
	    
	    $message = $exception->getMessage();
	    $code = $exception->getCode();
	    $file = $exception->getFile();
	    $line = $exception->getLine();
	    $trace = $exception->getTraceAsString();
	    $date = date('M d, Y G:iA');
	    
	    $log_message = "<h3>Exception information:</h3>\n
		<p><strong>Date:</strong> {$date}</p>\n
		<p><strong>Message:</strong> {$message}</p>\n
		<p><strong>Code:</strong> {$code}</p>\n
		<p><strong>File:</strong> {$file}</p>\n
		<p><strong>Line:</strong> {$line}</p>\n
		<h3>Stack trace:</h3>\n
		<pre>{$trace}</pre>\n
		<hr />\n";
	    
	    if(is_file($this->logError . $error_file)===false) {
	        file_put_contents($this->logError . $error_file, '');
	    }
	    
	    if($clear) {
	        $content = '';
	    } else {
	        $content = file_get_contents($this->logError . $error_file);
	    }
	    
	    file_put_contents($this->logError . $error_file, $log_message . $content);
	    
	    if($_printError == true){
	        echo $log_message;
	        
	        exit();
	        
	    }
	    
	}
	
	/**
	 * @static method errorMessage
	 * @param string $error
	 * @param string $_printError
	 * @param string $error_file
	 */
	public static function errorMessage($error, $_printError = false, $error_file =  'errorlog.html')
	{
	    
	    $date = date('M d, Y G:iA');
	    $log_message = "<p>Error on $date - $error</p>";
	    
	    if(is_file($this->logError . $error_file) === false ) {
	        file_put_contents($this->logError . $error_file, '');
	    }
	    
	    $content = file_get_contents($this->logError . $error_file);
	    file_put_contents($this->logError . $error_file, $log_message . $content);
	    
	    if($_printError == true){
	        echo $log_message;
	        
	        exit();
	        
	    }
	    
	}
	
}