<?php
session_start();
// Remove o todas as sessions
$_SESSION = [];

// Redireciona para a página de login
header("Location: index.php");
die();
