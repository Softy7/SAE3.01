<?php

class Member {
    public $username;
    private $mail;
    private $name;
    private $firstname;
    private $birthday;
    private $password;

    function __construct($un/*username*/, $m/*mail*/, $n/*nom*/, $fn/*prénom*/, $b/*date de naissance*/, $p/*mots de passe*/)
    {
        $this->username = $un;
        $this->mail = $m;
        $this->name = $n;
        $this->firstname = $fn;
        $this->birthday = $b;
        $this->password = $p;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function getFirstname()
    {
        return $this->firstname;
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
            return new PlayerAdministrator($this->username, $this->mail, $this->name, $this->firstname, $this->birthday, $this->password, null);
        }
        else{
            return new player($this->username, $this->mail, $this->name, $this->firstname, $this->birthday, $this->password, null);
        }
    }
    public function unregisterMember($bdd) {
        if($this instanceof Administrator) {
            $request = $bdd->prepare("select count(*) from Guests where isAdmin = true and isDeleted = false;");
            //vérifie le nombre de membre de la BDD.
            $request->execute();
            $request = $request->fetchall();
            if ($request[0][0]<=1) {
                return false;
            }
        }
        $request = $bdd->prepare("Update Guests set isDeleted = true and isregistered = false
                                  where username = :username;");//supprime le membre de la base de donné.
        $request->bindValue(':username',$this->username,PDO::PARAM_STR);
        $request->execute();
        return true;//renvoie true pour voir si la comande ci-dessus fonctionne correctement
    }

    public function saveGuy($bdd) {
        $req = $bdd->prepare('insert into Guests values(:username, :mail, :name, :firstname, :birthday, :password, true, false, true, false, null)');
        $req->bindValue(':username',$this->username,PDO::PARAM_STR);
        $req->bindValue(':mail',$this->mail,PDO::PARAM_STR);
        $req->bindValue(':name',$this->name,PDO::PARAM_STR);
        $req->bindValue(':firstname',$this->firstname,PDO::PARAM_STR);
        $req->bindValue(':birthday',$this->birthday,PDO::PARAM_STR);
        $req->bindValue(':password',$this->password,PDO::PARAM_STR);
        $req->execute();
        /**/
    }

    function viewMatch($bdd){
        $requete=$bdd->prepare("SELECT * FROM Match ORDER BY idmatch");
        $requete->execute();
        $resultats=$requete->fetchAll();
        return $resultats;
    }

}
