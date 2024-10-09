<?php
    namespace Database\Migration;

    require __DIR__.'/../../utilities/database/query-builder.php';
    require_once __DIR__.'/../../service-provider/general/session.php';

    use Utilities\Database\QueryBuilder;

    class TableUsersMigration{
        public function  Create() : bool {
            try {
                $qb = new QueryBuilder();
                $qb->Connect();
                $result = $qb->CreateTable('users')
                                ->ColumnName('id')
                                    /** 
                                     * second param set to false in order for the length be none 
                                     */
                                    ->DataType('int', false)
                                    ->AutoIncrement()
                                    ->PrimaryKey()
                                    ->Comma()
                                ->ColumnName('name')
                                    ->DataType('varchar')
                                    ->Length(225)
                                    ->NotNull()
                                    ->Comma()
                                ->ColumnName('email')
                                    ->DataType('varchar')
                                    ->Length(255)
                                    ->Unique()
                                    ->NotNull()
                                    ->Comma()
                                ->ColumnName('password')
                                    ->DataType('varchar')
                                    ->Length(255)
                                    ->NotNull()
                                    ->Comma()
                                ->ColumnName('roles')
                                    ->DataType('enum')
                                    /**
                                     * Using "" will make the UnumValues like this enum("user", "admin")
                                     * 
                                     * If directly passing it like this EnumValues(['user','admin'])
                                     * will result in enum(user, admin)
                                     * 
                                     * And using EnumValues(['\'user\'', '\'admin\''])
                                     * will make the query in the query builder like this 
                                     * 
                                     * for example 
                                     * 
                                     * $query = 'CREATE TABLE IF NOT EXIST 
                                     *              users(id int auto_increment primary key,
                                     *              name varchar(255) NOT NULL,
                                     *              email varchar(255) UNIQUE NOT NULL,
                                     *              roles enum(['user',admin']));';
                                     * 
                                     * this will cause error
                                     * 
                                     * if passing it like this EnumValues(["\"users\"", "\"admin\""])
                                     * it valid
                                     */
                                    ->EnumValues(['"user"', '"admin"'])
                                    ->Default('"user"')
                                    ->NotNull()
                                    ->Comma()
                                ->ColumnName('created_at')
                                    ->DataType('datetime', false) 
                                    ->Default('CURRENT_TIMESTAMP')
                                    ->Comma()
                                ->ColumnName('updated_at')
                                    ->DataType('datetime',false)
                                    ->Default('CURRENT_TIMESTAMP')
                                    ->OnUpdate('CURRENT_TIMESTAMP')
                                    ->Comma()
                                ->Index('idx_name', 'name')
                                    ->Comma()
                                ->Index('idx_email', 'email')
                                ->EndCreateQuery()
                                ->Execute(True);
                $qb->Disconnect();
                return true;
            } catch (\Throwable $th) {
                $qb->Disconnect();
                throw $th;
            }
        }
    }

    $user = new TableUsersMigration();

    $res = $user->Create();

    if($res){
        PutSession('MigrationStatus', 'Successfully Migrate Table users');
    }
