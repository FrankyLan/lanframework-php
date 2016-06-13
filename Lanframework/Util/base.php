<?php
namespace Util
class base{
  function redirect($url){
    header("Location:$url");
  }
  function setHeader($event,$val){
    try{
    header("$event:$val");
  }catch(Exception $e){
    Throw new \Exception('错误的HTTP包头定义','01');
  }
  }
  function returnAjax($arr,$mode='json'){
    return json_encode($arr);
  }
  function generateToken(){//随机生成token，防止表单注入、CSRF攻击时运用
    return md5(time().rand(1,1000));
  }
}
 ?>
