<?php
namespace core;

/**
 * Class Auth
 */
class Auth{

    /**
     * @var session
     */
    private $session;
    private $dir;

    /**
     * @param $session
     */
    public function __construct($session, $dir){
        $this->session = $session;
        $this->dir = $dir;
    }

    /**
     * Retourne si l'utilisateur est connecté
     * @return bool
     */
    public function isConnect(){
        return is_numeric($this->session->read('auth')) ? true : false;
    }

    /**
     * Ajoute à la session l'id de l'utilisateur et le connecte
     * @param $user
     */
    public function connect($user){
        $this->session->write('auth', $user);
    }

    /**
     * retourne l'id de l'utilisateur connecté
     * @return integer
     */
    public function idAuth(){
        return $this->session->read('auth');
    }

    /**
     *  Deconnecte l'utilisateur
     */
    public function disconnect(){
        $this->session->delete('auth');
        header('Location: '.$this->dir.'/home');
        exit();
    }

    /**
     * Retourne si l'utilisateur existe et le connecte
     * @param Database $db
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($db, $username, $password){
        $user = $db->prepare('SELECT id, email, password FROM users WHERE email = ?', [$username]);
        if($user){
            if(hash('sha256', $password) === $user[0]->password){
                $this->connect($user[0]->id);
                header('Location: '.$this->dir.'/pictionnary/home');
                exit();
            }else{
                return false;
            }
        }
        return false;

    }

    /**
     * Redirige si l'utilisateur n'est pas connecté
     */
    public function redirect(){
        if(!$this->isConnect()){
            header('Location: '.$this->dir.'/home');
            exit();
        }
    }
}