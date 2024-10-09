<?php
    namespace Utilities\Database;

    require __DIR__.'/database-connection.php';

    use PDO;
    use PDOStatement;
    use Utilities\Database\DatabaseConnection;

    class QueryBuilder extends DatabaseConnection{
        private $query = '';
        private $column_count = 0;
        private $where_count = 0;
        private $bind_param = [];
        private $column_and_value = [];

        public function Select(string $column) : self {
            try {
                if($this->column_count < 1){
                    $this->query .= 'SELECT ';
                }else{
                    $this->query .= ', ';
                }

                $this->query .= $column;

                $this->column_count++;

                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // from
        public function From(string $table) : self {
            try {
                $this->query .= ' FROM '.$table;
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        //Where
        public function Where(string $column, string $operator, string $value, bool $binary) : self {
            try {
                if($this->where_count < 1){
                    $this->query .= ' WHERE ';
                }

                if($binary == true){
                    $this->query .= 'BINARY '.$column. ' ' . $operator. ' :'.$column;
                }else{
                    $this->query .= $column. ' ' . $operator. ' :'.$column;
                }

                $this->bind_param[] = [
                    'column' => $column,
                    'value' => $value
                ];

                $this->where_count++;
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // AND 
        public function And() : self {
            try {
                $this->query .= ' AND ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // AND 
        public function Or() : self {
            try {
                $this->query .= ' OR ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // bind param
        public function BindParam(PDOStatement $stmt) : self {
            try {
                foreach($this->bind_param as $param){
                    $stmt->bindParam(':'.$param['column'], $param['value']);
                }

                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // get
        public function GetAll() : mixed {
            try {
                $stmt = $this->conn->prepare($this->query);
                $this->BindParam($stmt);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                $this->Reset();
                return $result ?? [];
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // get rows
        public function GetRow() : mixed {
            try {
                $stmt = $this->conn->prepare($this->query);
                $this->BindParam($stmt);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC) ?? []; 
                $this->Reset();
                return $result;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // execute
        public function Execute(bool $NoBindParam = false) : bool {
            try {
                $stmt = $this->conn->prepare($this->query);
                if($NoBindParam == false){
                    $this->BindParam($stmt);
                }
                $stmt->execute(); 
                $this->Reset();
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // reset instances
        private function Reset() : void {
            try {
                $this->query = '';
                $this->column_count = 0;
                $this->where_count = 0;
                $this->bind_param = [];
                $this->column_and_value = [];
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // insert column and values
        public function Insert(array $columns_and_values) : self {
            try {
                $this->column_and_value = $columns_and_values;
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        
        // into what table
        public function Into(string $table) : self {
            try {
                $column_count = 1;
                $array_count = count($this->column_and_value);

                $this->query .= 'INSERT INTO '.$table.'(';

                foreach($this->column_and_value as $key => $value){
                    if($column_count == $array_count){
                        $this->query .= $key.')';
                    }else{
                        $this->query .= $key.', ';
                    }
                    $this->bind_param[] = [
                        'column' => $key,
                        'value' => $value
                    ];
                    $column_count++;
                }

                $count2 = 1;
                $this->query .= ' VALUES (';
                foreach($this->column_and_value as $key => $value){
                    if($count2 == $array_count){
                        $this->query .= ':'.$key.')';
                    }else{
                        $this->query .= ':'.$key.', ';
                    }
                    $count2++;
                }
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // Create Table
        public function CreateTable(string $table) : self {
            try {
                $this->query .= 'CREATE TABLE IF NOT EXISTS '.$table.' (';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // SetColumnName
        public function ColumnName(string $column) : self {
            try {
                $this->query .= $column.' ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        
        // set data type
        public function DataType(string $data_type, bool $lenght_value = true) : self {
            try {
                if($lenght_value == true){
                    $this->query .= strtoupper($data_type).'(';
                }else{
                    $this->query .= strtoupper($data_type).' ';
                }
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // set lenght
        public function Length(float $length) : self {
            try {
                $this->query .= $length.') ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        
        // set as auto increment
        public function AutoIncrement() : self {
            try {
                $this->query .= 'AUTO_INCREMENT ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // set as primary key
        public function PrimaryKey() : self {
            try {
                $this->query .= 'PRIMARY KEY ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // set not null
        public function NotNull() : self {
            try {
                $this->query .= 'NOT NULL ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // set as null
        public function Null() : self {
            try {
                $this->query .= 'NULL ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // set as unique
        public function Unique() : self {
            try {
                $this->query .= 'UNIQUE ';
                return $this;   
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // default
        public function Default(string $default_value) : self {
            try {
                $this->query .= 'DEFAULT '.$default_value.' ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // comma
        public function Comma() : self {
            try {
                $this->query .= ', ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // On
        public function On() : self {
            try {
                $this->query .= 'ON ';
                return $this;  
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // ON UPDATE
        public function OnUpdate(string $on_update_val) : self {
            try {
                $this->query .= 'ON UPDATE '.$on_update_val.' ';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // set index
        public function Index(string $index_name, string $column_name) : self {
            try {
                $this->query .= 'INDEX '.$index_name.'('.$column_name.')';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        // end create query
        public function EndCreateQuery() : self{
            try {
                $this->query .= ');';
                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        
        // enum inside value
        public function  EnumValues(array $values) : self {
            try {
                $count = 1;
                $array_count = count($values);

                foreach($values as $val){
                    if($count == $array_count){
                        $this->query .= $val.') ';
                    } else{
                        $this->query .= $val.', ';
                    }
                    $count++;
                }

                return $this;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
