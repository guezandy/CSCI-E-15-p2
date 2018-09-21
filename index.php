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
        <fieldset>
            <label>
                Enter distance
                <input name='distance' type='number' value='<?= $distance ?? '' ?>' required>
            </label>
            <label>
                Enter desired completion time
                <input type='number' name='hours' placeholder='hour(s)' min='0' value='<?= $hours ?? '' ?>' required>
            </label>
            <label>
                Minutes (between 0 and 59)
                <input type='number' name='minutes' placeholder='minute(s)' min='0' max='59' value='<?= $minutes ?? '' ?>' required>
            </label>
            <label>
                <select name='unit' required>
                    <option value='miles' <?php if (isset($unit) && $unit == 'miles') : ?> selected <?php endif; ?>>Mile(s)</option>
                    <option value='kilometers' <?php if (isset($unit) && $unit == 'kilometers') : ?> selected <?php endif; ?>>Kilometer(s)</option>
                </select>
            </label>
        </fieldset>
        <input type='submit' value='Calculate' class='btn btn-primary'>
    </form>
    <div>
    Result
    </div>
</body>
</html>
