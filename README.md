# PHP Base API

> With REST routes

> This code is an exemple that get some file from another server with NTML authentication


## How to add route

```PHP
$app = new Router($_GET['url']);

/* Create routes */
/* <route>, <callable>, <endpoint> */
$app->get('/table/feed', array(new TableExemple(), "run"), "tableexemple_download_resources");
$app->get('/table/:filename', array(new TableExemple(), "get"), "tableexemple_get_file");

/* Run application */
try {
    $app->run();
} catch (Exception $e) {
    header('HTTP/1.1 '.$e->getCode().' '.$e->getMessage());
}
```
