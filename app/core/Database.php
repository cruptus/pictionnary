<?php
namespace core;
use \PDO;
/**
 * Class Database
 */
class Database{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @param string $login
     * @param string $password
     * @param string $database_name
     * @param string $host
     */
    public function __construct($login, $password, $database_name, $host = 'localhost'){
        $this->pdo = new PDO("mysql:dbname=$database_name;host=$host", $login, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }


    /**
     * @param $statement
     * @return array
     */
    public function query($statement){
        $req = $this->pdo->query($statement);
        return $req->fetchAll();
    }

    /**
     * @param $statement
     * @param $attributes
     * @param $one boolean
     * @return array|mixed
     */
    public function prepare($statement, $attributes, $one = false){
        $req = $this->pdo->prepare($statement);
        $req->execute($this->protect($attributes));
        if($one){
            $datas = $req->fetch();
        }else{
            $datas = $req->fetchAll();
        }
        return $datas;
    }

    /**
     * @param $statement
     * @param $attributes
     * @return array|mixed
     */
    public function insert($statement, $attributes){
        $req = $this->pdo->prepare($statement);
        $req->execute($this->protect($attributes));
    }

    /**
     * Protege des injections SQL
     * @param array $params
     * @return array
     */
    private function protect($params){
        $params_temp = array();
        for($i = 0; $i < count($params); $i++){
            if(ctype_digit($params[key($params)]))
                $temp = intval($params[key($params)]);
            else
            {
                $temp = mysql_real_escape_string($params[key($params)]);
                $temp = addcslashes($temp, '%_');
                $temp = stripcslashes($temp);
            }
            $params_temp[key($params)] = $temp;
            next($params);
        }
        return $params_temp;
    }


    /**
     * Retourne le dernier id inséré
     * @return int
     */
    public function lastInsertId(){
        return $this->pdo->lastInsertId();
    }

}