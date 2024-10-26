<?php
    require_once __DIR__.'/../../service-provider/general/session.php';
    require __DIR__.'/../../utilities/tools/StatusCodeHandler.php';

    use Tools\StatusCodeHandler;

    try {
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $statusCodehandler = new StatusCodeHandler();
            $statusCodehandler->HTTP_401();
        }
        $json = json_decode(file_get_contents('php://input'), true);

        PutSesssionArray([
            'HasLog' => 1,
            'uid' => $json['username']
        ]);

        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);

    } catch (\Throwable $th) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $th->getMessage()]);
    }