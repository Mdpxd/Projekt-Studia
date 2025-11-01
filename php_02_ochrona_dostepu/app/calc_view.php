<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 20px auto;
    padding: 0 20px;
    background-color: #f9f9f9;
}
h1 {
    color: #333;
    text-align: center;
}
.calculator-section {
    background-color: white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
h2 {
    color: #333;
    margin-top: 0;
    border-bottom: 2px solid #4CAF50;
    padding-bottom: 10px;
}
label {
    display: inline-block;
    width: 180px;
    margin-bottom: 10px;
    font-weight: bold;
}
input[type="text"], select {
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 220px;
}
input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 16px;
}
input[type="submit"]:hover {
    background-color: #45a049;
}
.error-box {
    margin: 20px 0;
    padding: 15px;
    border-radius: 5px;
    background-color: #ffebee;
    border-left: 4px solid #f44336;
    color: #c62828;
}
.error-box ol {
    margin: 0;
    padding-left: 20px;
}
.result-box {
    margin: 20px 0;
    padding: 20px;
    border-radius: 5px;
    background-color: #fff9c4;
    border-left: 4px solid #fbc02d;
    font-weight: bold;
    font-size: 18px;
}
.top-links { text-align: center; margin-bottom: 10px; }
.top-links a { margin: 0 6px; text-decoration:none; color:#4CAF50; }
.small-note { color:#666; font-size:0.9em; margin-top:6px; }
.role-badge { background:#e0f2f1; color:#00695c; padding:4px 8px; border-radius:12px; font-weight:bold; }
</style>
</head>
<body>
<h1>Kalkulatory aplikacji</h1>
<div class="top-links">
    <a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php">Inna chroniona strona</a> |
    <a href="<?php print(_APP_ROOT); ?>/app/security/logout.php">Wyloguj</a>
</div>

<!-- Informacja o roli -->
<div style="text-align:center; margin-bottom:12px;">
    <?php if(isset($role) && $role !== ''): ?>
        <span class="role-badge">Zalogowany jako: <?php echo htmlspecialchars($role); ?></span>
    <?php else: ?>
        <a href="<?php print(_APP_ROOT); ?>/app/security/login.php">Zaloguj</a>
    <?php endif; ?>
</div>

<!-- Kalkulator podstawowy -->
<div class="calculator-section">
    <h2>Kalkulator podstawowy</h2>
    <form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
        <input type="hidden" name="calc_type" value="basic" />
        <label for="id_x">Liczba 1: </label>
        <input id="id_x" type="text" name="x" value="<?php if(isset($x)) echo htmlspecialchars($x); ?>" /><br />

        <label for="id_op">Operacja: </label>
        <select id="id_op" name="op">
            <option value="plus" <?php if(isset($operation) && $operation == 'plus') echo 'selected'; ?>>+ (dodawanie)</option>
            <option value="minus" <?php if(isset($operation) && $operation == 'minus') echo 'selected'; ?>>- (odejmowanie)</option>
            <option value="times" <?php if(isset($operation) && $operation == 'times') echo 'selected'; ?>>* (mnożenie)</option>
            <option value="div" <?php if(isset($operation) && $operation == 'div') echo 'selected'; ?>>/ (dzielenie)</option>
        </select><br />

        <label for="id_y">Liczba 2: </label>
        <input id="id_y" type="text" name="y" value="<?php if(isset($y)) echo htmlspecialchars($y); ?>" /><br />

        <input type="submit" value="Oblicz" />
    </form>

    <?php
    if ($calc_type == 'basic' && isset($messages) && count($messages) > 0) {
        echo '<div class="error-box"><strong>Błędy:</strong><ol>';
        foreach ($messages as $msg) {
            echo '<li>'.htmlspecialchars($msg).'</li>';
        }
        echo '</ol></div>';
    }
    ?>

    <?php if ($calc_type == 'basic' && isset($result) ): ?>
    <div class="result-box">
        Wynik: <?php echo number_format($result, 2, ',', ' '); ?>
    </div>
    <?php endif; ?>
</div>

<!-- Kalkulator kredytowy -->
<div class="calculator-section">
    <h2>Kalkulator kredytowy</h2>
    <form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
        <input type="hidden" name="calc_type" value="credit" />

        <label for="id_amount">Kwota kredytu (PLN): </label>
        <input id="id_amount" type="text" name="amount" value="<?php if(isset($amount)) echo htmlspecialchars($amount); ?>" placeholder="np. 200000" /><br />

        <label for="id_years">Okres (lata): </label>
        <input id="id_years" type="text" name="years" value="<?php if(isset($years)) echo htmlspecialchars($years); ?>" placeholder="np. 20" /><br />

        <label for="id_interest">Oprocentowanie (%): </label>
        <input id="id_interest" type="text" name="interest" value="<?php if(isset($interest)) echo htmlspecialchars($interest); ?>" placeholder="np. 7.5" /><br />

        <input type="submit" value="Oblicz ratę" />
    </form>

    <?php
    if ($calc_type == 'credit' && isset($messages) && count($messages) > 0) {
        echo '<div class="error-box"><strong>Błędy:</strong><ol>';
        foreach ($messages as $msg) {
            echo '<li>'.htmlspecialchars($msg).'</li>';
        }
        echo '</ol></div>';
    }
    ?>

    <?php if ($calc_type == 'credit' && isset($monthly_payment)): ?>
    <div class="result-box">
        <strong>Miesięczna rata:</strong> <?php echo number_format($monthly_payment, 2, ',', ' '); ?> zł<br>
        <strong>Łączna spłata:</strong> <?php echo number_format($total_payment, 2, ',', ' '); ?> zł<br>
        <strong>Łączne odsetki:</strong> <?php echo number_format($total_interest, 2, ',', ' '); ?> zł
    </div>
    <?php endif; ?>
    <div class="small-note">Uwaga: jeśli kwota przekracza <?php echo LOAN_MAX_FOR_USER; ?> zł lub oprocentowanie jest mniejsze niż <?php echo MIN_RATE_ALLOWED; ?>% — obliczenie może wymagać roli manager/admin.</div>
</div>

</body>
</html>
