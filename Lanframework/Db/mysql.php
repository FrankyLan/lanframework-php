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
		$this->connect();
    }
    private function connect( $is_master = true )
    {

        if( !$db = mysqli_connect( $this->host . ':' . $this->port , $this->accesskey , $this->secretkey ) )
        {
            die('can\'t connect to mysql ' . $this->host . ':' . $this->port );
        }
        mysqli_set_charset($db,'utf8');
        mysqli_select_db($db,$this->appname);

        return $db;
    }

    private function db_any()
    {

    }

    private function db_read()
    {
        if( isset( $this->db_read ) )
        {
            mysqli_ping( $this->db_read );
            return $this->db_read;
        }
        else
        {
            if( !$this->do_replication ) return $this->db_write();
            else
            {
                $this->db_read = $this->connect( false );
                return $this->db_read;
            }
        }
    }

    private function db_write()
    {
        if( isset( $this->db_write ) )
        {
            mysqli_ping( $this->db_write );
            return $this->db_write;
        }
        else
        {
            $this->db_write = $this->connect( true );
            return $this->db_write;
        }
    }

    public function save_error()
    {
        $GLOBALS['SAE_LAST_ERROR'] = mysqli_error($this->do_replication ? $this->db_read() : $this->db_write());
        $GLOBALS['SAE_LAST_ERRNO'] = mysqli_errno($this->do_replication ? $this->db_read() : $this->db_write());
    }


    public function runSql( $sql )
    {
        $ret = mysqli_query($this->db_write(),$sql);
        $this->save_error();
        return $ret;
    }

    public function getdata( $sql )
    {
        $GLOBALS['SAE_LAST_SQL'] = $sql;
        $data = Array();
        $i = 0;
        $result = mysqli_query($this->do_replication ? $this->db_read() : $this->db_write() ,$sql);

        $this->save_error();

        while( $Array = mysqli_fetch_array($result, MYSQLI_ASSOC ) )
        {
            $data[$i++] = array_change_key_case($Array);
        }


        if( mysqli_errno($this->do_replication ? $this->db_read() : $this->db_write()) != 0 )
            echo mysqli_error($this->do_replication ? $this->db_read() : $this->db_write()) .' ' . $sql;


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
        $result = mysqli_query($this->db_write(), "SELECT LAST_INSERT_ID()"  );
        return reset( mysqli_fetch_array( $result, MYSQLI_ASSOC ) );
    }

    public function closedb()
    {
        if( isset( $this->db_read ) )
            @mysqli_close( $this->db_read );

        if( isset( $this->db_write ) )
            @mysqli_close( $this->db_write );

    }

    public function escape( $str )
    {
        if( isset($this->db_read)) $db = $this->db_read ;
        elseif( isset($this->db_write) )    $db = $this->write;
        else $db = $this->db_read();

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
    public function getPageList($sql,$page=1,$rows=20){
      $offset=$page-1;
      $list=$this->getdata($sql);
      $count=count($list);
      $arr=array_slice($list,intval($offset)*20,$rows);
      return array('list'=>$arr,'count'=>$count,'rows'=>$rows,'page'=>$page);
    }
}

?>
