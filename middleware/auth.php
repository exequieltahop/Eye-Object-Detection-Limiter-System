<?php

    if(SessionHas('mentainance')){
        header('Location: ./?rl=mentainance');  
        exit;
    }

    if(!SessionHas('HasLog')){
        header('Location: ./?rl=unauthorized');
        exit;
    }
    if(!SessionHas('uid')){
        header('Location: ./?rl=unauthorized');
        exit;
    }