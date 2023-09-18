<?php

class Guy {
    public $username;
    private $mail;
    private $name;
    private $firstname;
    private $birthday;
    private $password;
    private $isRegistering;

    function __construct($un, $m, $n, $fn, $b, $p, $ir) {
        $this->username = $un;
        $this->mail = $m;
        $this->name = $n;
        $this->firstname = $fn;
        $this->birthday = $b;
        $this->password = $p;
        $this->isRegistering = $ir;
    }
}