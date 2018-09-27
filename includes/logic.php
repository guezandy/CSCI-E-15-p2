<?php
/*
 * This is the logic file for index.php; it's job is to check the
 * SESSION for results, and if available, store the results in variables we
 * can display in index.php
 */
session_start();

# Get `results` data from session, if available
if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
    extract($form);
}

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    extract($errors);
}

# Logic to help simplify logic in the display code
# This code just determines what css class to add to each field
$validation_state = [];
foreach (['distance', 'hours', 'minutes', 'unit'] as $field) {
    if (isset($errors)) {
        $validation_state[$field] = isset($errors[$field . '_error']) ? 'is-invalid' : 'is-valid';
    }
}

if (isset($_SESSION['results'])) {
    $results = $_SESSION['results'];
}

# Clear session data so our results are cleared when the page is refreshed
session_unset();
