<?php

    include_once '_partials/header.php';

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {


        $user_name = filter_input( INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $currpass = $_POST['currpass'];
        $newpass = $_POST['newpass'] ?: '';
        $repeatnewpass = $_POST['repeatnewpass']?: '';


        $edit = edit_user_data( $logged_in->uid , $user_name, $email, $currpass, $newpass, $repeatnewpass );
        echo '<pre>';
            print_r($edit);
        echo '</pre>';

        if ( $edit['error'] == true )
        {
            flash()->error( $edit[ 'message' ] );
            redirect('back');
        }
        else
        {
            flash()->success( 'You have edit your stuff, good job!' );
            redirect('back');
        }
    }

?>

<form method="post" action="" class="box box-auth">

    <h2 class="box-auth-heading">
        Edit your stuff, if you are able to do it, dumbass
    </h2>

    <input type="text" value="<?= $logged_in->email; ?>" name="email" class="form-control" placeholder="Email Address">
    <input type="text" value="<?= $logged_in->user_name; ?>" name="user_name" class="form-control" placeholder="User name">

    <h4 class="box-auth-heading">
        Change your password here, if you still remember it
    </h4>


    <input type="password" name="newpass" class="form-control" placeholder="new password">
    <input type="password" name="repeatnewpass" class="form-control" placeholder="new password again, DO IT!">

    <h4 class="box-auth-heading">
        Put your current password to verify changes.
    </h4>

    <input type="password" name="currpass" class="form-control" placeholder="current password">

    <button class="btn btn-lg btn-primary btn-block">Edit stuff</button>

    <p class="alt-action text-center">
        or <a href="<?= BASE_URL ?>/"> go away</a>
    </p>
</form>


<?php include_once '_partials/footer.php'; ?>


