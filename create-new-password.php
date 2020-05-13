<?php

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (logged_in()) {
            redirect('/');
        }
    }

    if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
    {
        $key = filter_input( INPUT_POST, 'key', FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $password_repeat = $_POST['repeat'];
        echo '<pre>';
            print_r($key);
        echo '</pre>';
        $new_pass = $auth->resetPass($key, $password, $password_repeat);
        echo '<pre>';
            print_r($new_pass);
        echo '</pre>';

     if ( $new_pass['error'] == 1 )
        {
            flash()->error( $new_pass[ 'message' ] );
        }
        else
        {
            flash()->success( $new_pass[ 'message' ] );
            redirect('/login');
        }
    }

    include_once '_partials/header.php';


?>

<form method="post" action="" class="box box-auth">

    <h2 class="box-auth-heading">
        Create new password
    </h2>

    <input type="text" name="key" class="form-control" placeholder="Input key from email">
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <input type="password" name="repeat" class="form-control" placeholder="Password again, please, DO IT!" required>

    <button class="btn btn-lg btn-primary btn-block">Create new password</button>

</form>


<?php include_once '_partials/footer.php'; ?>
