<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DbConnection extends Controller
{
    class dbConnection {
        protected static $db;
        
        private function __construct(){
            try {
              $url = parse_usl(getenv('DATABASE_URL'));
              
              $dsn = sprintf('pgsql:host=%s;dbname=$s', $url['host'], substr($url['path'],1));
              
              self::$db = new PDO ($dsn, $url['user'], $url['pass']);
              self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'Connection Error:' . $e->getMessage();
            }
            
            public static function getConnection(){
                if(!self::$db){
                    new dbConnection();
                }
                return self::$db; 
            }
        }
    }
}
