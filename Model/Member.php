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

    public function becomePlayer($bdd)
    {
        $request = $bdd->prepare("update Guests 
                                        set isPlayer = true
                                        where username = :username;");/*passe le membre en joueur en modifiant une colone de notre base de donné*/
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->execute();
        if ($this instanceof Administrator) {
            return new PlayerAdministrator($this->username, $this->mail, $this->name, $this->firstname, $this->birthday, $this->password);
        }
        else{
            return new player($this->username, $this->mail, $this->name, $this->firstname, $this->birthday, $this->password);
        }
    }

    public function setIsRegistering() {
        $this->isRegistering = !$this->isRegistering;
    }//crée un membre ...

    public function unregisterMember($bdd){
        if($this instanceof Administrator) {
            $request = $bdd->prepare("select count(*) from Guests where isAdmin = true;");
            //vérifie le nombre de membre de la BDD.
            $request->execute();
            $request = $request->fetchall();
            if ($request[0][0]<=1) {
                return false;
            }
        }
        $request = $bdd->prepare("delete from Guests
                                  where username = :username;");//supprime le membre de la base de donné.
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        return true;//renvoie true pour voir si la comande ci-dessus fonctionne correctement
    }
}
