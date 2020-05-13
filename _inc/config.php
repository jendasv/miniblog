<?php

// show all errors
ini_set('display_startup_errors', 'on');
ini_set('display_errors', 'on');
error_reporting(E_ALL & ~ E_NOTICE);


// require stuff
if( !session_id() ) @session_start();
require_once 'vendor/autoload.php';


// constant & settings
define('BASE_URL', 'http://localhost/miniblog'); // copy your home page url
define('APP_PATH', realpath(__DIR__. '/../'));


//configurations
$config = [
    'email_activation' => true, // true - emailing ( register, reset password ), false (you can register but not reset password)
    'db' => [
        'type' => 'mysql',
        'name' => 'miniblog',
        'server' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8'
    ],
];

// connect to db
$db = new PDO(
    "{$config['db']['type']}:host={$config['db']['server']};
    dbname={$config['db']['name']};charset={$config['db']['charset']}",
    $config['db']['username'],
    $config['db']['password']
);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


//global functions
require_once 'functions-general.php';
require_once 'functions-string.php';
require_once 'functions-auth.php';
require_once 'functions-post.php';

//PHPAuth inc
use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

$auth_config = new PHPAuthConfig( $db );
$auth = new PHPAuth( $db, $auth_config, "cs_CZ" );

/*if (!$auth->isLogged()) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";

    exit();
}*/

/*try {
    $query = $db->query("SELECT * FROM tags");
    echo '<pre>';
        print_r($query->fetchAll(PDO::FETCH_ASSOC));
    echo '</pre>';
}
catch( PDOException $e ) {

    $error = date('j. m. Y, G:i') . PHP_EOL;
    $error .= '--------------------------------' . PHP_EOL;
    $error .= $e->getMessage(). PHP_EOL . ' in [ '. __FILE__. ' : '. __LINE__ .' ] ' . PHP_EOL . PHP_EOL;

    file_put_contents(APP_PATH . '/_inc/error.log', $error.PHP_EOL, FILE_APPEND );
}*/



