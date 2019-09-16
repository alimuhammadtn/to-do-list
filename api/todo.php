<?php
session_start();

header('Content-Type: application/json');

$conn    = mysqli_connect('localhost', 'root', '', 'vue_todo');
$request = $_SERVER['REQUEST_METHOD'];
$user_id = $_SESSION['user'];

switch ($request) {
    case 'GET':
        $q = "SELECT * FROM todo where user_id='$user_id'";
        $result = mysqli_query($conn, $q);

        if (mysqli_num_rows($result) > 0) {
            echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
            http_response_code(200);
            die();
        } 
        break;

    case 'POST':
        $text = $_POST['text'];
        $done = $_POST['done'];
        $date = $_POST['date'];      

        if (!isset($text)) {
            http_response_code(400);
            die();
        } else {
            echo $q = "INSERT INTO todo (`text`, `done`, `id_date`,`user_id`) VALUES ('$text', '$done', '$date','$user_id')";
            $result = mysqli_query($conn, $q);
            http_response_code(200);
            die();
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $q = "DELETE FROM todo WHERE id = '$id'";
        // die($q);
        $result = mysqli_query($conn, $q);

        http_response_code(200);
        die();
        break;

    case 'PATCH':
        $id_date = $_GET['id'];
        if($_GET['action']=='mark')
        {
            $mark    = $_GET['mark'];
            echo $q = "UPDATE todo SET mark = '$mark' WHERE id = '$id_date'";
        }
        else if($_GET['action']=='update')
        {
            $done    = $_GET['done'];
            $q = "UPDATE todo SET done = '$done' WHERE id = '$id_date'";
        }
        // die($q);
        $result = mysqli_query($conn, $q);

        http_response_code(200);
        die();
        break;
    
    default:
        # code...
        break;
}