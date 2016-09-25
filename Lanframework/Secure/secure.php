<?php
namespace Secure;
class secure{
  public function init(){
    $xssfilter=new \Secure\xssFilter();//防范XSS攻击，过滤script字符等
    foreach($_GET as $key=>$value){
      $_GET[$key]=$xssfilter->clean($value);
    }
    foreach($_POST as $key=>$value){
      $_POST[$key]=$xssfilter->clean($value);
    }
    $RequestUri = $_SERVER['REQUEST_URI'];
  $_SERVER['REQUEST_URI']=$xssfilter->clean($RequestUri);

  }
  }
 ?>
