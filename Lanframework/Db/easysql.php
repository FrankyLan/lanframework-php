<?php
namespace Db;
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
class easysql{
function insert($post,$table)  {
foreach ($post as $key => $value)
{
  if($value==''){
    continue;
  }
    $$key=$this->sql_safe($value);
		$param1.=$key.",";
		$param2.="'".$$key."',";
}
$insert_sql="insert into `".$table."`(".substr($param1,0,strlen($param1)-1).") values (".substr($param2,0,strlen($param2)-1).")";
return $insert_sql;
}
function insert_nosafe($post,$table)  {
foreach ($post as $key => $value)
{
  if($value==''){
    continue;
  }
    $$key=addslashes($value);
		$param1.=$key.",";
		$param2.="'".$$key."',";
}
$insert_sql="insert into `".$table."`(".substr($param1,0,strlen($param1)-1).") values (".substr($param2,0,strlen($param2)-1).")";
return $insert_sql;
}
function update($post,$table,$param){
  foreach ($post as $key => $value)
  {
    if($value==''){
      continue;
    }
      $$key=$this->sql_safe($value);
  		$param3.=$key."='".$$key."',";
  }
  $update_sql="update `".$table."` set ".substr($param3,0,strlen($param3)-1)." where 1=1 and ".$this->sql_safe($param)."";
return $update_sql;
}
function update_nosafe($post,$table,$param){
  foreach ($post as $key => $value)
  {
    if($value==''){
      continue;
    }
      $$key=addslashes($value);
  		$param3.=$key."='".$$key."',";
  }
  $update_sql="update `".$table."` set ".substr($param3,0,strlen($param3)-1)." where 1=1 and $param";
return $update_sql;
}
function setparam($state, $sql, $param){
  if($state=='')
  return $sql;
  else {
    return $sql."and".$this->sql_safe($param)." ";
  }
}
function sql_safe($string) {
	$string = str_replace('%20','',$string);
	$string = str_replace('%27','',$string);
	$string = str_replace('%2527','',$string);
	$string = str_replace('*','',$string);
	$string = str_replace('"','"',$string);
	$string = str_replace("'",'',$string);
	$string = str_replace('"','',$string);
	$string = str_replace(';','',$string);
	$string = str_replace('<','<',$string);
	$string = str_replace('>','>',$string);
	$string = str_replace("{",'',$string);
	$string = str_replace('}','',$string);
	$string = str_replace('\\','',$string);
	$string = str_replace('\0','',$string);
	return $string;
}
}
?>
