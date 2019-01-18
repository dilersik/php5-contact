<?php

class DAO {

    private static $isPDO;
    
    public static function newPDO() {
        try {
            if (is_null(self::$isPDO)) {
                $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
                self::$isPDO = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME . '; charset=utf8', DB_USER, DB_PSWD, $opcoes);
            }

            return self::$isPDO;
            return new PDO();

        } catch (PDOException $e) {
            die('Connection Failed newPDO!: ' . $e->getMessage());
        }
    }
    
}