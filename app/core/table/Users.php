<?php
namespace core\table;

use core\App;
use core\Session;


class Users{

    public function __get($key){
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }

    public function all(){
        return "<tr>
                    <td>$this->usr_login</td>
                    <td>$this->usr_email</td>
                    <td>$this->ban</td>
                    <td>
                        <button class=\"btn btn-primary\" onclick=\"\">Modifier</button>
                    </td>
                    <td>
                        <button class=\"btn btn-danger\" onclick=\"\">Supprimer</button>
                    </td>
                </tr>";
    }

    public function getBan(){
        if(is_null($this->usr_ban)){
            return 'Non';
        }
        return 'Oui';
    }

    public function getAll(){
        return App::getDataBase()->prepare('SELECT * FROM users WHERE usr_id != :id ORDER BY usr_login',
                                            ['id' => Session::getInstance()->read('auth')],
                                            __CLASS__);
    }
}