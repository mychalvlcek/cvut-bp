<h3>Testovací výpis z databáze, test PDO</h3>
<ul>
<? foreach( $names as $name ) { ?>
	<li><?="$name[id]. $name[username]"?></li>
<? } ?>
</ul>