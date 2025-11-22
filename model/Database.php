<?php
class DATABASE
{
    private static $dns = "mysql:host=localhost;dbname=shop_laptop;port=3306";
    private static $username = "root";
    private static $password = "";
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    private static $db;

    private function __construct() {}

    public static function connect()
    {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(
                    self::$dns,
                    self::$username,
                    self::$password,
                    self::$options
                );
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                echo "<p>Lỗi kết nối: $error_message</p>";
                exit();
            }
        }
        return self::$db;
    }

    public static function close()
    {
        self::$db = null;
    }

    public static function execute_query($sql, $option = array())
    {
        $db = self::connect();
        try {
            $cmd = $db->prepare($sql);

            foreach ($option as $i => $value) {
                $cmd->bindValue($i + 1, $value);
            }

            $cmd->execute();
            return $cmd->fetchAll();
        } catch (PDOException $ex) {
            echo "Lỗi truy vấn: " . $ex->getMessage();
        }
    }


    public static function execute_nonquery($sql, $option = array())
    {
        $db = self::connect();
        try {
            $cmd = $db->prepare($sql);

            foreach ($option as $i => $value) {
                $cmd->bindValue($i + 1, $value);
            }

            return $cmd->execute();
        } catch (PDOException $ex) {
            echo "Lỗi thực thi: " . $ex->getMessage();
        }
    }
}
