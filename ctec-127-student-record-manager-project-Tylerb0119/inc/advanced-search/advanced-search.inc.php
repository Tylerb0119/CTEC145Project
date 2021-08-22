<?php // Filename: advanced-search.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../app/config.inc.php";


#holds database column name and placeholder
$query = [];
# empty array that will be turned into associative array
$students = [];
# set to a empty array so there are no errors prior to it containing information from the database
$record = [];

# Checks for the post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # The beginning of my sql select statement 
    $sql = "SELECT * FROM $db_table WHERE ";
    # Checks too see if ANYTHING is set within the advanced search fields
    if (!empty($_POST["first"]) || !empty($_POST["last"]) || !empty($_POST["student_id"]) || !empty($_POST["email"]) || !empty($_POST["phone"]) || !empty($_POST["gpa"]) || ($_POST["grad_date"]) != null || isset($_POST["financial_aid"]) || $_POST["degree_program"] != "-") {
        # If there is sets this variable to false
        $noSearchSet = false;
        # checking each field individually and if something is it will send the placeholder to the query array and create a piece of the associative array that will be passed into the corresponding placeholder
        if (!empty($_POST["first"])) {
            array_push($query, "first_name LIKE :first");
            $students["first"] = $_POST["first"] . "%";
            $first = $_POST["first"];
        }
        if (!empty($_POST["last"])) {
            array_push($query, "last_name LIKE :last");
            $students["last"] = $_POST["last"] . "%";
            $last = $_POST["last"];
        }
        if (!empty($_POST["student_id"])) {
            array_push($query, "student_id LIKE :student_id");
            $students["student_id"] = intval($_POST["student_id"]) . "%";
            $student_id = intval($_POST["student_id"]);
        }
        if (!empty($_POST["email"])) {
            array_push($query, "email LIKE :email");
            $students["email"] = $_POST["email"] . "%";
            $email = $_POST["email"];
        }
        if (!empty($_POST["phone"])) {
            array_push($query, "phone LIKE :phone");
            $students["phone"] = $_POST["phone"] . "%";
            $phone = $_POST["phone"];
        }
        if (!empty($_POST["gpa"])) {
            array_push($query, "gpa LIKE :gpa");
            $students["gpa"] = floatval($_POST["gpa"]) . "%";
            $gpa = floatval($_POST["gpa"]);
        }
        if (($_POST["grad_date"]) != null) {
            $grad_date = $_POST["grad_date"];
            array_push($query, "graduation_date = :graduation_date");
            $students["graduation_date"] = $grad_date;
        }
        if (isset($_POST["financial_aid"])) {
            $financial_aid = $_POST["financial_aid"];
            array_push($query, "financial_aid LIKE :financial_aid");
            if ($financial_aid == 1) {
                $students["financial_aid"] = 1;
                $fin_aid_yes = true;
                $fin_aid_no = false;
            } else if ($financial_aid == 0) {
                $students["financial_aid"] = 0;
                $fin_aid_no = true;
                $fin_aid_yes = false;
            }
        } else {
            $financial_aid = null;
            $fin_aid_yes = null;
            $fin_aid_no = null;
        }
        if ($_POST["degree_program"] != "-") {
            array_push($query, "degree_program LIKE :degree_program");
            $students["degree_program"] = $_POST["degree_program"];
            $degree_program = $_POST["degree_program"];
        } else {
            $degree_program = null;
        }

        $sql .= implode(" AND ", $query);
        $stmt = $db->prepare($sql);
        $stmt->execute($students);
        $records = $stmt->fetchAll();
    } else {
        # Sets a variable to true if no search parameters were entered in any of the fields
        $noSearchSet = true;
        # setting all the variables to null since the form would have been posted with no results being displayed which caused errors in the form 
        $records = null;
        $first = null;
        $last = null;
        $student_id = null;
        $email = null;
        $phone = null;
        $gpa = null;
        $financial_aid = null;
        $fin_aid_yes = null;
        $fin_aid_no = null;
        $degree_program = null;
        $grad_date = null;
    }
} else {
    # Setting all the values to null so that the form doesnt have a bunch of errors because of the sticky fields
    $first = null;
    $last = null;
    $student_id = null;
    $email = null;
    $phone = null;
    $gpa = null;
    $financial_aid = null;
    $fin_aid_yes = null;
    $fin_aid_no = null;
    $degree_program = null;
    $grad_date = null;
}
