<?php
class PlayerAdministrator extends Administrator {
    function __construct($un, $m, $n, $fn, $b, $p) {
        parent::__construct($un, $m, $n, $fn, $b, $p, false);
    }
}