<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (logged_in()) {
            redirect('/');
        }
    }

  if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {

        $email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        echo '<pre>';
            print_r($email);
        echo '</pre>';

        $reset = $auth->requestReset($email, $config['email_activation']);


        if ( $reset['error'] == 1 )
        {
            flash()->error( $reset[ 'message' ] );
        }
        else
        {
            flash()->success( $reset[ 'message' ] );
            redirect('/create-new-password');
        }
    }

    include_once '_partials/header.php';


?>
<form method="post" action="" class="box box-auth">

    <h2 class="box-auth-heading">
        Reset your password
    </h2>

    <input type="text" value="" name="email" class="form-control" placeholder="Input you email address" required>
    <button class="btn btn-lg btn-primary btn-block">Reset password</button>

    <p class="alt-action text-center">
        or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
    </p>
</form>


<?php include_once '_partials/footer.php'; ?>
