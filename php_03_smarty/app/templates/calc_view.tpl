<!DOCTYPE HTML>
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
<label>Liczba 1:</label><input type="text" name="x" value="{$x|default:''}" /><br/>
<label>Operacja:</label>
<select name="op">
<option value="plus" {if $operation=='plus'}selected{/if}>+</option>
<option value="minus" {if $operation=='minus'}selected{/if}>-</option>
<option value="times" {if $operation=='times'}selected{/if}>*</option>
<option value="div" {if $operation=='div'}selected{/if}>/</option>
</select><br/>
<label>Liczba 2:</label><input type="text" name="y" value="{$y|default:''}" /><br/>
<input type="submit" value="Oblicz" />
</form>

{if $messages|@count > 0}
<div class="error-box">
<ul>
{foreach from=$messages item=msg}
<li>{$msg}</li>
{/foreach}
</ul>
</div>
{/if}

{if isset($result)}
<div class="result-box">Wynik: {$result}</div>
{/if}
</div>

<!-- Kalkulator kredytowy -->
<div class="calculator-section">
<h2>Kalkulator kredytowy</h2>
<form action="calc.php" method="post">
<input type="hidden" name="calc_type" value="credit" />
<label>Kwota:</label><input type="text" name="amount" value="{$amount|default:''}" /><br/>
<label>Okres (lata):</label><input type="text" name="years" value="{$years|default:''}" /><br/>
<label>Oprocentowanie (%):</label><input type="text" name="interest" value="{$interest|default:''}" /><br/>
<input type="submit" value="Oblicz ratę" />
</form>

{if $messages|@count > 0}
<div class="error-box">
<ul>
{foreach from=$messages item=msg}
<li>{$msg}</li>
{/foreach}
</ul>
</div>
{/if}

{if isset($monthly_payment)}
<div class="result-box">
Miesięczna rata: {$monthly_payment} zł<br/>
Łączna spłata: {$total_payment} zł<br/>
Łączne odsetki: {$total_interest} zł
</div>
{/if}
</div>

</body>
</html>