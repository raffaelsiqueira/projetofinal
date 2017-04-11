<?php

	$textoJSON = $_GET['texto'];

	$fp = fopen("mapa.json", "a");

	$escreve = fwrite($fp, $textoJSON);

	fclose($fp);

?>