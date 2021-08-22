<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
require_once __DIR__ . "/../app/config.inc.php";

$error_bucket = [];
# Watched the video on sticky radio buttons and like you said they need to be set for when you get the page so it doesnt get a error
$fin_aid_yes = false;
$fin_aid_no = false;
# set to the dash so it always starts as the "--select--" option until its posted
$degree_program = "-";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // First insure that all required fields are filled in
    if (empty($_POST["first"])) {
        array_push($error_bucket, "<p>A first name is required.</p>");
    } else {
        $first = $_POST["first"];
    }
    if (empty($_POST["last"])) {
        array_push($error_bucket, "<p>A last name is required.</p>");
    } else {
        $last = $_POST["last"];
    }
    if (empty($_POST["student_id"])) {
        array_push($error_bucket, "<p>A student ID is required.</p>");
    } else {
        $student_id = intval($_POST["student_id"]);
    }
    if (empty($_POST["email"])) {
        array_push($error_bucket, "<p>An email address is required.</p>");
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["phone"])) {
        array_push($error_bucket, "<p>A phone number is required.</p>");
    } else {
        $phone = $_POST["phone"];
    }
    # Added graduation date
    if (empty($_POST["grad_date"])) {
        $grad_date = null;
    } else {
        $grad_date = $_POST["grad_date"];
    }
    #adding the GPA, financial-aid and degree-program to the conditions of either adding it to the error bucket or setting its post to a variable
    if (empty($_POST["gpa"])) {
        array_push(
            $error_bucket,
            "<p>Please enter your GPA it is required.</p>"
        );
    } else {
        $gpa = $_POST["gpa"];
    }
    # If structure to get a variable for each of the radio buttons so I can make them sticky
    if (isset($_POST["financial_aid"])) {
        $financial_aid = $_POST["financial_aid"];
        if ($financial_aid == 1) {
            $fin_aid_yes = true;
            $fin_aid_no = false;
        } else {
            $fin_aid_yes = false;
            $fin_aid_no = true;
        }
    } else {
        array_push($error_bucket, "<p>Please select yes or no if you have financial aid it is required.</p>");
    }
    if ($_POST["degree_program"] == "-") {
        array_push($error_bucket, "<p>Please select a degree-program it is required.</p>");
    } else {
        $degree_program = $_POST["degree_program"];
    }
    // If we have no errors than we can try and insert the data
    if (count($error_bucket) == 0) {
        // Time for some SQL
        # Added the GPA, financial aid and degree program to the insert into table statements as well as the placehold values
        $sql = "INSERT INTO $db_table (first_name,last_name,email,phone,student_id,gpa,financial_aid,degree_program,graduation_date)";
        $sql .= "VALUES (:first,:last,:email,:phone,:student_id,:gpa,:financial_aid,:degree_program,:graduation_date)";

        $stmt = $db->prepare($sql);
        # added GPA, financial aid and degree program to the statement that will be adding the data via associative array to the table
        # Added graduation date to the associative array
        $stmt->execute(["first" => $first, "last" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id, "gpa" => $gpa, "financial_aid" => $financial_aid, "degree_program" => $degree_program, "graduation_date" => $grad_date]);

        if ($stmt->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">
            I am sorry, but I could not save that record for you.</div>';
        } else {
            header("Location: index.php?message=The record for $first has been created.");
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
