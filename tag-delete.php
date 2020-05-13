<?php

    include_once '_partials/header.php';

    $tag_id = segment(2);

    $tag = get_tag( $tag_id );

    if ( ! $tag)
    {
        flash()->warning('What are you trying, BITCH');
        redirect('tags-list');
    }

?>
    <div class="box">

        <h1 class="box-heading">
            Delete tag <?= $tag->tag; ?>
        </h1>

        <form action="_admin/delete-tag.php" method="post">

            <div class="form-group">
                <label for="" class="checkbox">
                    Delete tag:
                    <input type="text" name="tag" value="<?= $tag->tag ?>" disabled>
                </label>
            </div>

            <div class="form-group">
                <input type="hidden" name="tag_id" value="<?= $tag->id ?>">
                <button type="submit" class="btn btn-sm btn-primary">Delete</button>
                <span> or go <a href="<?= BASE_URL ?>/tags-list">back</a></span>
            </div>

        </form>

    </div>

<?php include_once '_partials/footer.php'; ?>