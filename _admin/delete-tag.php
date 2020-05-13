<?php
    require_once '_inc/config.php';

    //just to be safe
    if ( ! logged_in() )
    {
        redirect('/');
    }

    $tag = (object) $_POST;


    $query = $db->prepare("
            DELETE FROM tags
            WHERE id = :tag_id
        ");

    $update_tag = $query->execute([
        'tag_id' => $tag->tag_id,
    ]);

    if ( ! $update_tag )
    {
        flash()->error('Oh no, something has gone bad :(');
        redirect('back');
    }

    //Success!
    flash()->success('yay, you delete it!');
    redirect('tags-list');
