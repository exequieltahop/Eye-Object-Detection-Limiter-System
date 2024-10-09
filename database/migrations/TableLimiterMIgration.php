<?php
    namespace Database\Migration;

    require __DIR__.'/../../utilities/database/query-builder.php';
    require_once __DIR__.'/../../service-provider/general/session.php';

use Error;
use Utilities\Database\QueryBuilder;

    class TableLimiterMigration{
        public function Create() : bool {
            try {
                $qb = new QueryBuilder();
                $qb->Connect();
                $result = $qb->CreateTable('limiter')
                                ->ColumnName('id')
                                    ->DataType('int', false)
                                    ->AutoIncrement()
                                    ->PrimaryKey()
                                    ->Comma()
                                ->ColumnName('time_limit')
                                    ->DataType('int')
                                    ->Length(255)
                                    ->NotNull()
                                    ->Comma()
                                ->ColumnName('time_type')
                                    ->DataType('enum')
                                    ->EnumValues(['"seconds"', '"minutes"', '"hours"'])
                                    ->NotNull()
                                    ->Comma()
                                ->ColumnName('status')
                                    ->DataType('enum')
                                    ->EnumValues(['"standby"', '"ongoing"', '"finish"'])
                                    ->Default('"standby"')
                                    ->Comma()
                                ->ColumnName('created_at')
                                    ->DataType('datetime',false)
                                    ->Default('CURRENT_TIMESTAMP')
                                    ->NotNull()
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

    $limiter = new TableLimiterMigration();

    $res = $limiter->Create();

    if($res){
        echo "Successfully Migrate Table limiter";
    }
