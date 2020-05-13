<?php

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $remember = $_POST['rememberMe'] ? 1 : 0;

        $login = $auth->login( $email, $password, $remember );


        if ( $login['error'] == 1 )
        {
            flash()->error( $login[ 'message' ] );
            redirect('/login');
        }
        else
        {
            do_login( $login );

            flash()->success( 'You have logged successfully  in !' );
            redirect('/');
        }
    }

    include_once '_partials/header.php';

?>

<form method="post" action="" class="box box-auth">

    <h2 class="box-auth-heading">
        Login, bro!
    </h2>

    <input type="email" value="<?= $_POST['email'] ?: '' ?>" name="email" class="form-control" placeholder="Email Address" required>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <label class="checkbox">
        <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe" checked>
        Remember me
    </label>

    <button class="btn btn-lg btn-primary btn-block">Login</button>

    <p class="alt-action text-center">
        or <a href="<?= BASE_URL ?>/register">create account</a>
    </p>
    <p class="alt-action text-center">
        <a href="<?= BASE_URL ?>/password-reset-request">I forgot my password :(</a>
    </p>
</form>

<?php include_once '_partials/footer.php'; ?>
