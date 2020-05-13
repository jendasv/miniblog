<?php

    /**
     * Get Post
     *
     * Tries to fetch a DB post base on URI segment
     * Returns false if unable
     *
     * @param int       id of the post to get
     * @return DB post  or false
     */
    function get_post( $id = 0, $auto_format = true )
    {

        //we have no id
        if ( ! $id && ! $id = segment(2) ) // there is input segment 2 value to $id
        {
            return false;
        }

        // id must be INT

        if ( !filter_var($id, FILTER_VALIDATE_INT) )
        {
           return false;
        }

        global $db;

        $query = $db->prepare(create_post_query("WHERE p.id = :id"));

        $query->execute( ['id' => $id] );

        if ( $query->rowCount() === 1 ) {
            $result = $query->fetch( PDO::FETCH_ASSOC );

            if ( $auto_format )
            {
                $result = format_post( $result, true );
            }
            else
            {
                $result = (object)$result;
            }

        }
        else
        {
            $result = [];
        }

        return $result;
    }

    /**
     * Get Posts
     *
     * Grabs all posts from DB
     * And maybe formats then too, depending on $autoformat
     *
     * @param bool|true $auto_format whether to format all the post or not
     * @return array
     */
    function get_posts( $auto_format = true )
    {
        global $db;

        $query = $db->query(create_post_query());

        if ($query->rowCount()) {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            if ( $auto_format )
            {
                $results = array_map('format_post', $results);
            }

        }
        else
        {
            $results = [];
        }

        return $results;
    }


    /**
     * Create Posts Query
     *
     * Put together the query to get posts
     * We can add WHERE condition too
     *
     * @param string $where
     * @return string
     */
    function create_post_query( $where = '' )
    {
        $query = "
            SELECT p.*, u.email, u.user_name, GROUP_CONCAT(t.tag SEPARATOR '-||-') AS tags
            FROM posts p
            LEFT JOIN posts_tags pt ON (p.id = pt.post_id)
            LEFT JOIN tags t ON (t.id = pt.tag_id)
            LEFT JOIN phpauth_users u ON (p.user_id = u.id)
        ";

        if ( $where )
        {
            $query .= $where;
        }

        $query .= " GROUP BY p.id";
        $query .= " ORDER BY p.created_at DESC";

        return trim($query);
    }



    /**
     * Format post
     *
     * Clean up, sanitizes, formats and generally prepares DB post for, dispalying
     *
     * @param $post
     * @param boolean $format_text should only be true on page the post
     * @return object
     */
    function format_post( $post, $format_text = false )
    {
        //trim all data in array
        $post = array_map('trim', $post);

        //clean it up
        $post['title'] = plain($post['title']);
        $post['text'] = plain($post['text']);
        $post['tags'] = $post['tags'] ? explode('-||-', $post['tags']) : [];
        $post['tags'] = array_map('plain', $post['tags']);

        //tag me up
        if ($post['tags']) foreach ($post['tags'] as $tag) {
            $post['tag_links'][$tag] = BASE_URL. '/tag/'. urlencode($tag);
            $post['tag_links'][$tag] = filter_var($post['tag_links'][$tag], FILTER_SANITIZE_URL);
        }

        //create link to post [/post/:id/:slug]
        $post['link'] = get_post_link($post);

        //let's go on some dates
        $post['timestamp'] = strtotime($post['created_at']);
        $post['time'] = str_replace(' ','&nbsp;',date('j M Y, G:i ', $post['timestamp']));
        $post['date'] = date('Y-m-d', $post['timestamp']);

        //don't tease me, bro
        $post['teaser'] = word_limiter(plain($post['text']), 40);

        if ( $format_text )
        {
            $post['text'] = filter_url($post['text']);
            $post['text'] = add_paragraphs($post['text']);
        }

        $post['email'] = filter_var( $post['email'], FILTER_SANITIZE_EMAIL);
        $post['user_link'] = BASE_URL . '/user/'. $post['user_id'];
        $post['user_link'] = filter_var($post['user_link'], FILTER_SANITIZE_URL);

        return (object) $post;
    }

    /**
     * Get Posts By Tag
     *
     * Grab posts that have $tag from the DB
     * And maybe formats them too, depending on $auto_format
     *
     * @param string    $tag
     * @param bool|true $auto_format
     * @return array
     */
    function get_posts_by_tag( $tag = '', $auto_format = true )
    {

        //we have no id
        if ( ! $tag && ! $tag = segment(2) )
        {
            return false;
        }

        $tag = urldecode( $tag );
        $tag = filter_var( $tag, FILTER_SANITIZE_STRING );

        global $db;

        $query = $db->prepare(create_post_query("WHERE t.tag = :tag"));

        $query->execute([ 'tag' => $tag ]);

        if ($query->rowCount()) {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            if ( $auto_format )
            {
                $results = array_map('format_post', $results);
            }

        }
        else
        {
            $results = [];
        }

        return $results;

    }

    /**
     *
     * Get Posts By User
     *
     * Grab posts by user id, if no uid si provided, we get logged users id
     * And maybe formats them too, depending on $auto_format
     *
     *
     * @param   integer     $user_id
     * @param   bool        $auto_format whether to format all the posts or not
     * @return  array|bool
     */
    function get_posts_by_user( $user_id = 0, $auto_format = true )
    {

        //we have no id
        if ( ! $user_id )
        {
            return [];
        }

        global $db;

        $query = $db->prepare(create_post_query("WHERE p.user_id = :uid"));

        $query->execute([ 'uid' => $user_id ]);

        if ($query->rowCount()) {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            if ( $auto_format )
            {
                $results = array_map('format_post', $results);
            }

        }
        else
        {
            $results = [];
        }

        return $results;

    }

    /**
     * Get Post Link
     *
     * Create link to post [/post/:id/:slug]
     *
     * @param $post
     * @param string $type
     * @return mixed
     */
    function get_post_link( $post, $type = 'post' )
    {
        if ( is_object($post) )
        {
            $id = $post->id;
            $slug = $post->slug;
        }
        else
        {
            $id = $post['id'];
            $slug = $post['slug'];
        }

        $link = BASE_URL ."/{$type}/{$id}";

        if ( $type == 'post' )
        {
            $link .= "/$slug";
        }
        $link = filter_var( $link, FILTER_SANITIZE_URL );

        return $link;
    }


    /**
     * Get Edit Link
     *
     * Create edit to post [/edit/:id]
     *
     * @param $post
     * @return mixed
     */
    function get_edit_link(  $post )
    {
        return get_post_link( $post, 'edit');
    }

    /**
     * Get Delte Link
     *
     * Create delet to post [/delete/:id]
     *
     * @param $post
     * @return mixed
     */
    function get_delete_link(  $post )
    {
        return get_post_link( $post, 'delete');
    }

    /**
     *
     * Get all tags
     *
     * return array of tag id, tag name and if tag is in the post also "checked" for other use in code
     *
     * @param int $post_id
     * @return array
     */
    function get_all_tags( $post_id = 0, $checked = true )
    {
        global $db;

        $query = $db->query("
            SELECT * FROM tags
            ORDER BY tag ASC
        ");

        $results = $query->rowCount() ? $query->fetchAll(PDO::FETCH_OBJ) : [];

        if ( $post_id && $checked)
        {
            $query = $db->prepare("
                SELECT t.id FROM tags t
                JOIN posts_tags pt ON t.id = pt.tag_id
                WHERE pt.post_id = :pid
            ");

            $query->execute([ 'pid' => $post_id ]);

            if ($query->rowCount())
            {
                $tags_for_post = $query->fetchAll(PDO::FETCH_COLUMN);

                foreach ( $results as $key => $tag )
                {
                    if ( in_array( $tag->id, $tags_for_post ) )
                    {
                        $results[$key]->checked = true;
                    }
                }
            }
        }

        return $results;
    }


    /**
     *
     * Get Tag
     *
     * Get tag (id, tag) based on input id
     *
     * @param $tag_id
     * @return bool|mixed
     */
    function get_tag( $tag_id )
    {
        global $db;

        $query = $db->prepare("
                SELECT t.id, t.tag FROM tags t
                WHERE t.id = :tid
            ");

        $query->execute([ 'tid' => $tag_id ]);

        if ($query->rowCount())
        {
            $tag = $query->fetch(PDO::FETCH_OBJ);

        }
        else {
            return false;
        }

        return $tag;
    }

    /**
     * Get Post Tags
     *
     * Get tags which belong to the post by id
     *
     * @param $post_id
     * @return array|bool
     */
    function get_post_tags($post_id )
    {
        global $db;

        $query = $db->prepare("
                SELECT t.id, t.tag FROM tags t
                JOIN posts_tags pt ON t.id = pt.tag_id
                WHERE pt.post_id = :pid
            ");

        $query->execute([ 'pid' => $post_id ]);

        if ($query->rowCount())
        {
            $tags_for_post = $query->fetchAll(PDO::FETCH_OBJ);

        }
        else {
            return false;
        }
        return $tags_for_post;
    }

    /**
     *
     * Validate Tag
     *
     * Validate tag input to form
     *
     * @return string or object
     */
    function validate_tag()
    {
        if ($_POST['tag_id'])
        {
            $tag['tag_id'] = filter_input(INPUT_POST, 'tag_id', FILTER_SANITIZE_NUMBER_INT);
            $tag['tag'] = trim(filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

            if (strlen($tag['tag']) > 20 )
            {
                $return['error'] = true;
                $return['message'] = 'Your tag is too long!';

                return (object) $return;
            }

            return (object) $tag;
        }
        else {
            $tag = filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
            $tag = trim($tag);
        }

        return $tag;

    }

    /**
     * Validate Post
     *
     * Sanitize and Validate Post
     *
     * @return array|bool
     */
    function validate_post()
    {

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $tags = filter_input(INPUT_POST, 'tags', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        if ( isset($_POST['post_id']) )
        {
            $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);

            //id is required and has to be INT
            if ( ! $post_id )
            {
                flash()->error( ' What are you trying to pull here' );
            }
        }
        else
        {
            $post_id = false;
        }


        //title is required
        if ( ! $title = trim($title) )
        {
            flash()->error( ' You forgot your title, dumbass' );
        }

        //text is required
        if ( ! $text = trim($text) )
        {
            flash()->error( ' Write some text, if you can!' );
        }

        //if we have error message, validation didn't go well
        if ( ! $text || ! $title )
        {
            $_SESSION['form_data'] = [
              'title' => $title,
              'text'=> $text,
              'tags' =>  $tags ?: [],
            ];
            return false;
        }

        return compact(
            'post_id', 'title', 'text', 'tags',
            $post_id, $title, $text, $tags
        );

    }

    /**
     *
     * Post Comparsion For Edit
     *
     * Compare two posts (title, text, tags), Original one and data from POST request
     * return decision associative array
     * 'text_title'
     *  0 both are same
     *  1 titles diff, texts equal
     *  2 titles equal, text diff
     *  3 both differnt
     * 'tags'
     *  1 if tags are differ else it is not set
     *
     *
     * @return array $decision ['text_title', 'tags']
     */
    function posts_comparsion_for_edit()
    {
        global $db;

        //data for comparation
        extract( $edit_data = validate_post() );
        $original_post = get_post($post_id, false);

        $decision['title_text'] = 0;

        //Text and Title comparation
        if ( text_compare_cSens($original_post->title, $title) != 0 &&  text_compare_cSens($original_post->text, $text) == 0 )
        {
            $decision['title_text'] = 1;

        }
        else if ( text_compare_cSens($original_post->title, $title) == 0 &&  text_compare_cSens($original_post->text, $text) != 0 )
        {
            $decision['title_text'] = 2;

        }
        else if (text_compare_cSens($original_post->title, $title) != 0 &&  text_compare_cSens($original_post->text, $text) != 0)
        {
            $decision['title_text'] = 3;
        }

        //Tags comparation
        $get_tags = $db->prepare("
            SELECT tag_id FROM posts_tags
            WHERE  post_id = :post_id
        ");

        $get_tags->execute([ 'post_id' => $post_id ]);

        $original_tags = $get_tags->fetchAll(PDO::FETCH_COLUMN);


            if (!empty(arrays_compare($original_tags, $tags)))
            {
                $decision['tags'] = 1;
            }


       if ($decision['title_text'] == 0 && empty($decision['tags']))
        {
            flash()->warning("titles and text are equal, change something dumbass!");
            redirect('back');
        }

        return $decision;
    }


    /**
     *
     * Post Edit
     * Edit post by POST request items and decision array
     *
     *
     * @param $data
     * @param array $decision
     * @throws Exception
     */
    function post_edit( $data, $decision = [])
    {
        global $db;
        $return['error'] = true;

        extract($data);

        if ( $decision['title_text'] == 3)
        {
            $update_post = $db->prepare("
        UPDATE posts SET
            title = :title,
            text = :text
        WHERE
            id = :post_id
        ");
            $update_post->execute([
                'title' => $title,
                'text' => $text,
                'post_id' => $post_id
            ]);
            $title_text_change = $update_post->rowCount() ? true : false;

            if ( ! $title_text_change ) {
                $return['message'] = 'I didnt change text and title';
                return $return;
            }
        }

         elseif ($decision['title_text'] == 2)
        {
            $update_post = $db->prepare("
            UPDATE posts SET
                text = :text
            WHERE
                id = :post_id
            ");
            $update_post->execute([
                'text' => $text,
                'post_id' => $post_id
            ]);
            $title_text_change = $update_post->rowCount() ? true : false;

            if ( ! $title_text_change ) {
                $return['message'] = 'I didnt change text';
                return $return;
            }
        }
        elseif ($decision['title_text'] == 3)
        {
            $update_post = $db->prepare("
                UPDATE posts SET
                    title = :title
                WHERE
                    id = :post_id
                ");
            $update_post->execute([
                'title' => $title,
                'post_id' => $post_id
            ]);
            $title_text_change = $update_post->rowCount() ? true : false;

            if ( ! $title_text_change ) {
                $return['message'] = 'I didnt change title';
                return $return;
            }
        }

        //Tags change

        $tags_change = false;

        $tags = array_values(array_filter(array_unique($tags)));

        if ( isset($decision['tags']) && ! empty($decision['tags']) )
        {
            $delete_tags = $db->prepare("
                    DELETE FROM posts_tags
                    WHERE post_id = :post_id
                ");

            $delete_tags->execute([
                'post_id' => $post_id
            ]);

            $insert_tags = $db->prepare("
                        INSERT INTO posts_tags
                        VALUES (:post_id, :tag_id)
                    ");

            foreach ( $tags as $tag_id )
            {
                $insert_tags->execute([
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                ]);

            }
            $tags_change = $insert_tags->rowCount() ? true : false ;
            if ( ! $tags_change ) {
                $return['message'] = 'I didnt change tags';
                return $return;
            }
        }

        $post = get_post($post_id, false);
        if ( $title_text_change || $tags_change )
        {
            $return['error'] = false;
            $return['message'] = 'You made it';
        }

        return $return;
    }

    function format_comment( $comment)
    {
        global $db;

        //trim all data in array
        $comment = array_map('trim', $comment);

        //clean it up
        $comment['text'] = plain($comment['text']);

        //add comment's author name
        $query = $db->query("
            SELECT user_name FROM phpauth_users
            WHERE id = {$comment['user_id']} 
        ");

        $comment['author'] = $query->fetch(PDO::FETCH_COLUMN);


        //let's go on some dates
        $comment['timestamp'] = strtotime($comment['created_at']);
        $comment['time'] = str_replace(' ','&nbsp;',date('j M Y, G:i ', $comment['timestamp']));
        $comment['date'] = date('Y-m-d', $comment['timestamp']);

        return (object) $comment;
    }

    function get_post_comments( $post_id )
    {
        global $db;

        $query = $db->prepare("
            SELECT * FROM comments
            WHERE post_id = :post_id
            ORDER BY created_at ASC 
        ");

        $query->execute([ 'post_id' => $post_id ]);


        if ( ! $query->rowCount() )
        {
            return false;
        }

        $array_comments = $query->fetchAll(PDO::FETCH_ASSOC);

        $comments = [];

        foreach ($array_comments as $comment) {
            $comment = format_comment($comment);
            array_push($comments, $comment);
        }

        return (object) $comments;
    }








