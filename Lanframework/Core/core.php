<?php
namespace Core;
define("ROOT",$_SERVER['DOCUMENT_ROOT']);
define("LAN_ROOT",$_SERVER['DOCUMENT_ROOT']."/Lanframework");
define("CONFIG",include_once(LAN_ROOT.'/config.php'));

Class Core{
function run(){
  spl_autoload_register([__CLASS__,'autoloader']);
  set_exception_handler([__CLASS__,'exceptionHandler']);
  $secure=new \Secure\secure();
  $secure->init();
  $RequestUri = $_SERVER['REQUEST_URI'];
  $route=new \Route\router();
  $obj=$route->init($RequestUri);
}
static public function exceptionHandler($e){
  new \Render\render(array('error'=>array('info'=>$e->getMessage(),'code'=>$e->getCode(),'line'=>$e->getLine(),'file'=>$e->getFile(),'debug'=>$e->getTrace())),LAN_ROOT.'/Template/common/error.php');
}
function autoloader($classname){
  if(DIRECTORY_SEPARATOR!='\\'){
    $classname=str_replace("\\","/",$classname);
  }
  $classpath=LAN_ROOT."/".$classname.'.php';
   if(file_exists($classpath)){
    include_once($classpath);
   }
  }
}
?>
