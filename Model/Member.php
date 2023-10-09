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

    function becomePlayer($bdd) {
        $request = $bdd->prepare("update Guests 
                                        set isPlayer = true
                                        where username = :username;");
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        return new player($this->username, $this->mail, $this->name, $this->firstname, $this->birthday,$this->password);
    }

    public function setIsRegistering() {
        $this->isRegistering = !$this->isRegistering;
    }

    public function unregisterMember($bdd){
        $request = $bdd->prepare("delete from Guests
                                  where username = :username;");
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        return true;
    }
}
