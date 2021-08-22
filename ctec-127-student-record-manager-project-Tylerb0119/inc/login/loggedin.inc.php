<?php
if (!isset($_SESSION['loggedin'])) {
    echo '<div class="container">';
    echo '<div class="row mt-5">';
    echo "<h2>Please <a href='login.php'>Login</a> or <a href='registration.php'>Register</a><h2>";
    die();
}
