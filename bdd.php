<?php

$connexion = new PDO(
    'mysql:host=localhost:3306;dbname=phppdo;charset=UTF8',
    'root',
    ''
);

$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

