<h2>Testovací načtení z URL</h2>

<form action="" method="post">
	<input class="input-xxlarge" type="text" name="url" placeholder="http://www.example.com/" />
	<span class="help-block">Vložte URL adresu</span>
	<button class="btn" type="submit">Potvrdit</button>
</form>
<h3>Výpis odkazů:</h3>
<code><?=$anchors?></code>
<h3>Výpis souboru:</h3>
<code><?=$file?></code>