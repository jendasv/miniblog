<?php

    include_once '_partials/header.php';
    $tags = get_all_tags();

?>
    <div class="tag-list box">

        <h1 class="box-heading text-muted">
            List of all tags
        </h1>

        <div class="row">

            <div class="col-lg-4">
                <ul class="list-group tags-group">
                    <?php foreach ( $tags as $tag ) : ?>
                    <li id="tag-<?= $tag->id ?>" class="list-group-item">
                        <span><a href="<?= BASE_URL ?>/tag/<?= $tag->tag ?>"><?= $tag->tag ?></a></span>
                        <?php if ($logged_in->authority == 'admin' || $logged_in->authority == 'editor') :?>
                        <div class="controls pull-right">
                            <a href="<?= BASE_URL ?>/edit-tag/<?= $tag->id ?>" class="edit-link">edit</a>
                            <a href="<?= BASE_URL ?>/delete-tag/<?= $tag->id ?>" class="delete-link text-muted glyphicon glyphicon-remove"></a>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if ($logged_in->authority == 'admin' || $logged_in->authority == 'editor') : ?>
                <div class="col-lg-4">
                    <form action="<?= BASE_URL ?>/_admin/add-tag.php" method="POST">
                        <p class="form-group">
                            <textarea name="tag" rows="1" class="form-control" placeholder="input new tag"></textarea>
                        </p>
                        <input type="submit" class="btn btn-primary" value="Input new tag">
                    </form>
                </div>
            <?php endif; ?>

        </div>

    </div>


<?php  include_once '_partials/footer.php'; ?>


