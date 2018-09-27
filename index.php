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

    <link href='styles/styles.css' rel='stylesheet'>
</head>
<body>
<div class="flex-container">
    <div class="jumbotron">
        <h1 class="display-4">Running pace calculator</h1>
        <p>To calculate running pace enter distance you want to run and the goal time.</p>
        <hr>
        <form method='GET'
              action='includes/calculate.php'>
            <div class="mb-3 row">
                <div class="col-sm-8">
                    <label for="distance">Enter distance</label>
                    <input name='distance'
                           class="form-control <?= $validation_state['distance'] ?? '' ?>"
                           type='number'
                           value='<?= $distance_value ?? '' ?>'
                           required>
                    <?php if (isset($errors)): ?>
                        <?php if (isset($errors['distance'])) : ?>
                            <div class="invalid-feedback">
                                <?= $errors['distance'] ?>
                            </div>
                        <?php else: ?>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        <?php endif; ?>
                    <?php endif ?>
                </div>
                <div class="col-sm-3 col-sm-offset-1 unit-radio">
                    <?php foreach (['mile', 'kilometer'] as $unit): ?>
                        <div class="custom-control custom-radio">
                            <input type="radio"
                                   class="custom-control-input <?= $validation_state['unit'] ?? '' ?>"
                                   id="<?= $unit ?>"
                                   name="unit"
                                   value="<?= $unit ?>"
                                   required <?php if (isset($unit_value) && $unit_value == $unit) : ?> checked <?php endif; ?>>
                            <label class="custom-control-label"
                                   for="<?= $unit ?>"><?php if ($unit == 'mile'): ?> Mile(s) <?php else: ?> Kilometer(s) <?php endif; ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-6">
                    <label for="hours">Hours</label>
                    <input name='hours'
                           class="form-control <?= $validation_state['hours'] ?? '' ?>"
                           type='number'
                           value='<?= $hours_value ?? '0' ?>'
                           required>
                    <?php if (isset($errors)): ?>
                        <?php if (isset($errors['hours'])) : ?>
                            <div class="invalid-feedback">
                                <?= $errors['hours'] ?>
                            </div>
                        <?php else: ?>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        <?php endif; ?>
                    <?php endif ?>
                </div>
                <div class="col-sm-6">
                    <label for="minutes">Minutes</label>
                    <select class="custom-select <?= $validation_state['minutes'] ?? '' ?>" name='minutes' required>
                        <?php for ($i = 0; $i < 60; $i++): ?>
                            <option value='<?= $i ?>' <?php if (isset($minutes_value) && $minutes_value == $i) : ?> selected <?php endif; ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <?php if (isset($errors)): ?>
                        <?php if (isset($errors['minutes'])) : ?>
                            <div class="invalid-feedback">
                                <?= $errors['minutes'] ?>
                            </div>
                        <?php else: ?>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        <?php endif; ?>
                    <?php endif ?>
                </div>
            </div>
            <input type='submit' value='Calculate' class='btn btn-primary mb-3'>
        </form>
        <?php if (isset($results)): ?>
            <div class="result">
                <div class="alert alert-primary" role="alert">
                    Your goal pace is:
                    <?= $results ?? '' ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
