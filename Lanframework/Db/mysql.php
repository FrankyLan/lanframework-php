<?php
namespace Db;
class Mysql
{
    function __construct( $do_replication=true )
    {
        $this->port = CONFIG['database']['port'];
		$this->host =CONFIG['database']['host'];

		$this->accesskey = CONFIG['database']['accesskey'];
		$this->secretkey = CONFIG['database']['secretkey'];
		$this->appname = CONFIG['database']['appname'];

		//set default charset as utf8
		$this->charset = CONFIG['database']['charset'];

		$this->do_replication = $do_replication;
    $this->link= mysqli_connect( $this->host . ':' . $this->port , $this->accesskey ,$this->secretkey,$this->appname);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    }
    public function save_error()
    {
        $GLOBALS['SAE_LAST_ERROR'] = mysqli_error($this->link);
        $GLOBALS['SAE_LAST_ERRNO'] = mysqli_errno($this->link);

    }


    public function runSql( $sql )
    {
        $ret = mysqli_query($this->link,$sql);
        $this->save_error();
        $GLOBALS['SAE_LAST_SQL']=$sql;
        return $ret;
    }

    public function getdata( $sql )
    {
        $GLOBALS['SAE_LAST_SQL'] = $sql;
        $data = Array();
        $i = 0;
        $result = mysqli_query($this->link,$sql);

        $this->save_error();

        while( $Array = mysqli_fetch_array($result, MYSQLI_ASSOC ) )
        {
            $data[$i++] = array_change_key_case($Array);
        }


        if( mysqli_errno($this->link) != 0 )
            echo mysqli_error($this->link) .' ' . $sql;


        mysqli_free_result($result);

        if( count( $data ) > 0 )
            return $data;
        else
            return false;
    }

    public function getline( $sql )
    {
        $data = $this->getdata( $sql );
        return @reset($data);
    }

    public function getvar( $sql )
    {
        $data = $this->getline( $sql );
        return $data[ @reset(@array_keys( $data )) ];
    }

    public function lastid()
    {
        $result = mysqli_query($this->link, "SELECT LAST_INSERT_ID()"  );
        return reset( mysqli_fetch_array( $result, MYSQLI_ASSOC ) );
    }

    public function closedb()
    {
        if( isset( $this->link) )
            @mysqli_close( $this->link);
    }

    public function escape( $str )
    {
        $db =  $this->link;
        return mysql_real_escape_string( $str , $db );
    }

    public function errno()
    {
        return     $GLOBALS['SAE_LAST_ERRNO'];
    }

    public function error()
    {
        return $GLOBALS['SAE_LAST_ERROR'];
    }
    public function lastsql(){
      return  $GLOBALS['SAE_LAST_SQL']; 
    }
    public function errmsg(){
      return $GLOBALS['SAE_LAST_ERROR'];
    }
    public function setparam($state, $sql, $param){
      if($state=='')
      return $sql;
      else {
        return $sql." and ".$param ." ";
      }
    }
    public function ifparam($state, $sql, $param){
      if(!$state)
      return $sql;
      else {
        return $sql." ".$param ." ";
      }
    }
    public function getPageList($sql,$page=1,$rows=10){
      $offset=$page-1;
      $list=$this->getdata($sql);
      $count=count($list);
      $arr=array_slice($list,intval($offset)*$rows,$rows);
      return array('list'=>$arr,'count'=>$count,'rows'=>$rows,'page'=>$page);
    }
}

?>
