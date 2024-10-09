<?php
    namespace Utilities\Tools;

    use Exception;

    class EmailValidator{
        public static function IsValid(string $email) : bool {
            try {
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    return false;  
                }
                return true;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }