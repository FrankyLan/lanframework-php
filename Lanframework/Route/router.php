<?php
namespace Route;
class router{
  function init($RequestUri){
    $arr=$this->processUrl($RequestUri);
    $session=new \Session\session();
    if(!$session->initSession()->checkSession($arr)){
      if($this->isAction($arr['module'],$arr['action'])){
        $_SESSION['last_url']=$_SERVER['REQUEST_URI'];
      }
      header("Location:".CONFIG['router']['index']);
    }
    return $this->loadAction($arr['module'],$arr['action'],$arr['arg']);
  }
  function processUrl($RequestUri,$type=0){
    switch($type){
      case 0:
      return $this->pathRoute($RequestUri);
      break;
      default:
      exit();
      break;
    }
  }
  function pathRoute($url){
  $url=strtolower(explode("?",$url)[0]);
  $url=substr($url,1);
  $MatchUrl=explode("/",$url);
  return array('module'=>$MatchUrl[0],'action'=>$MatchUrl[1],'arg'=>array(array_slice($MatchUrl,2)));
}
function isAction($module,$action){
  spl_autoload_register([__CLASS__,'autoloader']);

  $path=empty(CONFIG['router']['module_path'])?(LAN_ROOT.'/Controller/'):(ROOT.CONFIG['router']['module_path']);
  $filepath=$path.$module.'.php';
  if(file_exists($filepath)&method_exists($module,$action)){
return true;
  }
  else {
    return false;
  }
}
  function loadAction($module,$action,$arg=''){
    spl_autoload_register([__CLASS__,'autoloader']);

    $path=empty(CONFIG['router']['module_path'])?(LAN_ROOT.'/Controller/'):(ROOT.CONFIG['router']['module_path']);
    $filepath=$path.$module.'.php';
    if(file_exists($filepath)&method_exists($module,$action)){
        $ref = new $module;
        return $ref->$action($arg);
    }
    else {
      Throw new \Exception('错误的网址','404');
    }
  }
  function autoloader($classname){
    $path=empty(CONFIG['router']['module_path'])?(LAN_ROOT.'/Controller/'):(ROOT.CONFIG['router']['module_path']);
    $classpath=$path.$classname.'.php';
     if(file_exists($classpath)){
      include_once($classpath);
     }
    }
}
?>
