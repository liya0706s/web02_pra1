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

    protected function math($math,$col,$array='',$other=''){
        $sql="select $math($col) from $this->table";
        $sql=$this->sql_all($sql,$array,$other);

        // 因為這類方法大多是只會回傳一個值，所以使用fetchColumn()的方法來回傳
        return $this->pdo->query($sql)->fetchColumn();
    }

    // 此方法主要是用來取得符合條件的所有資料
    function all($where='', $other =''){
        // 建立一個基礎語法字串
        $sql="select * from $this->table ";

        // 將語法字串及參數帶入到類別內部的sql_all()方法中，結果會得到一個完整的SQL句子
        $sql=$this->sql_all($sql,$where,$other);

        // 將sql句子帶進pdo的query方法中，並以fetchAll的方式回傳所有的結果
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    function find($id){
        // 建立一個基礎語法字串
        $sql="select * from $this->table";

        // 如果 $id 是陣列
        if(is_array($id)){

            // 執行內部方法a2s
            $tmp=$this->a2s($id);

            // 拼接sql語句
            $sql .= " where " .join(" && ", $tmp);
        }
        // 如果 $id 是數字
        else if(is_numeric($id)){

            // 拼接 sql語句
            $sql .= " where `id`='$id'";
        }

        // 將sql句子帶進pdo的query方法中，並以fetch的方式回傳一筆資料結果
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    function del($id){
        // 建立一個基礎與法字串
        $sql="delete from $this->table";

        if(is_array($id)){
            $tmp=$this->a2s($id);
            $sql .= " where ". join(" && ", $tmp);
        }else if(is_numeric($id)){
            $sql .= " where `id`='$id'";
        }

        // 將sql句子帶進pdo的exec方法中，回傳的結果是影響了幾筆資料
        return $this->pdo->exec($sql);
    }
    
}
