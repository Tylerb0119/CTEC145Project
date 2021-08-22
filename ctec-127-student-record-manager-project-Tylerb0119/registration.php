<?php // Filename: registration.php
$pageTitle = "Registration";
require_once 'inc/layout/header.inc.php';
?>


<div class="container">
    <div class="row">
        <?php require_once __DIR__ . '/inc/create/registration.inc.php'; ?>
    </div>
    <div class="row mt-5">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <h1 class="mb-5">Registration</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>" method="POST">
                <label class="col-form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required>
                <label class="col-form-label" for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" required>
                <label class="col-form-label" for="first_name">First Name</label>
                <input class="form-control" type="text" id="first_name" name="first_name" required>
                <label class="col-form-label" for="last_name">Last Name</label>
                <input class="form-control" type="text" id="last_name" name="last_name" required>
                <button class="btn btn-primary mt-5" type="submit" value="Register">Register</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'inc/layout/footer.inc.php'; ?>