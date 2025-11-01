<?php
require_once dirname(__FILE__).'/../config.php';

// ochrona - redirect do logowania jesli brak sesji/roli
include _ROOT_PATH.'/app/security/check.php';

// ustawienia biznesowe
define('LOAN_MAX_FOR_USER', 100000);
define('MIN_RATE_ALLOWED', 2.5);

// przygotowanie zmiennych
$messages = array();
$calc_type = isset($_REQUEST['calc_type']) ? $_REQUEST['calc_type'] : 'basic';

// pola kalkulatora podstawowego
$x = $_POST['x'] ?? null;
$y = $_POST['y'] ?? null;
$operation = $_POST['op'] ?? null;

// pola kalkulatora kredytowego
$amount = $_POST['amount'] ?? null;
$years = $_POST['years'] ?? null;
$interest = $_POST['interest'] ?? null;

$result = null;
$monthly_payment = null;
$total_payment = null;
$total_interest = null;

// LOGIKA: kalkulator podstawowy
if ($calc_type === 'basic') {
    if (isset($_POST['x']) || isset($_POST['y']) || isset($_POST['op'])) {
        if ($x === "") $messages[] = 'Nie podano liczby 1';
        if ($y === "") $messages[] = 'Nie podano liczby 2';

        if (!is_numeric($x)) $messages[] = 'Liczba 1 nie jest liczbą';
        if (!is_numeric($y)) $messages[] = 'Liczba 2 nie jest liczbą';

        if (empty($messages)) {
            $x = floatval($x);
            $y = floatval($y);

            switch ($operation) {
                case 'minus':
                    // odejmowanie tylko dla admin
                    if ($role === 'admin') $result = $x - $y;
                    else $messages[] = 'Tylko administrator może odejmować !';
                    break;
                case 'times':
                    $result = $x * $y;
                    break;
                case 'div':
                    if ($y == 0) $messages[] = 'Dzielenie przez zero niedozwolone';
                    else {
                        if ($role === 'admin') $result = $x / $y;
                        else $messages[] = 'Tylko administrator może dzielić !';
                    }
                    break;
                default:
                    $result = $x + $y;
                    break;
            }
        }
    }
}

// LOGIKA: kalkulator kredytowy (z podziałem na role)
if ($calc_type === 'credit') {
    if (isset($_POST['amount']) || isset($_POST['years']) || isset($_POST['interest'])) {
        if ($amount === "") $messages[] = 'Nie podano kwoty kredytu';
        if ($years === "") $messages[] = 'Nie podano okresu (lat)';
        if ($interest === "") $messages[] = 'Nie podano oprocentowania';

        if (!is_numeric($amount) || floatval($amount) <= 0) $messages[] = 'Kwota musi być liczbą dodatnią';
        if (!is_numeric($years) || intval($years) <= 0) $messages[] = 'Okres (lata) musi być liczbą całkowitą większą od zera';
        if (!is_numeric($interest) || floatval($interest) < 0) $messages[] = 'Oprocentowanie musi być liczbą nieujemną';

        if (empty($messages)) {
            $amount = floatval($amount);
            $years = intval($years);
            $interest = floatval($interest);

            // ograniczenia dostępu: duze kwoty / niskie oprocentowanie tylko manager/admin
            if ($amount > LOAN_MAX_FOR_USER && !in_array($role, array('manager','admin'))) {
                $messages[] = 'Kwota przekracza maksimum dostępne dla Twojej roli - obliczenie może wykonać tylko manager lub admin.';
            }
            if ($interest < MIN_RATE_ALLOWED && !in_array($role, array('manager','admin'))) {
                $messages[] = 'Żądane oprocentowanie jest niższe niż minimalne - tylko manager lub admin może wykonać takie obliczenie.';
            }

            if (empty($messages)) {
                $n = $years * 12;
                $i = $interest / 100 / 12;
                if ($i == 0) {
                    $monthly_payment = $amount / $n;
                } else {
                    $monthly_payment = ($amount * $i) / (1 - pow(1 + $i, -$n));
                }
                $total_payment = $monthly_payment * $n;
                $total_interest = $total_payment - $amount;

                $monthly_payment = round($monthly_payment, 2);
                $total_payment = round($total_payment, 2);
                $total_interest = round($total_interest, 2);
            }
        }
    }
}

// wywolanie widoku
include __DIR__.'/calc_view.php';
?>
