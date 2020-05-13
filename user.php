<?php

    $user = get_user( segment(2) );

    try {
        $result = get_posts_by_user( $user->id );
    }
    catch ( PDOException $e )
    {
        // also handle error maybe
        $result = [];
    }


    include_once '_partials/header.php';

?>

    <section class="box post-list">
        <h1 class="box-heading text-muted"><small>by</small> <?= plain( $user->user_name ) ?></h1>
        <?php if (count($result)) : foreach ( $result as $post) : ?>

            <article id="post-<?= $post->id; ?>" class="post">
                <header class="post-header">
                    <h2>
                        <a href="<?= $post->link ?>">
                            <?= $post->title ?>
                        </a>
                        <time datetime="<?= $post->date ?>">
                            <small> /&nbsp;<?= $post->time ?></small>
                        </time>
                    </h2>
                    <?php include '_partials/tags.php'?>
                </header>
                <div class="post-content">
                    <p>
                        <?= $post->teaser ?>
                    </p>
                </div>
                <div class="footer post-footer">
                    <a class="read-more" href="<?= $post->link ?>">
                        read more
                    </a>
                </div>
            </article>

        <?php endforeach; else : ?>
            <p>we've got nothing :(</p>
        <?php endif; ?>
    </section>



<?php include_once "_partials/footer.php" ?>