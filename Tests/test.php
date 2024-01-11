<?php
require_once('../Model/Player.php');

$bdd= new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$c = new Player('capitaine','mail@gmail.com','Christ','Jesus','2004-03-16','bonjour', null);
$c->saveGuy($bdd);
$p1 = new Player('joueur 1','mail1@gmail.com','Liones','elizabeth','2004-03-16','bonjour', null);
$p1->saveGuy($bdd);
$p2 = new Player('joueur 2','mail2@gmail.com','Meriaux','Thomas','2004-03-16','bonjour', null);
$p2->saveGuy($bdd);
$c->createTeam('les Divins','joueur 1',$bdd);
echo $c->scearchName("les Divins",$bdd);

$c=launch();
$c->addPlayer($p2);
$c->deleteTeam();
echo $c->scearchName("les Divins",$bdd);
