    <?php

        require_once '_inc/config.php';


        $routes = [

            //HOMEPAGE
            '/' => [
                'GET' => 'home.php'
            ],

            //USER
            '/user' => [
                'GET' => 'user.php'             //user profile
            ],

            //LOGIN
            '/login' => [
                'GET' => 'login.php',           //login form
                'POST' => 'login.php',           //do login
            ],

            //REGISTER
            '/register' => [
                'GET' => 'register.php',        //register form
                'POST' => 'register.php',        //do register
            ],

            //ADMIN
            '/admin' => [
                'GET' => 'admin.php',        //ADMIN interface
                'POST' => 'admin.php',        //do ADMIN action
            ],


            //USER PERSONAL DATA EDIT
            '/user-edit' => [
                'GET' => 'user-edit.php',        //register form
                'POST' => 'user-edit.php',        //do register
            ],

            //ACCOUNT ACTIVATION
            '/activate' => [
                'GET' => 'activate.php',        //activation form
                'POST' => 'activate.php',        //do activation
            ],

            //PASSWORD RESET
            '/password-reset-request' => [
                'GET' => 'reset-password-request.php',        //resetpass request form
                'POST' => 'reset-password-request.php'       // sent resetpass email
            ],

            //CREATE NEW PASS
            '/create-new-password' => [
                'GET' => 'create-new-password.php',        //creat new pass form
                'POST' => 'create-new-password.php'        //create new pass
            ],


            //LOGOUT
            '/logout' => [
                'GET' => 'logout.php',            //logout user
            ],

            //POST
            '/post' => [
                'GET' => 'post.php',            //show post
                'POST' => '_admin/add-comment.php'   //add new post
            ],

            //ADD NEW POST
            '/add-new-post' => [
                'GET' => 'add.php',            //show post
                'POST' => '_admin/post-add.php'   //add new post
            ],

            //TAG
            '/tag' => [
                'GET' => 'tag.php',            //show posts for tag
            ],

            //TAGS LIST
            '/tags-list' => [
                'GET' => 'tags-list.php',            //show posts for tag
            ],

            //TAG EDIT
            '/edit-tag' => [
                'GET' => 'tag-edit.php',            //tag edit form
                'POST' => '_admin/edit-tag.php',    //edit tag
            ],

            //TAG DELETE
            '/delete-tag' => [
                'GET' => 'tag-delete.php',            //tag delete form
                'POST' => '_admin/delete-tag.php',      //delete tag
            ],

            //EDIT POST
            '/edit' => [
                'GET' => 'edit.php',            //show EDIT form
                'POST' => '_admin/post-edit.php'   //store new values
            ],

            //DELETE
            '/delete' => [
                'GET' => 'delete.php',            //show DELETE form
                'POST' => '_admin/post-delete.php'   //star DELETE procedure
            ],

        ];

        $page = segment(1);
        $method = $_SERVER['REQUEST_METHOD'];

        $public = [
            'login', 'register', 'activate', 'password-reset-request', 'create-new-password'
        ];

        $admin = [
            'admin'
        ];

        $logged_in = get_user(); //logged user data

        //not logged in, you can only visit $public links
        if ( ! logged_in() && !in_array( $page, $public ) )
        {
           redirect('/login');
        }

        // if you are not admin, you are not allowed to vist admin page
        if ( $logged_in->authority != 'admin' && in_array( $page, $admin ) )
        {
            redirect('/');
        }

        if ( ! isset($routes["/$page"][$method]))
        {
            show_404();
        }


        require $routes["/$page"][$method];