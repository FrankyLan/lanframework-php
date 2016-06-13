<?php
namespace Render;
class render{
  function __construct($arr='',$path='',$mode=CONFIG['render']['mode']){
    if($mode==1){
      $this->renderJson($arr);
    }
    else{
      $this->easyRenderOut($arr,$path);
    }
  }
  private function easyRenderOut($arr=[],$path){//简易渲染函数,通过缓存控制输出.
    if(explode('.',$path)[1]=='html'){
      echo file_get_contents($path);
      exit();
    }
    ob_start();
    if(!empty($arr)){
    foreach($arr as $key=>$value){//将键名映射为变量名
    $$key=$value;
    }
  }
    try{
    require_once($path);
  }catch(Exception $e){
    Throw new \Exception('文件不存在','402');
    exit();
  }
    $out = ob_get_clean();
    echo $out;
  }
  private function renderJson($arr){
  echo json_encode($arr);
  }
}
 ?>
