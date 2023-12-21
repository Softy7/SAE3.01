<?php
include_once('Player.php');

/**
 *
 */
class Capitain extends Player {

    /**
     * @param $un "le pseudo du capitain
     * @param $m "le mail du capitain
     * @param $n "le nom du capitain
     * @param $fn "le prénom du capitain
     * @param $b "la date de naissace du capitain écrit sous la forme jj/mm/aaaa
     * @param $p "le mot de passe du capitain
     * @param $tn "le nom de l'équipe que le capitaine souhaite créé
     */
    function __construct($un, $m, $n, $fn, $b, $p, $tn)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $tn);
    }

    function addPlayerInTeam($player) {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = null where username = :username");
        $request->bindValue(':username',$player, PDO::PARAM_STR);
        $request->execute();
    }

    function removePlayerInTeam($player) {
        $bdd = __init__();
        $request=$bdd->prepare("UPDATE Guests set team = null where username = :username");
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }


    public function deleteTeam(){//dissoudre
            $bdd = __init__();

            $request = $bdd->prepare("Delete 
                                        from capitain
                                        WHERE username = :username ");//retire le capitaine de son equipe
            $request->bindValue(':username', $this->username, PDO::PARAM_STR);
            $request->execute();
            $prepare = $bdd->prepare("UPDATE Guests SET Team=null where Team = :teamname");
            $prepare->bindValue(':teamname', $this->team->name);
            $prepare->execute();

            $request2 = $bdd->prepare("Delete
                                        From Team
                                        where teamname = :teamname ");
            $request2->bindParam(':teamname', $this->team->name);
            $request2->execute();
            return new Player($this->username,
                $this->getMail(),
                $this->getName(),
                $this->getFirstname(),
                $this->getBirthday(),
                $this->getPassword(),
                null);
    }

    function searchPlayer($search/*recherche nom,prénom ou username,*/): array{
        $players = array();
        $bdd = __init__();
        $lines = array("username", "name", "firstname");
        for ($i=0; $i<3; $i++) {
            $SUN = $bdd->prepare("SELECT username, name, firstname, team 
                                        FROM Guests 
                                        WHERE :lines = :search");//recherche dans la base de donné
            $SUN->bindParam(':lines',$lines[i]);
            $SUN->bindParam(':search',$search);
            $SUN->execute();
            $SUN = $SUN->fetchAll();
            foreach ($SUN as $row) {
                $attributes = array();
                $attributes[0] = $row['username']; // Accède à la colonne 'username'
                $attributes[1] = $row['name'];    // Accède à la colonne 'name'
                $attributes[2] = $row['firstname']; // Accède à la colonne 'firstname'
                $attributes[3] = $row['team'];  // accède à la colonne 'Team'
                $players[-1] = $attributes;
            }
        }
        return $players;
    }

    function betIfEquals(){
        $min=1;
        $max=2;
        $random = rand($min, $max);
        return $random;
    }

    /**
     * @param text $playerSelectedUsername le pseudo du joueur que le capitain souhaite passer capitain
     * @return void
     */
    function chooseNewCapitain($playerSelectedUsername){
        $bdd = __init__();


        $request = $bdd->prepare("DELETE FROM capitain WHERE username = :ancienCapUsername");
        $request->bindValue(':ancienCapUsername',$this->username);
        $request->execute();

        $request1 = $bdd->prepare("INSERT INTO Capitain VALUES(:playerSelectedUsername,:teamName)");
        $request1->bindValue(':playerSelectedUsername',$playerSelectedUsername);
        $request1->bindValue(':teamName',$this->team);
        $request1->execute();
        /**/
    }
}
