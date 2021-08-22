<?php // Filename: login.php
$pageTitle = "Login";
require_once 'inc/layout/header.inc.php';
require_once __DIR__ . '/inc/create/login.inc.php';
?>

<div class="container">
    <div class="row">
        <?= $error; ?>
    </div>
    <div class="row mt-5">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <h1 class="mb-5">Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>" method="POST">
                <label class="col-form-label" for=" email">Email</label>
                <input class="form-control" type="text" name="email" id="email">
                <label class="col-form-label" for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password">
                <button class="btn btn-primary mt-5" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
<?php require_once 'inc/layout/footer.inc.php'; ?>