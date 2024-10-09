<?php 
    namespace Tools;

    class StatusCodeHandler{
        public function HTTP_401() : void {
            http_response_code(401);
            header('Location: ../../?rl=unauthorized');
            exit;
        }
    }