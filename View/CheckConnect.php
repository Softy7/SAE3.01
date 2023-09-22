<?php
$user =$_GET['id'];
$password =$_GET['MDP'];

$bdd = new PDO ("pgsql:host=iutinfo-sgbd;dbname=iutinfo263",'iutinfo263','5mTvGJJk');

$request = $bdd->prepare("SELECT * FROM guests WHERE username = '$user' AND password = '$password' AND isPlayerRegistering = false");
$request->execute();
$result = $request->fetchAll();
foreach ($result as $row) {
    echo $row['username']; // Accède à la colonne 'username'
    echo $row['password'];    // Accède à la colonne 'password'
}