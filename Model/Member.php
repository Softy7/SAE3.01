<?php

class Member {
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

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getIsRegistering()
    {
        return $this->isRegistering;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    function wantBecomePlayer() {
        $this->isRegistering = true;
        /*mail($this->mail, "Inscription", "Bonjour,`\n Vous avez soumis votre inscription
        pour le tournoi de Chôlage. Nos administrateurs vont vérifier vos informations et valider ou réfuter votre 
        inscription, le cas échéant, vous recevrez un mail de confirmation. Nous vous remercions de votre inscription et 
        espérons vous recevoir très vite pour l'événement. \n\n Cordialement,\nL'équipe du tournoi !!!");*/
    }

    public function setIsRegistering() {
        $this->isRegistering = !$this->isRegistering;
    }
}
