<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= isset($page_title) ? "$page_title / " : '' ?>MINIBLOG</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= asset('css/main.css') ?>">

	<script>
		var baseURL = '<?= BASE_URL ?>';
	</script>
</head>
<body class="<?= segment(1) ? plain(segment(1)) : 'home'; ?>">

    <header class="container">
        <?= flash()->display() ?>

        <?php if ( logged_in() ) :  ?>
            <div class="navigation">
                <div class="btn-group btn-group-sm pull-left">
                    <a href="<?= BASE_URL ?>" class="btn btn-default">home</a>
                    <a href="<?= BASE_URL ?>/user/<?= $logged_in->id ?>" class="btn btn-default">my posts</a>
                    <a href="<?= BASE_URL ?>/add-new-post" class="btn btn-default">add new</a>
                    <a href="<?= BASE_URL ?>/tags-list" class="btn btn-default">tags list</a>
                </div>
                <div class="btn-group btn-group-sm pull-right">
                    <a href="<?= BASE_URL ?>/user-edit" class="btn btn-default"><span class="username"><?= plain( $logged_in->user_name ) ?> ( <?= $logged_in->authority ?> )</span></a>
                    <?php if( $logged_in->authority == 'admin') : ?>
                        <a href="<?= BASE_URL ?>/admin" class="btn btn-warning">ADMIN</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/logout" class="btn btn-default logout">logout</a>
                </div>
            </div>

        <?php endif; ?>
    </header>

    <main>
        <div class="container">
