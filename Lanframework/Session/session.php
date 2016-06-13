<?php
namespace Session;
class session{
  private function sign($str,$secret){
    return md5(crypt($str,$secret));
  }
  function initSession(){
    if($_COOKIE[session_name()]){
      session_id($_COOKIE[session_name()]);
      setcookie(session_name(),$_COOKIE[session_name()],time()+3600);
      session_start();
    }else{
    unset($_SESSION);
    $name=mt_rand(10000,99999);
    $secret=CONFIG['session']['secret'];
    $expire=time()+3600;
    $val=$this->sign($name,$secret);//防止xss攻击,通过cookie伪造session
    setcookie(session_name(),$val,$expire);
    session_id($val);
    session_start();
}
return $this;
  }
  function checkSession($arr){
    if(!empty($_SESSION['userid'])||$arr['module']==CONFIG['router']['login']){
      return true;
    }
    else if(CONFIG['session']['lock']=='false'){
      return true;
    }
    else {
      return false;
    }
  }
}
 ?>
