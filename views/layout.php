<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?=$title?></title>
</head>
<body>
	<h1><?=$title?></h1>
	<ul>
		<li><a href="/">Domů</a></li>
		<li><a href="/projects">Projekty</a></li>
		<li><a href="/import">Načtení DB schématu</a></li>
		<li><a href="/import/url">Načtení z URL</a></li>
		<li><a href="/scripts">Správa testovacích skriptů</a></li>
		<li><a href="/logs">Logy</a></li>
	</ul>
	<hr />
	<div id="content">
		<?= $template_body; ?>
	</div>
</body>
</html>