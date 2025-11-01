<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<title>Logowanie</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<style>
.container { width:320px; margin:60px auto; }
.error-box { background:#ffebee; border-left:4px solid #f44336; padding:10px; margin-top:10px; }
</style>
</head>
<body>
<div class="container">
<form action="<?php print(_APP_ROOT); ?>/app/security/login.php" method="post" class="pure-form pure-form-stacked">
    <legend>Logowanie</legend>
    <fieldset>
        <label for="id_login">login: </label>
        <input id="id_login" type="text" name="login" value="<?php if(isset($form['login'])) echo htmlspecialchars($form['login']); ?>" />
        <label for="id_pass">pass: </label>
        <input id="id_pass" type="password" name="pass" />
    </fieldset>
    <input type="submit" value="zaloguj" class="pure-button pure-button-primary"/>
</form>

<?php
if (isset($messages) && count($messages) > 0) {
    echo '<div class="error-box"><ol>';
    foreach ($messages as $m) echo '<li>'.htmlspecialchars($m).'</li>';
    echo '</ol></div>';
}
?>
</div>
</body>
</html>
