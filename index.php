<?php
require 'includes/logic.php';
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Pace math</title>
    <meta charset='utf-8'>

    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'
          rel='stylesheet'
          integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO'
          crossorigin='anonymous'>

    <link href='/styles/styles.css' rel='stylesheet'>
</head>
<body>
    <form method='POST' action='includes/calculate.php'>
        <div class="col-md-4 mb-3">
            <label for="distance">Enter distance</label>
            <input name='distance' class="form-control <?= $validation_state['distance'] ?? '' ?>" type='number' value='<?= $distance_value ?? '' ?>' required>
            <?php if (isset($errors)): ?>
                <?php if (isset($distance_error)) : ?>
                    <div class="invalid-feedback">
                        <?=$distance_error?>
                    </div>
                <?php else: ?>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                <?php endif; ?>
            <?php endif ?>
        </div>
        <div class="col-md-4 mb-3">
            <label for="hours">Enter hours</label>
            <input name='hours' class="form-control <?= $validation_state['hours'] ?? '' ?>" type='number' value='<?= $hours_value ?? '' ?>' required>
            <?php if (isset($errors)): ?>
                <?php if (isset($hours_error)) : ?>
                    <div class="invalid-feedback">
                        <?=$hours_error?>
                    </div>
                <?php else: ?>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                <?php endif; ?>
            <?php endif ?>
        </div>
        <div class="col-md-4 mb-3">
            <label for="minutes">Minutes (between 0 and 59)</label>
            <input name='minutes' class="form-control <?= $validation_state['minutes'] ?? '' ?>" type='number' value='<?= $minutes_value ?? '' ?>' required>
            <?php if (isset($errors)): ?>
                <?php if (isset($minutes_error)) : ?>
                    <div class="invalid-feedback">
                        <?=$minutes_error?>
                    </div>
                <?php else: ?>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                <?php endif; ?>
            <?php endif ?>
        </div>
        <div class="col-md-4 mb-3">
            <label for="unit">Select Unit</label>
            <select class="custom-select <?= $validation_state['unit'] ?? '' ?>"  name='unit'>
                <option value='mile' <?php if (isset($unit_value) && $unit_value == 'mile') : ?> selected <?php endif; ?>>Mile(s)</option>
                <option value='kilometer' <?php if (isset($unit_value) && $unit_value == 'kilometer') : ?> selected <?php endif; ?>>Kilometer(s)</option>
            </select>
            <?php if (isset($errors)): ?>
                <?php if (isset($unit_error)) : ?>
                    <div class="invalid-feedback">
                        <?=$unit_error?>
                    </div>
                <?php else: ?>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                <?php endif; ?>
            <?php endif ?>
        </div>
        <input type='submit' value='Calculate' class='btn btn-primary'>
    </form>
    <?php if (isset($results)): ?>
        <div class="alert alert-primary" role="alert">
            Your goal pace is: 
            <?= $results ?? '' ?>
        </div>
    <?php endif; ?>
</body>
</html>
