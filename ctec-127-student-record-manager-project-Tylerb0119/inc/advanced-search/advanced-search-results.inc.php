<?php
require_once __DIR__ . "/../advanced-search/advanced-search.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # If the variable was set to false in "advanced-search.inc.php that means there was something entered within one of the fields so the code can continue
    if ($noSearchSet == false) {
        # checks that the count of records going to be shown is greater than 0 if they are it displays them
        if (count($records) > 0) {
            echo '<h2>Here are your results</h2>';
            display_record_table($records);
        } else {
            # if the count isnt greater than 0 you get a frowny face
            echo "<h2 class='text-center'>Seems we have no records for you</h2>";
            echo "<img class='mx-auto d-block mt-4' src='img/frown.png' alt='frown'>:";
        }
    } else {
        # and if that $noSearchSet varaible is set to true you get this message
        echo "<div class='text-center alert alert-danger' role='alert'>";
        echo "<h2>Im sorry but no search parameters were set</h2>";
        echo "</div>";
    }
} else {
    echo '<div class="alert alert-info">';
    echo '<h2>Search results will appear here</h2>';
    echo '</div>';
}
