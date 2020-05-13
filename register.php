<?php

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $user_name = filter_input( INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $password_repeat = $_POST['repeat'];

        $register = $auth->register($user_name, $email, $password, $password_repeat, [], '', $config['email_activation']);


        if ( $register['error'] == 1 )
        {
            flash()->error( $register[ 'message' ] );
        }
        else if ( $register['error'] == 0 && $config['email_activation'])
        {
            flash()->success( 'You successfully registered! We have sent an activation code to you email!' );
            redirect('/activate');
        }
        else {
            flash()->success( 'You successfully registered!Now you can login!' );
            redirect('/login');
        }
    }

    include_once '_partials/header.php';

?>

<form method="post" action="" class="box box-auth">

    <h2 class="box-auth-heading">
        Register here and now, dumbass
    </h2>

    <input type="text" value="<?= $email; ?>" name="email" class="form-control" placeholder="Email Address" required>
    <input type="text" value="<?= $user_name; ?>" name="user_name" class="form-control" placeholder="User name" required>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <input type="password" name="repeat" class="form-control" placeholder="Password again, bitch please, DO IT!" required>
    <button class="btn btn-lg btn-primary btn-block">Register</button>

    <p class="alt-action text-center">
        or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
    </p>
</form>

<?php include_once '_partials/footer.php'; ?>
