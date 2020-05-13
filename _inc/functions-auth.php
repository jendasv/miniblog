<?php


    /**
     * Do Login
     *
     * Create cookie after logging in
     *
     * @param $data
     */
    function do_login( $data )
    {
        global $auth_config;

        setcookie(
            $auth_config->cookie_name,
            $data['hash'],
            $data['expire'],
            $auth_config->cookie_path,
            $auth_config->cookie_domain,
            $auth_config->cookie_secure,
            $auth_config->cookie_http
        );
    }

    /**
     * Do Logout
     *
     * Log the user out
     *
     *
     * @return bool
     */
    function do_logout()
    {
        global $auth, $auth_config;

        if( ! $auth->isLogged() )
        {
            return true;
        }

        return $auth->logout( $_COOKIE[$auth_config->cookie_name] );
    }


    /**
     *
     * Get user
     *
     * Grab data for the logged in user
     *
     * @param int $user_id
     * @return array|bool
     */
    function get_user( $user_id = 0)
    {
       global  $auth, $auth_config;

       if ( ! $user_id && $auth->isLogged() )
       {
           $user_id = $auth->getSessionUID( $_COOKIE[$auth_config->cookie_name] ) ?: 0;
       }
        return (object) $auth->getUser( $user_id, true );
    }
    /**
     * Logged In
     *
     * returns if user is logged or not
     *
     * @return bool
     */
    function logged_in()
    {
        global  $auth, $auth_config;

        return $auth->isLogged();
    }

    /**
     *
     * Can Edit
     *
     * True if psot was written by the logged in user
     *
     * @param $post
     * @return bool
     */
    function can_edit( $post )
    {
        //must be logged in
        if ( ! logged_in() ) {
            return false;
        }

        if ( is_object($post) ) {
            $post_user_id = (int) $post->user_id;
        }
        else {
            $post_user_id = (int) $post['user_id'];
        }

        $user = get_user();

        $authority = authority();

        $access = false;

        if ( $authority == 1 && $post_user_id === $user->uid || $authority == 2 )
        {
            $access = true;
        }
        else {
            $access = false;
        }

        return $access;
    }

    /**
     *
     * Authority
     *
     * Return authority of user
     *  3 admin
     *  2 editor
     *  1 common user
     *
     * @param int $uid
     * @return bool|int
     */
    function authority( $uid = 0 )
    {

        if ( ! logged_in() ) {
            return false;
        }

        $user = get_user( $uid );

        $authority = 0;

        switch ($user->authority) {
            case 'admin':
                $authority = 1;
                break;
            case 'editor':
                $authority = 2;
                break;
            case 'user':
                $authority = 3;
                break;
        }

        return $authority;

    }


    /**
     *  Edit User's Data
     *
     * You can change user name, email, password
     *
     * @param $uid
     * @param string $user_name
     * @param string $email
     * @param string $currpass
     * @param string $newpass
     * @param string $repeatnewpass
     * @return mixed
     * @throws Exception
     */
    function edit_user_data( $uid, $user_name = '', $email = '', $currpass, $newpass = '', $repeatnewpass = '')
    {
        global $auth_config, $auth;
        $user = get_user($uid);
        $return['error'] = true;

        if ($currpass == '') {
            flash()->warning('You forgot to put password');
            redirect('back');
        }
        //password check
        $password_check = $auth->comparePasswords($uid, $currpass);
        if (! $password_check) {
            flash()->warning('Invalid password');
            redirect('back');
        }

        // change email
        if ( $email != '' && $email != $user->email ) //&& $user == '' || $user->user_name == $user_name )
        {

            $change_email = $auth->changeEmail( $uid, $email, $currpass);
            if ( $change_email['error'] == true )
            {
                $return['message'] = $change_email['message'];
                return $return;
            }
        }
        //change username
        if ( $user_name != '' && $user_name != $user->user_name ) //|| $email == '' || $email == $user->email )
        {
            $change_user_name = $auth->changeUserName( $uid, $user_name, $currpass);
            if ( $change_user_name['error'] == true )
            {
                $return['message'] = $change_user_name['message'];
                return $return;
            }

        }

        if ( $currpass && $newpass != '' && $repeatnewpass != '' )
        {
            if ( $newpass !== $repeatnewpass )
            {
                flash()->error('New pass and repeat new pass doesnt match');
                redirect('back');
            }

            $changepass = $auth->changePassword( $uid, $currpass, $newpass, $repeatnewpass);
            if ( $changepass['error'] == true )
            {
                $return['message'] = $changepass['message'];
                return $return;
            }

        }

        $return['error'] = false;
        $return['message'] = 'Your stuff was changed';

    }

    /**
     *
     * Get All Users
     *
     * Return data about all users for admin except admins
     *
     * @return array|bool
     */
    function get_all_users()
    {
        global $db;
       $query = $db->query("SELECT * FROM phpauth_users WHERE authority NOT IN ('admin')");
       $users = $query->fetchAll(PDO::FETCH_OBJ);
       if ( ! $users )
       {
           return false;
       }

        return $users;
    }

    function users_administration( $uid, $user_name, $email, $authority = '', $action )
    {
        global $db, $auth, $auth_config;

        $return['error'] = true;

        //info about logged user
        $admin = get_user();
        $user = get_user($uid);


        //check admin authority
        if ( $admin->authority !== 'admin' )
        {
            $return['message'] = 'You are not authorizied to do that';
            return $return;
        }

        //check if action were chosen
        if ( $action == '' )
        {
            $return['message'] = 'You forgot to choose action';
            return $return;
        }

        //Check if someone change hidden input thought dev tools
        if (  $uid != $user->id || $user_name != $user->user_name ) {
            $return['message'] = 'What are you trying, dumbass?';
            return $return;
        }

        //delete chosen user
        if ( $action == 'delete') {

            $query = $db->prepare("
                DELETE FROM phpauth_users 
                WHERE id = :uid
                ");

            $query->execute([ 'uid' => $uid ]);

            $return['message'] = 'delete user '. $user_name . '!';

        }


        if ( $action == 'change authority' && $user->authority != $authority) {


            $query = $db->prepare("
                UPDATE phpauth_users SET authority = :authority
                WHERE id = :uid
                ");

            $query->execute([ 'uid' => $uid ,'authority' => $authority ]);


            $return['message'] = 'change authority at user '. $user_name . ' from '. $user->authority .' to '. $authority . '!';
        }


        $return['error'] = false;
        $return['message'] = 'You succesfully ' . $return['message'];
        return $return;

    }