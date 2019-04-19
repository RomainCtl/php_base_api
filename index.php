<?php
include_once("./router/router.php");
include_once("./services/tableexemple.php");

if (!isset($_GET['url']) || empty($_GET['url']) || $_GET['url'] == "index.php") {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>My Own API</title>
        <style>
        a, a:hover {
            text-decoration: none;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        </style>
    </head>
    <body>
        <img src="nothing_to_see_here.gif" alt="Nothing to see here Image"/>
    </body>
    </html>
    <?php
} else {
    $valid_passwords = array ("login" => '$3y$56$sdfgoSol3H40HSoZy1sdgfdsMDsqfEsqdcdd23Uidy9k8M64Rcuy'); # we may store it in other place x)
    $valid_users = array_keys($valid_passwords);

    $validated = array_key_exists('PHP_AUTH_USER', $_SERVER) && array_key_exists('PHP_AUTH_PW', $_SERVER) && in_array($_SERVER['PHP_AUTH_USER'], $valid_users) && password_verify($_SERVER['PHP_AUTH_PW'], $valid_passwords[$_SERVER['PHP_AUTH_USER']]);

    if (!$validated) {
        header('WWW-Authenticate: Basic realm="Restricted area"');
        header('HTTP/1.0 401 Unauthorized');
        die ("Not authorized");
    } else {
        $app = new Router($_GET['url']);

        /* Create routes */
        $app->get('/table/feed', array(new TableExemple(), "run"), "tableexemple_download_resources");
        $app->get('/table/:filename', array(new TableExemple(), "get"), "tableexemple_get_file");

        /* Run application */
        try {
            $app->run();
        } catch (Exception $e) {
            header('HTTP/1.1 '.$e->getCode().' '.$e->getMessage());
        }
    }
}
?>