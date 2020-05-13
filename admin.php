<?php


    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo '<pre>';
            print_r($_POST);
        echo '</pre>';
        $data = $_POST;

        extract($data);


        $edit = users_administration( $uid, $user_name, $email, $authority, $action );
        /*if ( $edit['error'] == true )
        {
            flash()->error( $edit['message'] );
            redirect('back');
        }
        else {
            flash()->success( $edit['message'] );
            redirect('back');
        }*/

    }


    include_once '_partials/header.php';

    $edit_options = [
            'delete', 'change authority'
    ];
    $edit_authority = [
            'admin', 'editor', 'user'
    ];
    $users = get_all_users();

    $posts = get_posts();

?>

    <section class="box post-list">
        <header class="post-header">
            <h1 class="box-heading">Admin&apos;s stuff</h1>
        </header>
        <h4>Overview:</h4>
        <p>Number of users: <strong><?= count((array)$users) ?></strong></p>
        <p>Number of posts: <strong><?= count((array)$posts) ?></strong></p>
    </section>
    <h2>Users</h2>

        <table class="table-responsive table-bordered table table-condensed">
            <thead>
            <tr>
                <th>User name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Authority</th>
                <th>Action</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $key) :?>
            <form class="overview" action="" method="post">
                <tr>
                    <td>
                        <input type="text" name="uid" value="<?= $key->id ?>" hidden >
                        <?= $key->user_name ?>
                        <input type="text" name="user_name" value="<?= $key->user_name ?>" hidden >
                    </td>
                    <td>
                        <?= $key->email ?>
                        <input type="text" name="email" value="<?= $key->email ?>" hidden >

                    </td>
                    <td><?= $key->status ?></td>
                    <td>
                        <select name="authority" id="">
                        <?php foreach ($edit_authority as $authority) : if ($authority == $key->authority) :?>
                            <option value="<?= $authority ?>" selected><?= $authority ?></option>
                            <?php else:?>
                            <option value="<?= $authority ?>" ><?= $authority ?></option>
                        <?php endif; endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select  name="action" id="">
                            <option value=""></option>
                            <?php foreach ($edit_options as $option) :?>
                                <option value="<?= $option ?>"><?= $option ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-warning">Edit user</button>
                        </div>
                    </td>
                </tr>
            </form>
            <?php endforeach; ?>
            </tbody>
        </table>



<?php include_once "_partials/footer.php" ?>


