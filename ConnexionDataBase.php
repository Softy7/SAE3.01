<?php

function __init__() {
    return $bdd=new PDO('pgsql:host=iutinfo-sgbd;dbname=iutinfo241',$username='iutinfo241',$password='IYxtdHP8');
}

/* Permettra à tout le monde de travailler de leur côté avec différentes bases de données.*/