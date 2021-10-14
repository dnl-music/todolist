<?php

$path = $_SERVER['REQUEST_URI'];

switch($path) {
    case "/todo/list":
        (new TodoController())->actionList();
        break;
    case "/todo/add":
        (new TodoController())->actionAdd();
        break;
    case "/todo/delete":
        (new TodoController())->actionDelete();
        break;
    case "/todo/done":
        (new TodoController())->actionDone();
        break;
    default:
        header('Content-Type: plain/text', true, 404);
        exit('Not Found.');
}