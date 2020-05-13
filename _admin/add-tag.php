<?php

    // include
    require '../_inc/config.php';

    //just to be safe
    if ( ! logged_in() )
    {
        redirect('/');
    }


    if ( ! $tag = validate_tag() )
    {
        redirect('back');
    }


    $query = $db->prepare("
        INSERT INTO tags (id, tag) VALUE (NULL, :tag)
    ");

    $insert_tag = $query->execute([ 'tag' => $tag ]);


    if ( ! $insert_tag )
    {
        flash()->error('Oh no, something has gone bad :(');
        redirect('back');
    }


    //Success!
    flash()->success('yay, new tag!');
    redirect('tags-list');

