<?php

    echo '<pre>';
        print_r($_POST);
    echo '</pre>';

    // include
    require '_inc/config.php';

    //just to be safe
    if ( ! logged_in() )
    {
        redirect('/');
    }

    //data extract
    extract($_POST);
    echo '<pre>';
        print_r($text);
    echo '</pre>';

    //add comment
    $query = $db->prepare("
        INSERT INTO comments ( user_id, post_id, text)
        VALUES 
        ( :user_id, :post_id, :text)
    ");

    $insert_comment = $query->execute([
        'user_id' => $user_id,
        'post_id' => $post_id,
        'text' => $text
    ]);

    //in case of failure
    if ( ! $insert_comment ) {
        flash()->error('Oh, no something bad has happaned :(');
        redirect('back');
    }

    //Success!!!
    flash()->success('You comment was inserted');
    redirect('back');




