<?php
require 'Team.php';
require 'Member.php';

class Player extends Member {
    function __construct($un, $m, $n, $fn, $b, $p) {
        parent::__construct($un, $m, $n, $fn, $b, $p, false);

    }
}
