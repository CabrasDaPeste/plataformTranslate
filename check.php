<?php
require_once 'init.php';
 
if (!usuarioLogado())
{
    header('Location: login.php');
}