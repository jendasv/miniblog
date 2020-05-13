<?php

    require_once '_inc/config.php';

    //check if user is logged in
    if ( ! $auth->isLogged() )
    {
        redirect('/');
    }


    //logout
    do_logout();

    //flash it & go home
    flash()->success('Bye bye');
    redirect('/');
