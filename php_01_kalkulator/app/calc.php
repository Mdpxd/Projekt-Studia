<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.


// Inicjalizacja tablicy komunikatow
$messages = array();

// Sprawdzenie typu kalkulatora
$calc_type = isset($_REQUEST['calc_type']) ? $_REQUEST['calc_type'] : 'basic';

if ($calc_type == 'credit') {
    // ===== KALKULATOR KREDYTOWY =====

    // 1. Pobranie parametrow
    $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount'] : '';
    $years = isset($_REQUEST['years']) ? $_REQUEST['years'] : '';
    $interest = isset($_REQUEST['interest']) ? $_REQUEST['interest'] : '';

    // 2. Walidacja parametrow
    if (!isset($_REQUEST['amount']) || !isset($_REQUEST['years']) || !isset($_REQUEST['interest'])) {
        $messages[] = 'Bledne wywolanie aplikacji. Brak jednego z parametrow.';
    }

    if ($amount == "") {
        $messages[] = 'Nie podano kwoty kredytu';
    }
    if ($years == "") {
        $messages[] = 'Nie podano okresu kredytowania';
    }
    if ($interest == "") {
        $messages[] = 'Nie podano oprocentowania';
    }

    // Walidacja wartosci liczbowych
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

        // Dodatkowa walidacja wartosci
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

    // 3. Wykonanie obliczen
    if (empty($messages)) {
        $amount = floatval($amount);
        $years = floatval($years);
        $interest = floatval($interest);

        // Obliczenie miesiecznej raty (wzor na rate annuitetowa)
        $months = $years * 12;
        $monthly_interest = $interest / 100 / 12;

        if ($interest == 0) {
            // Jesli oprocentowanie wynosi 0
            $monthly_payment = $amount / $months;
        } else {
            // Wzor na rate annuitetowa: R = K * (r * (1 + r)^n) / ((1 + r)^n - 1)
            $monthly_payment = $amount * ($monthly_interest * pow(1 + $monthly_interest, $months)) / (pow(1 + $monthly_interest, $months) - 1);
        }

        $total_payment = $monthly_payment * $months;
        $total_interest = $total_payment - $amount;
    }

} else {
    // ===== KALKULATOR PODSTAWOWY =====

    // 1. Pobranie parametrow
    $x = isset($_REQUEST['x']) ? $_REQUEST['x'] : '';
    $y = isset($_REQUEST['y']) ? $_REQUEST['y'] : '';
    $operation = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

    // 2. Walidacja parametrow
    if (!isset($_REQUEST['x']) || !isset($_REQUEST['y']) || !isset($_REQUEST['op'])) {
        $messages[] = 'Bledne wywolanie aplikacji. Brak jednego z parametrow.';
    }

    if ($x == "") {
        $messages[] = 'Nie podano liczby 1';
    }
    if ($y == "") {
        $messages[] = 'Nie podano liczby 2';
    }

    // Nie ma sensu walidowac dalej gdy brak parametrow
    if (empty($messages)) {
        // Sprawdzenie, czy $x i $y sa liczbami
        if (!is_numeric($x)) {
            $messages[] = 'Pierwsza wartosc nie jest liczba';
        }

        if (!is_numeric($y)) {
            $messages[] = 'Druga wartosc nie jest liczba';
        }
    }

    // 3. Wykonanie zadania jesli wszystko w porzadku
    if (empty($messages)) {
        // Konwersja parametrow na float
        $x = floatval($x);
        $y = floatval($y);

        // Wykonanie operacji
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

// 4. Wywolanie widoku z przekazaniem zmiennych
include 'calc_view.php';
?>
