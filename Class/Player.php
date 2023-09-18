<?php
require 'Team.php';
require 'Guy.php';
class Player extends Guy {
    function __construct($un, $m, $n, $fn, $b, $p) {
        parent::__construct($un, $m, $n, $fn, $b, $p, false);
    }
}