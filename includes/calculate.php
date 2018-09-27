<?php
/*
 * This is the script that the form on index.php submits to
 * Its job is to:
 * 1. Get the data from the form request
 * 2. Validate all required fields Form validators
 * 3. Validate inputs using additional validators
 * 4. Calculate the pace needed to run
 * 5. Store the results, errors and form data in the SESSION
 * 6. Redirect the visitor back to index.php
 */

require 'helpers.php';
require 'Form.php';

use DWA\Form;

# Constants
$MAX_DISTANCE_MILES = 350; # Max miles runnable by a human
$MAX_DISTANCE_KILOMETERS = $MAX_DISTANCE_MILES * 1.6; # Max kilometers runnable by a human
$MAX_HOURS = 90; # World record longest continuous run was 87 hours.

# We'll be storing data in the session, so initiate it
session_start();

# Initialize form handler
$form = new Form($_GET);

# Use form validator as much as possible
$validators = [
    'distance' => 'required|numeric|min:0.01',
    'hours' => 'required|digit|min:0|max:' . $MAX_HOURS,
    'minutes' => 'required|digit|min:0|max:59',
    'unit' => 'required'
];

$errors = [];
# Split each validator into separate fields to know which field has an error
foreach ($validators as $field => $criteria) {
    $field_errors = $form->validate([
        $field => $criteria
    ]);
    if (!empty($field_errors)) {
        # Only take the first error - since we can only show 1 error in this UI as it is.
        $errors[$field] = $field_errors[0];
    }
}

# Other validators not defined in Form
$hours = (float) $form->get('hours');
$minutes = (float) $form->get('minutes');
$distance = (float) $form->get('distance');
$unit = $form->get('unit');

# Either minutes or hours must contain a value
if ($minutes == 0 && $hours == 0) {
    $errors['hours'] = 'Either minutes or hours must be greater than 0';
    $errors['minutes'] = 'Either minutes or hours must be greater than 0';
}

# Unit must be a valid value - just in case anyone modifies the DOM
if (!in_array($unit, ['mile', 'kilometer'])) {
    $errors['unit'] = 'Invalid distance unit - must be mile or kilometer';
}

$max_distance = $unit == 'mile' ? $MAX_DISTANCE_MILES : $MAX_DISTANCE_KILOMETERS;
if ($distance > $max_distance) {
    $errors['distance'] = $distance . ' ' . $unit . 's is not humanly possible - yet.';
}

# If no errors then calculate the running pace
if (empty($errors)) {
    $total_number_of_minutes = $hours * 60 + $minutes;
    $minutes_per_distance = $total_number_of_minutes / $distance;

    # Convert fractional minutes into seconds for legibility
    $fractional_seconds = $minutes_per_distance - (int)$minutes_per_distance;
    if ($fractional_seconds > 0) {
        # Converting to int cause not really interested in fractions of seconds
        $seconds_per_distance = (int)(60 * $fractional_seconds);
        $minutes_per_distance = (int)$minutes_per_distance;
    }

    # Convert greater than 60 minutes into hours for legibility
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
    $result_string = $result_string . ' ' . $minutes_per_distance . ' ' . $minutes_pluralize;
    if (isset($seconds_per_distance)) {
        $second_pluralize = $seconds_per_distance == 1 ? 'second' : 'seconds';
        $result_string = $result_string . ' and ' . $seconds_per_distance . ' ' . $second_pluralize;
    }
    $result_string = $result_string . ' per ' . $unit;

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
