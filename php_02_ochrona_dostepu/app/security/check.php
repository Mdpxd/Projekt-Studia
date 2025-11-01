<?php
require_once dirname(__FILE__).'/../../config.php';
session_start();

// pobranie roli
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// jeśli brak roli to przekieruj do formularza logowania
if ( empty($role) ){
    header('Location: '._APP_URL.'/app/security/login.php');
    exit();
}
// jeśli ok to kontynuuj; zmienna $role dostępna w skryptach po include
?>
