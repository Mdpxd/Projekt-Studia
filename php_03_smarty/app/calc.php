<?php
spl_autoload_register(function ($class) {
    $prefix = 'Smarty\\';
    $base_dir = __DIR__ . '/../libs/smarty/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Smarty\Smarty; 


$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/templates');
$smarty->setCompileDir(__DIR__ . '/templates_c');

$smarty->assign('wynik', 123);
$smarty->assign('wynik', $wynik);
// zmienne
$messages = array();
$calc_type = $_POST['calc_type'] ?? 'basic';
$x = $_POST['x'] ?? null;
$y = $_POST['y'] ?? null;
$operation = $_POST['op'] ?? null;
$amount = $_POST['amount'] ?? null;
$years = $_POST['years'] ?? null;
$interest = $_POST['interest'] ?? null;
$result = null;
$monthly_payment = null;
$total_payment = null;
$total_interest = null;

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if ($calc_type==='basic') {
        if ($x==="" || $y==="" || !is_numeric($x) || !is_numeric($y)) {
            $messages[]='Wprowadź poprawne liczby';
        } else {
            $x=floatval($x); $y=floatval($y);
            switch($operation){
                case 'minus': $result=$x-$y; break;
                case 'times': $result=$x*$y; break;
                case 'div': $result=($y!=0)?$x/$y:'Błąd: dzielenie przez 0'; break;
                default: $result=$x+$y; break;
            }
        }
    }
    if ($calc_type==='credit') {
        if (!is_numeric($amount)||!is_numeric($years)||!is_numeric($interest)||$amount<=0||$years<=0||$interest<0) {
            $messages[]='Wprowadź poprawne dane kredytowe';
        } else {
            $amount=floatval($amount);
            $years=intval($years);
            $interest=floatval($interest);
            $n=$years*12; $i=$interest/100/12;
            $monthly_payment=$i==0?$amount/$n:($amount*$i)/(1-pow(1+$i,-$n));
            $total_payment=$monthly_payment*$n;
            $total_interest=$total_payment-$amount;
            $monthly_payment=round($monthly_payment,2);
            $total_payment=round($total_payment,2);
            $total_interest=round($total_interest,2);
        }
    }
}

$smarty->assign(compact('x','y','operation','result','messages','amount','years','interest','monthly_payment','total_payment','total_interest'));
$smarty->display('calc_view.tpl');
