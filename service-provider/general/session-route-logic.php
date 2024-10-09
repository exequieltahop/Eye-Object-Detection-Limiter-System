<?php
    if(isset($_GET['rl'])){
        switch($_GET['rl']){
            case 'sign-in':
                PutSession('Title','Sign in');
                break;
            case 'unauthorized':
                PutSession('Title','Unauthorized Access');
                break;  
            case 'migration-status':
                PutSession('Title','Migrations');
                break;  
            case 'migration-status':
                PutSession('Title','Under Mentainance!');
                break;
            case 'home':
                PutSession('Title','Home');
                break;  
            default:
                PutSession('Title','Sign in');
                break;
        }
    }else{
        PutSession('Title','Sign in');
    }