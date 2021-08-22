<?php // Filename: form.inc.php 
?>

<!-- Note the use of sticky fields below -->
<!-- Note the use of the PHP Ternary operator
Scroll down the page
http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
-->

<?php
// Button label logic
if (basename($_SERVER['PHP_SELF']) == 'create-record.php') {
    $button_label = "Save New Record";
} else if (basename($_SERVER['PHP_SELF']) == 'update-record.php') {
    $button_label = "Save Updated Record";
} else if (basename($_SERVER['PHP_SELF']) == 'advanced-search.php') {
    $button_label = "Search...";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <label class="col-form-label" for="first">First Name</label>
    <input class="form-control" type="text" id="first" name="first" value="<?= isset($first) ? $first : null ?>">
    <br>
    <label class="col-form-label" for="last">Last Name</label>
    <input class="form-control" type="text" id="last" name="last" value="<?= isset($last) ? $last : null ?>">
    <br>
    <label class="col-form-label" for="id">Student ID </label>
    <input class="form-control" type="number" id="id" name="student_id" value="<?= isset($student_id) ? $student_id : null ?>">
    <br>
    <label class="col-form-label" for="email">Email</label>
    <input class="form-control" type="text" id="email" name="email" value="<?= isset($email) ? $email : null ?>">
    <br>
    <label class="col-form-label" for="phone">Phone</label>
    <input class="form-control" type="text" id="phone" name="phone" value="<?= isset($phone) ? $phone : null ?>">
    <br>
    <!-- added graduation date -->
    <label class="col-form-label" for="grad_date">Graduation Date</label>
    <input class="form-control" type="date" id="grad_date" name="grad_date" value="<?= isset($grad_date) ? $grad_date : null ?>">
    <br>
    <!-- Added PHP to make the GPA field sticky-->
    <label class="col-form-label" for="gpa">GPA</label>
    <!-- made it accept decimals for GPA -->
    <input class="form-control" type="number" step="0.01" id="gpa" name="gpa" value="<?= isset($gpa) ? $gpa : null ?>">
    <br>
    <p>Financial Aid</p>
    <!-- added some PHP to make the radio buttons sticky -->
    <div class="form-check">
        <input class="form-check-input" type="radio" value="1" id="choice1" name="financial_aid" <?= $fin_aid_yes ? 'checked' : null ?>>
        <label class="form-check-label" for="choice1">Yes</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="0" id="choice2" name="financial_aid" <?= $fin_aid_no ? 'checked' : null ?>>
        <label class="form-check-label" for="choice2">No</label>
    </div>
    <br>
    <label class="col-form-label" for="degree_program">Degree-program</label>
    <br>
    <select class="form-select selectwidth" aria-label=".form-select-lg example" name="degree_program" id="degree_program">
        <!-- added some php to make the selects sticky -->
        <option value="-" <?php if ($degree_program == "-") echo 'selected="selected"'; ?>>--Select--</option>
        <option value="Web Development" <?php if ($degree_program == "Web Development") echo 'selected="selected"'; ?>>Web Development</option>
        <option value="Computer Science" <?php if ($degree_program == "Computer Science") echo 'selected="selected"'; ?>>Computer Science</option>
        <option value="Marketing" <?php if ($degree_program == "Marketing") echo 'selected="selected"'; ?>>Marketing</option>
        <option value="Accounting" <?php if ($degree_program == "Accounting") echo 'selected="selected"'; ?>>Accounting</option>
        <option value="Business Administration" <?php if ($degree_program == "Business Administration") echo 'selected="selected"'; ?>>Business Administration</option>
    </select>
    <br>
    <br>
    <a href=" index.php">Cancel</a>&nbsp;&nbsp;
    <button class="btn btn-primary" type="submit"><?= $button_label ?></button>
    <input type="hidden" name="id" value="<?= isset($id) ? $id : null ?>">
</form>