<?php // Filename: connect.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
?>
<?php
# checks for the ID via POST
$error_bucket = [];
# I just took the create code and modified that to fit my needs for update as you can see some of your comments are still leftover.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #checks for the ID on post so that if its not a successful update we still have the ID to retain the information in the form as sticky.
    $id = $_POST["id"];
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
    if (($_POST["grad_date"]) == null) {
        $grad_date = null;
    } else {
        $grad_date = $_POST["grad_date"];
    }
    if (empty($_POST["gpa"])) {
        array_push(
            $error_bucket,
            "<p>Please enter your GPA it is required.</p>"
        );
    } else {
        $gpa = $_POST["gpa"];
    }
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
    // If we have no errors than we update the data
    if (count($error_bucket) == 0) {
        // Time for some SQL
        # I modified the code from so rather than insert its update since im updating the database.
        # added graduation date to the placeholders
        $sql = "UPDATE $db_table SET first_name = :first_name,last_name=:last_name,email=:email,phone=:phone,student_id=:student_id,gpa=:gpa,financial_aid=:financial_aid,degree_program=:degree_program,graduation_date = :graduation_date WHERE id=:id";
        $stmt = $db->prepare($sql);
        # updates the information via associative array
        # Added graduation date to the update associative array
        $stmt->execute(["first_name" => $first, "last_name" => $last, "email" => $email, "phone" => $phone, "student_id" => $student_id, "gpa" => $gpa, "financial_aid" => $financial_aid, "degree_program" => $degree_program, "graduation_date" => $grad_date, "id" => $id]);
        if ($stmt->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">
            I am sorry, but I could not save that record for you.</div>';
        } else {
            header("Location: index.php?message=The record for $first has been updated.");
        }
    } else {
        display_error_bucket($error_bucket);
    }
}


# Since we will be doing a get request we have to get the ID from the query parameter.
if (!isset($id)) {
    $id = $_GET["id"];
}


#fetching the student record via the ID from the table
$sql = "SELECT * FROM $db_table WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->execute(["id" => $id]);
$studentrecord = $stmt->fetch();

# Resetting all the variables so all the form data will be sticky
$first = $studentrecord->first_name;
$last = $studentrecord->last_name;
$student_id = $studentrecord->student_id;
$email = $studentrecord->email;
$phone = $studentrecord->phone;
$gpa = $studentrecord->gpa;
$financial_aid = $studentrecord->financial_aid;
$grad_date = $studentrecord->graduation_date;
if ($financial_aid == 1) {
    $fin_aid_yes = true;
    $fin_aid_no = false;
} else {
    $fin_aid_yes = false;
    $fin_aid_no = true;
}
$degree_program = $studentrecord->degree_program;
