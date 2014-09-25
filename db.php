<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.09.14
 * Time: 10:02
 */

class Database{
    private $host='localhost';
    private $user='root';
    private $pass='1234';
    private $db_name='plan';
    private $connect;
    private static $instance;

    private function __construct()
    {
        $this->connect=mysql_connect($this->host,$this->user,$this->pass) or die('sorry DataBase error');
        mysql_select_db($this->db_name,$this->connect);
    }
    private function __clone(){}

    public static function get_instance()
    {
        self::$instance?:self::$instance=new self;
        return self::$instance;
    }
    public function get_group_list()
    {
        $result=array();
        $query='SELECT * FROM group_list';
        $rows=mysql_query($query) or die();
        while($row=mysql_fetch_assoc($rows))
        {
            $result[]=$row;
        }
        if(count($result)>0)
            return $result;
    }

    public function get_layout_list()
    {
        $result=array();
        $query='SELECT id, name FROM layout';
        $rows=mysql_query($query) or die();
        while($row=mysql_fetch_assoc($rows))
        {
            $result[]=$row;
        }
        if(count($result)>0)
            return $result;
    }

}