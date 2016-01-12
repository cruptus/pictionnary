<?php
namespace core;
/**
 * Class Autoloader
 */
class Autoloader{

    /**
     * Fait appel à autoload pour chaque app_class créée
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inlcus la class correspondante
     * @param String $class
     */
    static function autoload($class){
        if (strpos($class, __NAMESPACE__ . '\\') === 0){
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            require __DIR__ . '/' . $class . '.php';
        }
    }
}