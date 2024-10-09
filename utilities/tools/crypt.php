<?php
    namespace Utilities\Tools;

    class Crypt{
        public static function BCrypt(string $password) : string {
            try {
                return password_hash($password, PASSWORD_BCRYPT);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }