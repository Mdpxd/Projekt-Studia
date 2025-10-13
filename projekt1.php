<?php
// KONTROLER - Logika kalkulatora
$messages = array();
$calc_type = isset($_POST['calc_type']) ? $_POST['calc_type'] : 'basic';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($calc_type == 'credit') {
        // KALKULATOR KREDYTOWY
        $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
        $years = isset($_POST['years']) ? $_POST['years'] : '';
        $interest = isset($_POST['interest']) ? $_POST['interest'] : '';

        if ($amount == "") {
            $messages[] = 'Nie podano kwoty kredytu';
        }
        if ($years == "") {
            $messages[] = 'Nie podano okresu kredytowania';
        }
        if ($interest == "") {
            $messages[] = 'Nie podano oprocentowania';
        }

        if (empty($messages)) {
            if (!is_numeric($amount)) {
                $messages[] = 'Kwota kredytu nie jest liczba';
            }
            if (!is_numeric($years)) {
                $messages[] = 'Okres kredytowania nie jest liczba';
            }
            if (!is_numeric($interest)) {
                $messages[] = 'Oprocentowanie nie jest liczba';
            }

            if (is_numeric($amount) && $amount <= 0) {
                $messages[] = 'Kwota kredytu musi byc wieksza od 0';
            }
            if (is_numeric($years) && $years <= 0) {
                $messages[] = 'Okres kredytowania musi byc wiekszy od 0';
            }
            if (is_numeric($interest) && $interest < 0) {
                $messages[] = 'Oprocentowanie nie moze byc ujemne';
            }
        }

        if (empty($messages)) {
            $amount = floatval($amount);
            $years = floatval($years);
            $interest = floatval($interest);

            $months = $years * 12;
            $monthly_interest = $interest / 100 / 12;

            if ($interest == 0) {
                $monthly_payment = $amount / $months;
            } else {
                $monthly_payment = $amount * ($monthly_interest * pow(1 + $monthly_interest, $months)) / (pow(1 + $monthly_interest, $months) - 1);
            }

            $total_payment = $monthly_payment * $months;
            $total_interest = $total_payment - $amount;
        }

    } else {
        // KALKULATOR PODSTAWOWY
        $x = isset($_POST['x']) ? $_POST['x'] : '';
        $y = isset($_POST['y']) ? $_POST['y'] : '';
        $operation = isset($_POST['op']) ? $_POST['op'] : '';

        if ($x == "") {
            $messages[] = 'Nie podano liczby 1';
        }
        if ($y == "") {
            $messages[] = 'Nie podano liczby 2';
        }

        if (empty($messages)) {
            if (!is_numeric($x)) {
                $messages[] = 'Pierwsza wartosc nie jest liczba';
            }
            if (!is_numeric($y)) {
                $messages[] = 'Druga wartosc nie jest liczba';
            }
        }

        if (empty($messages)) {
            $x = floatval($x);
            $y = floatval($y);

            switch ($operation) {
                case 'minus':
                    $result = $x - $y;
                    break;
                case 'times':
                    $result = $x * $y;
                    break;
                case 'div':
                    if ($y == 0) {
                        $messages[] = 'Nie mozna dzielic przez zero';
                    } else {
                        $result = $x / $y;
                    }
                    break;
                default:
                    $result = $x + $y;
                    break;
            }
        }
    }
}
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
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
    width: 200px;
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
</style>
</head>
<body>
<h1>Kalkulatory</h1>

<!-- Kalkulator podstawowy -->
<div class="calculator-section">
    <h2>Kalkulator podstawowy</h2>
    <form method="post">
        <label for="id_x">Liczba 1: </label>
        <input id="id_x" type="text" name="x" value="<?php if(isset($x)) echo htmlspecialchars($x); ?>" /><br />

        <label for="id_op">Operacja: </label>
        <select id="id_op" name="op">
            <option value="plus" <?php if(isset($operation) && $operation == 'plus') echo 'selected'; ?>>+ (dodawanie)</option>
            <option value="minus" <?php if(isset($operation) && $operation == 'minus') echo 'selected'; ?>>- (odejmowanie)</option>
            <option value="times" <?php if(isset($operation) && $operation == 'times') echo 'selected'; ?>>* (mnozenie)</option>
            <option value="div" <?php if(isset($operation) && $operation == 'div') echo 'selected'; ?>>/ (dzielenie)</option>
        </select><br />

        <label for="id_y">Liczba 2: </label>
        <input id="id_y" type="text" name="y" value="<?php if(isset($y)) echo htmlspecialchars($y); ?>" /><br />

        <input type="submit" value="Oblicz" />
    </form>

    <?php
    // Wyswietlenie bledow dla kalkulatora podstawowego
    if ($calc_type == 'basic' && isset($messages) && count($messages) > 0) {
        echo '<div class="error-box"><strong>Bledy:</strong><ol>';
        foreach ($messages as $msg) {
            echo '<li>'.htmlspecialchars($msg).'</li>';
        }
        echo '</ol></div>';
    }
    ?>

    <?php if ($calc_type == 'basic' && isset($result)){ ?>
    <div class="result-box">
        Wynik: <?php echo number_format($result, 2, ',', ' '); ?>
    </div>
    <?php } ?>
</div>

<!-- Kalkulator kredytowy -->
<div class="calculator-section">
    <h2>Kalkulator kredytowy</h2>
    <form method="post">
        <input type="hidden" name="calc_type" value="credit" />

        <label for="id_amount">Kwota kredytu (zl): </label>
        <input id="id_amount" type="text" name="amount" value="<?php if(isset($amount)) echo htmlspecialchars($amount); ?>" placeholder="np. 200000" /><br />

        <label for="id_years">Okres (lat): </label>
        <input id="id_years" type="text" name="years" value="<?php if(isset($years)) echo htmlspecialchars($years); ?>" placeholder="np. 20" /><br />

        <label for="id_interest">Oprocentowanie (%): </label>
        <input id="id_interest" type="text" name="interest" value="<?php if(isset($interest)) echo htmlspecialchars($interest); ?>" placeholder="np. 7.5" /><br />

        <input type="submit" value="Oblicz rate" />
    </form>

    <?php
    // Wyswietlenie bledow dla kalkulatora kredytowego
    if ($calc_type == 'credit' && isset($messages) && count($messages) > 0) {
        echo '<div class="error-box"><strong>Bledy:</strong><ol>';
        foreach ($messages as $msg) {
            echo '<li>'.htmlspecialchars($msg).'</li>';
        }
        echo '</ol></div>';
    }
    ?>

    <?php if (isset($monthly_payment)){ ?>
    <div class="result-box">
        <strong>Miesieczna rata:</strong> <?php echo number_format($monthly_payment, 2, ',', ' '); ?> zl<br>
        <strong>Laczna kwota do splaty:</strong> <?php echo number_format($total_payment, 2, ',', ' '); ?> zl<br>
        <strong>Laczne odsetki:</strong> <?php echo number_format($total_interest, 2, ',', ' '); ?> zl
    </div>
    <?php } ?>
</div>

</body>
</html>
