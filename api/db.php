<?php
date_default_timezone_set("Asia/Taipei");
session_start();
class DB
{

    // $dsn 用來作為 PDO的資料庫設定 dbname為使用的資料庫名稱
    // $table 使用的資料表明稱
    // $pdo PDO的物件名稱

    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=web03";
    protected $pdo;
    protected $table;

    // 建立建構式，在建構時帶入table名稱，會建立資料庫的連線
    // 建構式為物件被實例化(new DB)時會先執行的方法

    public function __construct($table)
    {
        // 將物件內部的$table值設為帶入的$table 
        $this->table = $table;

        // 將物件內部的$pdo值設定為，PDO建立的資料庫連建物件
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    // 此方法僅供類別內部使用，外部無法呼叫
    // 帶入的參數必須為key-value型態的陣列
    // 陣列透過foreach轉化為`key`=`value`的字串存入陣列中
    // 回傳此字串陣列供其他方法使用

    protected function a2s($array){
        foreach($array as $key=>$value){
            // 如果陣列的key名有id的，則跳過不處理
            if($key!='id'){
                // 將$key和$value組成SQL語法的字串後加入到一個暫存的陣列中
                $tmp[]="`$key`='$value'";
            }
        }
        // 回傳暫存的陣列
        return $tmp;
    }

    // 此方法僅供類別內部使用，外部無法呼叫
    // $sql 一個sql的字串，主要是where 前的語法
    // $array sql語句需要的欄位和值
    // $other sql特殊語句

    private function sql_all($sql,$array,$other){
        // 如果有設定資料表且不為空
        if(isset($this->table)&&!empty($this->table)){

            // 如果參數為陣列
            if(is_array($array)){
            
                // 如果陣列不為空
                if(!empty($array)){
                    $tmp=$this->a2s($array);
                    $sql .= " where " . join(" && ", $tmp);
                }
            }else{
                $sql .= " $array";
            }

            $sql .= $other;

            // 回傳sql字串
            return $sql;
        }
    }

    // 此方法主要是用來取得符合條件的所有資料
    function all($where='', $other =''){
        // 建立一個基礎語法字串
        $sql="select * from $this->table ";

        // 將語法字串及參數帶入到類別內部的sql_all()方法中，結果會得到一個完整的SQL句子
        $sql=$this->sql_all($sql,$where,$other);

    }
}
