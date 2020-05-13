
<div id="selects"  class="form-group">

    <a id="tag-add" href="" class="btn btn-xs btn-primary">
        +
    </a>

    <?php foreach ($post_tags = get_post_tags($post->id) as $post_tag ) : ?>
        <label id="tags-select"  for="" class="checkbox">
        <select name="tags[]">
            <option value=""></option>
            <?php foreach ( $tags = get_all_tags($post->id, false) as $key => $tag ) : ?>

                <option value="<?= $tag->id ?>" <?= $post_tag->id == $tag->id ? 'selected' : '' ?>>
                    <?= plain( $tag->tag ) ?>
                </option>

            <?php endforeach; ?>
        </select>
            <a id="tag-remove" href="" class="btn btn-xs btn-warning">
                &times;
            </a>
        </label>
    <?php endforeach; ?>

</div>