<?php
    if(SessionHas('mentainance')){
        header('Location: ./?rl=mentainance');
        exit;
    }
