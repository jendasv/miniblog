<?php


    try {
        $result = get_posts();
    }
    catch ( PDOException $e )
    {
        // also handle error maybe
        $result = [];
    }


    include_once '_partials/header.php';
?>

    <section class="box post-list">
        <h1 class="box-heading text-muted">this is a blog</h1>
        <?php if (count($result)) : foreach ( $result as $post) : ?>
            <?php
            if ($comments = get_post_comments( $post->id ))
            {
                $comments_nbr = count((array) $comments);
            }
            else {
                $comments_nbr = 0;
            }
            ?>

            <article id="post-<?= $post->id; ?>" class="post">
                <header class="post-header">
                    <h2>
                        <a href="<?= $post->link ?>">
                            <?= $post->title ?>
                        </a>
                        <div class="post-comment-overview">
                            <time datetime="<?= $post->date ?>">
                                <small><?= $post->time ?></small>
                            </time>
                            <div id="comment-nbr">
                                <span class="glyphicon glyphicon-comment"></span>
                                    <p><?= $comments_nbr ?></p>
                            </div>

                        </div>
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
