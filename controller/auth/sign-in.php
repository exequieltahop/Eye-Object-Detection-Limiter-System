<?php
    require __DIR__.'/../../utilities/tools/StatusCodeHandler.php';
    require __DIR__.'/../../utilities/database/auth.php';
    require_once __DIR__.'/../../utilities/tools/email-validator.php';
    
    use Tools\StatusCodeHandler;
    use Utilities\Database\Auth;
    use Utilities\Tools\EmailValidator;

    try {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $statusCodehandler = new StatusCodeHandler();
            $statusCodehandler->HTTP_401();
        }        

        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!EmailValidator::IsValid($email)){
            throw new Exception('Invalid Email!');
        }

        if(strlen($password) < 8){
            throw new Exception('Password Must Be Atleast 8 Chars Long!');
        }

        $Auth = new Auth();

        $status_auth = $Auth->Attempt(['email' => $email, 'password' => $password]);


        if(!$Auth->Attempt(['email' => $email, 'password' => $password])){
            throw new Exception('Can\'t Log In Please Try Again!');
        }

        // response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => 'Successfully Sign In',
            'rl' => './?rl=home'
        ]);
    } catch (\Throwable $th) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $th->getMessage()]);
    }