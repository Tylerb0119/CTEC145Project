<?php
require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
require_once __DIR__ . "/../app/config.inc.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = hash('sha512', $_POST['password']);

    try {
        $sql = "INSERT INTO $registration_table (email,first_name,last_name,password) ";
        $sql .= "VALUES (:email,:first_name,:last_name,:password)";
        $stmt = $db->prepare($sql);
        $stmt->execute(["email" => $email, "first_name" => $first_name, "last_name" => $last_name, "password" => $password]);
    } catch (PDOException) {
        echo "<div class='col-6 alert alert-danger mt-5' role='alert'";
        echo "<h2>There was a problem registering your account</h2>";
        echo "</div>";
    }
    if ($stmt->rowCount() == 1) {
        echo "<div class='col-6 alert alert-success mt-5' role='alert'>";
        echo "<h2>You are now ready to go!</h2>";
        echo '<a href="login.php" title="Login Page">Login</a>';
        echo "</div>";
    }
}
