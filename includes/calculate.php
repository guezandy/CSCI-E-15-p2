<?php
/*
 * This is the script that the form on index.php submits to
 * Its job is to:
 * 1. Get the data from the form request
 * 2. Validate all required fields are present
 * 3. Validate all fields are within acceptable contraints
 * 4. Calculate the pace needed to run
 * 5. Store the results, errors and form data in the SESSION
 * 4. Redirect the visitor back to index.php
 */

# We'll be storing data in the session, so initiate it
session_start();

# Constants
$MAX_DISTANCE_MILES = 350; # Max miles runnable by a human
$MAX_DISTANCE_KILOMETERS = $MAX_DISTANCE_MILES * 1.6; # Max kilometers runnable by a human
$MAX_HOURS = 90; # World record longest continuous run was 87 hours.

# Validate all required params are set
$required_fields = ['distance', 'hours', 'minutes', 'unit'];
$errors = [];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        $errors[$field . '_error'] = $field . ' is required.';
    }
}

# Get data from form request
$hours = (float)($_POST['hours']);
$minutes = (float)($_POST['minutes']);
$distance = (float)($_POST['distance']);
$unit = $_POST['unit'];

# Validate parameters are correct
if ($hours < 0) {
    $errors['hours_error'] = 'Must be greater than 0';
} else if ($hours > $MAX_HOURS) {
    $errors['hours_error'] = 'Not humanly possible - yet.';
}

if ($minutes < 0 || $minutes >= 60) {
    $errors['minutes_error'] = 'Invalid value of minutes';
}

# Either minutes or hours must contain a value
if ($minutes == 0 && $hours == 0) {
    $errors['hours_error'] = 'Either minutes or hours must be greater than 0';
    $errors['minutes_error'] = 'Either minutes or hours must be greater than 0';
}

if (!in_array($unit, ['mile', 'kilometer'])) {
    $errors['unit_error'] = 'Invalid distance unit';
}

$max_distance = $unit == 'mile' ? $MAX_DISTANCE_MILES : $MAX_DISTANCE_KILOMETERS;

if ($distance <= 0) {
    $errors['distance_error'] = 'Invalid number of ' . $unit;
} else if ($distance > $max_distance) {
    $errors['distance_error'] = $distance . ' ' . $units . ' is not humanly possible - yet.';
}

# If no errors then calculate the running pace
if (count($errors) == 0) {
    $total_number_of_minutes = $hours * 60 + $minutes;
    $minutes_per_distance = $total_number_of_minutes / $distance;
    # Convert to time legible if greater than 60 minutes
    if ($minutes_per_distance > 60) {
        $hours_per_distance = (int)($minutes_per_distance / 60);
        $minutes_per_distance = $minutes_per_distance % 60;
    }

    # Convert result to human legible
    $result_string = '';
    if (isset($hours_per_distance)) {
        $hour_pluralize = $hours_per_distance == 1 ? 'hour' : 'hours';
        $result_string = $result_string . $hours_per_distance . ' ' . $hour_pluralize;
    }
    $minutes_pluralize = $minutes_per_distance == 1 ? 'minute' : 'minutes';
    $result_string = $result_string . ' ' . $minutes_per_distance . ' ' . $minutes_pluralize . ' per ' . $unit;

    # Store results in SESSION
    $_SESSION['results'] = $result_string;
}

# Store errors in the SESSION
$_SESSION['errors'] = $errors;

# Store our original form data in the SESSION so it's available when we redirect back to index.php
$_SESSION['form'] = [
    'distance_value' => $distance,
    'hours_value' => $hours,
    'minutes_value' => $minutes,
    'unit_value' => $unit
];

# Redirect back to the form on index.php
header('Location: ../index.php');
