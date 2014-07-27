<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', true);

$app = new \Slim\Slim(array('debug' => true, 'templates.path' => __DIR__ . '/../templates/'));
$db = new mysqli('127.0.0.1', 'root', '123456', 'todo');

$app->get('/', function() use ($app, $db)
{
    $app->render('todo.php');
});

$app->post('/insert', function() use ($app, $db)
{
    $todo = $app->request->post('todo');
    if (empty($todo))
    {
        echo 'error:Todo should not be empty.';
        return;
    }

    $stmt = $db->prepare("insert into todo (todo) VALUES(?)");
    $stmt->bind_param('s', $todo);
    $stmt->execute();

    echo 'ok:' . $stmt->insert_id;
});

$app->run();
$db->close();