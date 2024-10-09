<?php
    namespace Configuration;

    class DataBaseConfiguration{
        /**
         * This is where you edit the database configuration
         * The DataBase Type "MySql", "Sqlite", etc
         * The Database schema
         * The host name
         * The username
         * The password 
         */
        private static $DataBaseType = 'mysql';
        private static $DataBaseName = 'eyedetection';
        private static $host = 'localhost';
        private static $username = 'root';
        private static $password = '';

        // Database type, host, dbname
        public static function HOST_AND_DBNAME() : string {
            return self::$DataBaseType.':host='.self::$host.';dbname='.self::$DataBaseName.';';
        }

        // database username
        public static function UID() : string {
            return self::$username;
        }

        // database password
        public static function PASS() : string {
            return self::$password;
        }
    }