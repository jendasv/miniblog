<?php
    require_once '_inc/config.php';

    //just to be safe
    if ( ! logged_in() )
    {
        redirect('/');
    }

    $tag = validate_tag();

    if ( $tag->error )
    {
        flash()->error($tag->error);
        redirect('back');
    }


    $query = $db->prepare("
        UPDATE tags SET 
        tag = :tag
        WHERE id = :tag_id
    ");

    $update_tag = $query->execute([
        'tag' => $tag->tag,
        'tag_id' => $tag->tag_id,
    ]);

    if ( ! $update_tag )
    {
        flash()->error('Oh no, something has gone bad :(');
        redirect('back');
    }


    //Success!
    flash()->success('yay, you changed it!');
    redirect('tags-list');
