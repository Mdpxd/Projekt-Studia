<?php
/* Smarty version 5.4.2, created on 2025-11-14 20:04:28
  from 'file:calc_view.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.2',
  'unifunc' => 'content_69177d3c33d978_42072615',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '40eb1f80d80fb02c1b83421b6a48e65f7f841d03' => 
    array (
      0 => 'calc_view.tpl',
      1 => 1763145778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69177d3c33d978_42072615 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\php_02_ochrona_dostepu\\app\\templates';
?><!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
<style>
body { font-family: Arial, sans-serif; max-width: 900px; margin: 20px auto; padding: 0 20px; background-color: #f9f9f9; }
h1 { text-align:center; }
.calculator-section { background-color:white; padding:20px; margin-bottom:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1);}
.error-box { background-color:#ffebee; border-left:4px solid #f44336; padding:10px; margin:10px 0; }
.result-box { background-color:#fff9c4; border-left:4px solid #fbc02d; padding:10px; margin:10px 0; font-weight:bold; }
label { display:inline-block; width:180px; }
input[type="text"], select { padding:5px; margin-bottom:10px; width:220px; }
input[type="submit"] { padding:10px 20px; }
</style>
</head>
<body>

<h1>Kalkulatory aplikacji</h1>

<!-- Kalkulator podstawowy -->
<div class="calculator-section">
<h2>Kalkulator podstawowy</h2>
<form action="calc.php" method="post">
<input type="hidden" name="calc_type" value="basic" />
<label>Liczba 1:</label><input type="text" name="x" value="<?php echo (($tmp = $_smarty_tpl->getValue('x') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" /><br/>
<label>Operacja:</label>
<select name="op">
<option value="plus" <?php if ($_smarty_tpl->getValue('operation') == 'plus') {?>selected<?php }?>>+</option>
<option value="minus" <?php if ($_smarty_tpl->getValue('operation') == 'minus') {?>selected<?php }?>>-</option>
<option value="times" <?php if ($_smarty_tpl->getValue('operation') == 'times') {?>selected<?php }?>>*</option>
<option value="div" <?php if ($_smarty_tpl->getValue('operation') == 'div') {?>selected<?php }?>>/</option>
</select><br/>
<label>Liczba 2:</label><input type="text" name="y" value="<?php echo (($tmp = $_smarty_tpl->getValue('y') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" /><br/>
<input type="submit" value="Oblicz" />
</form>

<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('messages')) > 0) {?>
<div class="error-box">
<ul>
<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('messages'), 'msg');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('msg')->value) {
$foreach0DoElse = false;
?>
<li><?php echo $_smarty_tpl->getValue('msg');?>
</li>
<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
</ul>
</div>
<?php }?>

<?php if ((null !== ($_smarty_tpl->getValue('result') ?? null))) {?>
<div class="result-box">Wynik: <?php echo $_smarty_tpl->getValue('result');?>
</div>
<?php }?>
</div>

<!-- Kalkulator kredytowy -->
<div class="calculator-section">
<h2>Kalkulator kredytowy</h2>
<form action="calc.php" method="post">
<input type="hidden" name="calc_type" value="credit" />
<label>Kwota:</label><input type="text" name="amount" value="<?php echo (($tmp = $_smarty_tpl->getValue('amount') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" /><br/>
<label>Okres (lata):</label><input type="text" name="years" value="<?php echo (($tmp = $_smarty_tpl->getValue('years') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" /><br/>
<label>Oprocentowanie (%):</label><input type="text" name="interest" value="<?php echo (($tmp = $_smarty_tpl->getValue('interest') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" /><br/>
<input type="submit" value="Oblicz ratę" />
</form>

<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('messages')) > 0) {?>
<div class="error-box">
<ul>
<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('messages'), 'msg');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('msg')->value) {
$foreach1DoElse = false;
?>
<li><?php echo $_smarty_tpl->getValue('msg');?>
</li>
<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
</ul>
</div>
<?php }?>

<?php if ((null !== ($_smarty_tpl->getValue('monthly_payment') ?? null))) {?>
<div class="result-box">
Miesięczna rata: <?php echo $_smarty_tpl->getValue('monthly_payment');?>
 zł<br/>
Łączna spłata: <?php echo $_smarty_tpl->getValue('total_payment');?>
 zł<br/>
Łączne odsetki: <?php echo $_smarty_tpl->getValue('total_interest');?>
 zł
</div>
<?php }?>
</div>

</body>
</html><?php }
}
