<?php
/*
 * This is the logic file for index.php; it's job is to check the
 * SESSION for results, and if available, store the results in variables we
 * can display in index.php
 */
session_start();

# Get `results` data from session, if available
if(isset($_SESSION['results'])) {
    $results = $_SESSION['results'];
    extract($results);
}
# Clear session data so our results are cleared when the page is refreshed
session_unset();
