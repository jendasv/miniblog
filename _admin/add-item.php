<?php

	// include
	require '../_inc/config.php';

	//just to be safe
	if ( ! logged_in() )
	{
	    redirect('/');
    }


	if ( ! $data = validate_post() )
	{
	    redirect('back');
    }

	extract($data);

	$slug = slugify( $title );

	$user_id = get_user();

    $update_post = $db->prepare("
            INSERT INTO posts 
                ( user_id, title, text, slug )
            VALUES 
                ( :uid, :title, :text, :slug)
        ");

    $insert = $update_post->execute([
        'uid' => get_user()->uid,
        'title' => $title,
        'text' => $text,
        'slug' => $slug
    ]);

    if ( ! $insert)
    {
        redirect('back');
    }

    //Success!
    $post_id = $db->lastInsertId();


    //if we have tags, add them
    if ( isset( $tags ) && $tags = array_filter( $tags ) )
    {
        foreach ( $tags as $tag_id )
        {
            $insert_tags = $db->prepare("
                INSERT INTO posts_tags
                VALUES (:post_id, :tag_id)
            ");

            $insert_tags->execute([
                'post_id' => $post_id,
                'tag_id' => $tag_id
            ]);
        }


    }

    //let's visit the new post

        flash()->success('yay, new one!');
        redirect( get_post_link(
            [
                'id' => $post_id,
                'slug' => $slug
            ]
        ) );
