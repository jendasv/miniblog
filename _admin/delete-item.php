<?php

    // include
    require '../_inc/config.php';

    //just to be safe
    if ( ! logged_in() )
    {
        redirect('/');
    }

    //post id check
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);

    //does this even exist?
    if ( ! $post_id || ! $post = get_post( $_POST['post_id'],false) )
    {
        flash()->error("no such post");
        redirect('back');
    }

    //is this author?
    if ( ! can_edit( $post ) ) {
        flash()->error("What are you trying to pull here");
        redirect('back');
    }

    //time to delete post, bro
    $query = $db->prepare("
        DELETE FROM posts
        WHERE id= :post_id
    ");

    $delete = $query->execute([
        'post_id' => $post_id
    ]);

    //we messed up
    if ( ! $delete ) {
        flash()->warning('Some shit happend, again');
        redirect('back');
    }

    //remove all tags for this post too
    $query = $db->prepare("
        DELETE FROM posts_tags
        WHERE post_id = :post_id
    ");

    $query->execute([
        'post_id' => $post_id
    ]);

    //let's go home
    flash()->success( 'yay, you destroyed that!' );
    redirect('/');