<?php
require_once "router.php";

route('/', function () {
    require __DIR__ . '/home.php';
});

route('/callback', function () {
    $mpesares = json_encode(file_get_contents("php://input"));
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pesa";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO mpesa_transactions (response) VALUES ($mpesares)";
    $file = "./res.txt";
    if ($conn->query($sql) === true) {
        file_put_contents($file, $mpesares);
    } else {
        file_put_contents($file, "Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();
});

route('/about', function () {
    return "This is the about page";
});


$action = $_SERVER['REQUEST_URI'];
dispatch($action);
