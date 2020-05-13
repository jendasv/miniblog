<?php


    try {
        $post = get_post(    segment(2), false  );
    }
    catch ( PDOException $e )
    {
        $post = false;
    }

    if ( ! $post )
    {
        flash()->error("doesn't exist:(");
        redirect('/');
    }

    $page_title = 'Edit / ' . $post->title;

    include_once '_partials/header.php';

?>
    <section class="box">
        <form id="edit-form" action="<?= BASE_URL ?>/_admin/edit-item.php" method="post" class="post">
            <header class="post-header">
                <h1 class="box-heading">
                    Edit &ldquo;<?= plain( $post->title ) ?>&ldquo;
                </h1>
            </header>

            <div class="form-group">
                <input type="text" name="title" class="form-control" value="<?= $post->title ?>" placeholder="title of the post">
            </div>

            <div class="form-group">
                <textarea name="text" rows="16" class="form-control" placeholder="write your shit"><?= $post->text ?></textarea>
            </div>

            <?php include '_partials/form_tags.php' ?>

            <div class="form-group">
                <input name="post_id" value="<?= $post->id ?>" type="hidden">
                <button type="submit" class="btn btn-primary">Edit post</button>
                <span>
                    <o></o>r <a href="<?= get_post_link($post) ?>">cancel</a>
                </span>

            </div>
        </form>
    </section>


<?php include_once "_partials/footer.php" ?>