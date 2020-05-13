<?php

	// include
	require '../_inc/config.php';

    //just to be safe
    if ( ! logged_in() )
    {
        redirect('/');
    }

    //does this even exist?
    if ( ! $post = get_post( $_POST['post_id'],false) )
    {
        flash()->error("no such post");
        redirect('back');
    }


    if ( ! can_edit( $post ) ) {
        flash()->error("What are you trying to pull here");
        redirect('back');
    }

    if ( ! $data = validate_post() )
    {
        redirect('back');
    }

    //Changes check
    $descision = posts_comparsion_for_edit();

    //Edit post
    // - add content based on descision
    $edit = post_edit( $data, $descision );


    if ( $edit['error'] == true )
    {
        flash()->warning($edit['message']);
        redirect('back');
    }
    else {
        flash()->success($edit['message']);
        redirect( get_post_link($post));
    }





