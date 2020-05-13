<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (logged_in()) {
            redirect('/');
        }
    }

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $key = filter_input( INPUT_POST, 'key', FILTER_SANITIZE_STRING);

        echo '<pre>';
            print_r($key);
        echo '</pre>';

        $actiavte = $auth->activate($key);


        if ( $actiavte['error'] == 1 )
        {
            flash()->error( $actiavte[ 'message' ] );
        }
        else
        {
            flash()->success( $actiavte['message'] );
            redirect('/login');
        }
    }


    include_once '_partials/header.php';

?>

<form method="post" action="" class="box box-auth">

    <h2 class="box-auth-heading">
        Activate account with your key
    </h2>

    <input type="text" value="<?= $email; ?>" name="key" class="form-control" placeholder="Input your activation key here, please" required>
    <button class="btn btn-lg btn-primary btn-block">Activate</button>

    <p class="alt-action text-center">
        or <a href="<?= BASE_URL ?>/login">come inside (of me)</a>
    </p>
</form>

<?php include_once '_partials/footer.php'; ?>
