<?php
    require __DIR__.'/../../utilities/tools/StatusCodeHandler.php';
    require __DIR__.'/../../utilities/database/query-builder.php';
    
    use Tools\StatusCodeHandler;
    use Utilities\Database\QueryBuilder;

    $QB = new QueryBuilder();
    
    try {
        /**
         * check server request method
         */
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $statusCodehandler = new StatusCodeHandler();
            $statusCodehandler->HTTP_401();
        }        
        
        /**
         * get the post variables
         */
        $limit = $_POST['time'];
        $timeType = $_POST['timeType'];

        /**
         * validate the post variables
         */
        if($limit < 0){
            throw new Exception("Don\'t Leave the time limit empty! or 0");
        }
        if(empty($timeType)){
            throw new Exception("Don\'t Leave the time type empty!");
        }
    
        /**
         * set db connection
         * prepare sql statement through query builder
         */
        $QB->Connect();

        $result = $QB->Insert([
                                'time_limit' => $limit,
                                'time_type' => $timeType,
                            ])
                     ->Into('limiter')
                     ->Execute();
        /**
         * validate result
         */
        if(!$result){
            throw new Exception("Unexpected error occurred!");
        }
        /**
         * disconnect connection after using
         */
        $QB->Disconnect();
        /**
         * echo json response
         * with success as the json key and the value is success message
         */
        header("Content-Type: application/json");
        echo json_encode(['success' => "Successfully Add Time Limiter"]);
    } catch (\Throwable $th) {
        /**
         * if there was error or exception throw it
         * And close database connection
         */
        $QB->Disconnect();
        throw $th;
    }