<?php
include_once('Member.php');
class Player extends Member {
    protected $team;

    /**
     * @param $un "le pseudo du joueur
     * @param $m "le mail du joueur
     * @param $n "le nom du joueur
     * @param $fn "le prénom du joueur
     * @param $b "la date de naissance du joueur écrit sous la forme jj/mm/aaaa
     * @param $p "le mot de passe du joueur
     * @param $t "l'équipe du joueur
     */

    function __construct($un, $m, $n, $fn, $b, $p, $t) {
        parent::__construct($un, $m, $n, $fn, $b, $p);
        $this->team = $t;
    }
}
