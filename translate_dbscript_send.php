<?php
session_start();
 
require 'check.php';

$entry = $_POST["entry"];
$frase = $_POST["frase"];

// Se o usuário não digitou 
if (empty($frase)) {
	echo '<script>alert("Você não pode enviar uma tradução em branco."); javascript:history.back();</script>';
	exit;
}
	
/*
if (checkTranslation()) {
	echo '<script>alert("Você precisa digitar um texto diferente do inglês."); javascript:history.back();</script>';
	exit;
} else {
	*/
	
	if (!sendTranslationCabrasDaPeste()) {
		echo '<script>alert("Houve um erro ao enviar a tradução. Entre em contato com o Lampião. COD: 00001"); javascript:history.back();</script>';
		exit;
	}
	
	if (!sendTranslationCabrasDaPesteText()) {
		echo '<script>alert("Houve um erro ao enviar a tradução. Entre em contato com o Lampião. COD: 00002"); javascript:history.back();</script>';
		exit;
	}
	
	echo '<script>alert("Tradução enviada com sucesso!");window.location.href="translate_dbscript.php";</script>';
	exit;

// }
	
	
	
	
?>