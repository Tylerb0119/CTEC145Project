<?php
require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
require_once __DIR__ . "/../app/config.inc.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = hash('sha512', $_POST['password']);

    $sql = "SELECT * FROM $registration_table WHERE email=:email AND password=:password";

    $stmt = $db->prepare($sql);
    $stmt->execute(["email" => $email, "password" => $password]);

    if ($stmt->rowCount() == 1) {
        $_SESSION['loggedin'] = 1;
        $_SESSION['email'] = $email;
        $row = $stmt->fetch();
        $_SESSION['first_name'] = $row->first_name;
        header('location: index.php');
    } else {
        $error = '<div class="col-6 alert alert-danger mt-5" role="alert"><h2>Please enter valid info</h2></div>';
    }
} else {
    $error = "";
}



if (isset($_GET['logout'])) {
    if ($_GET['logout'] == "yes") {
        session_destroy();
    }
}
