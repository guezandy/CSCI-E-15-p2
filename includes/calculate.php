<?php
/*
 * This is the script that the form on index.php submits to
 * Its job is to:
 * 1. Get the data from the form request
 * 2. Calculate the pace needed to run
 * 3. Store the results in the SESSION
 * 4. Redirect the visitor back to index.php
 */

# We'll be storing data in the session, so initiate it
session_start();

# Get data from form request
extract($_POST);

# Calculate pace
$pace = 2;

# Store our results data in the SESSION so it's available when we redirect back to index.php
$_SESSION['results'] = [
    'distance' => $distance,
    'hours' => $hours,
    'minutes' => $minutes,
    'unit' => $unit,
    'pace' => $pace
];

# Redirect back to the form on index.php
header('Location: ../index.php');
