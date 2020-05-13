
    <div id="comments" class="comments post">
        <h3 class="comment-heading">
            Post comments
        </h3>
        <div class="row">
            <div class="col-lg-8">
                <form action="_admin/add-comment.php" method="post">
                    <div class="form-group">
                        <textarea name="text" id="comment-text" rows="5" placeholder="Write your opinion"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="post_id" value="<?= $post->id ?>">
                        <input type="hidden" name="user_id" value="<?= $logged_in->id ?>">
                        <button type="submit" class="btn btn-primary">Comment</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">

                <?php if ($comments) : foreach ( $comments as $comment) : ?>
                    <div class="comment">
                        <h4>
                            <span class="comment-author"><?= $comment->author ?></span>
                            <div class="comment-time">
                                <time datetime="<?= $comment->date ?>">
                                    <small><?= $comment->time ?></small>
                                </time>
                            </div>
                        </h4>

                        <p>
                            <?= $comment->text ?>
                        </p>
                    </div>
                <?php
                    endforeach;
                    endif;
                ?>
            </div>
        </div>



    </div>
