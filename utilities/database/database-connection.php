<?php  
    namespace Utilities\Database;
    
    require __DIR__.'/../../config/DatabaseConfiguration.php';

    use Configuration\DataBaseConfiguration;
    use PDO;
    use Exception;
    use PDOException;

    class DatabaseConnection{
        protected $conn;

        // OPEN DATABASE CONNECTION
        public function Connect() : void {
            try {
                /**
                 * See this in config/DatabaseConfiguration.php
                 * get database type, host, dbname
                 * get database uid
                 * get database pass
                 */
                $HostDatabse = DataBaseConfiguration::HOST_AND_DBNAME();
                $uid = DataBaseConfiguration::UID();
                $pass = DataBaseConfiguration::PASS();

                // assign new PDO
                $this->conn = new PDO($HostDatabse, $uid, $pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $th) {
                throw $th;
            }
        }
        
        // DISCONNECT CONNECTION
        public function Disconnect() : void {
            try {
                $this->conn = null;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }