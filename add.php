<?php


    $page_title = 'Add new';

    include_once '_partials/header.php';

    if ( isset( $_SESSION['form_data'] ) )
    {
        extract( $_SESSION['form_data'] );
        unset( $_SESSION['form_data'] );

    }

?>
    <section class="box">
        <form id="add-form" action="<?= BASE_URL ?>/_admin/add-item.php" method="post" class="post">
            <header class="post-header">
                <h1 class="box-heading">Add new post</h1>
            </header>

            <div class="form-group">
                <input type="text" name="title" class="form-control" value="<?= $title ?: ''; ?>" placeholder="title of the post">
            </div>

            <div class="form-group">
                <textarea name="text" rows="16" class="form-control" placeholder="write your shit"><?= $text ?: ''; ?></textarea>
            </div>

            <div class="form-group">
               <!-- <?php /*foreach ( get_all_tags() as $tag ) : */?>

                    <label for="" class="checkbox">
                        <input type="checkbox" name="tags[]" value="<?/*= $tag->id */?>"
                        <?/*= $tag->checked || in_array( $tag-> id, $tags ?: [] ) ? 'checked' : '' */?> >
                        <?/*= plain( $tag->tag ) */?>
                    </label>

                --><?php /*endforeach; */?>
                <div id="selects"  class="form-group">

                    <a id="tag-add" href="" class="btn btn-xs btn-primary">
                        +
                    </a>

                    <label id="tags-select"  for="" class="checkbox">
                        <select name="tags[]">
                            <option value=""></option>
                            <?php foreach ( $tags = get_all_tags() as $tag ) : ?>

                                <option value="<?= $tag->id ?>">
                                    <?= plain( $tag->tag ) ?>
                                </option>

                            <?php endforeach; ?>
                        </select>
                        <a id="tag-remove" href="" class="btn btn-xs btn-warning">
                            &times;
                        </a>
                    </label>

                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add post</button>
                <span>
                    or <a href="<?= BASE_URL ?>">cancel</a>
                </span>

            </div>
        </form>
    </section>


<?php include_once "_partials/footer.php" ?>