<?php
    require __DIR__.'/../../utilities/database/auth.php';
    require_once __DIR__.'/../../service-provider/general/session.php';

    use Utilities\Database\Auth;

    try {
        $Auth = new Auth();

        if(!$Auth->Logout()){
            throw new Exception("Can\'t Log out Please Try Again!");
        }

        header("location: ../../");
        exit;
        
    } catch (\Throwable $th) {
        SessionFlash('exception', $th->getMessage());
        header('location: ../../?rl=exception');
        exit;
    }