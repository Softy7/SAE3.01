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



    function getMatchNotPlayed($bdd){
        $requete=$bdd->prepare("SELECT * FROM Match WHERE (countmoves = 0 OR countattack = 0) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
        $requete->bindParam(':equipeCap',$this->getTeam());
        $requete->bindParam(':teamCap',$this->getTeam());
        $requete->execute();
        $req=$requete->fetchAll();
        return $req;
    }

    function enterScore($bdd,$nbDechole,$gameResult,$idMatch){
        $requete = $bdd->prepare("Update Match SET countmoves=:score, goal=:win WHERE idmatch=:idMatch");
        $requete->bindParam(':score',$nbDechole);
        $requete->bindParam(':win', $gameResult);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function enterScorePenal($bdd,$nbCountAttack,$nbCountDefend,$idMatch){
        $requete = $bdd->prepare("Update Match SET countattack=:countattack, countdefend=:countdefend WHERE idmatch=:idMatch");
        $requete->bindParam(':countattack',$nbCountAttack);
        $requete->bindParam(':countdefend', $nbCountDefend);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function confirmation($bdd,$contestation,$idMatch){
        $requete = $bdd->prepare("Update Match SET contestation=:contestation WHERE idmatch=:idMatch");
        $requete->bindParam(':contestation', $contestation);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function getMatchNotValidated($bdd){
        $requete=$bdd->prepare("SELECT * FROM Match WHERE (contestation IS null) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
        $requete->bindParam(':equipeCap',$this->getTeam());
        $requete->bindParam(':teamCap',$this->getTeam());
        $requete->execute();
        $req=$requete->fetchAll();
        return $req;
    }

    function insertIntoBet($bdd,$idMatch,$bet){
        $requete = $bdd->prepare("INSERT INTO bet VALUES(:cap,:idmatch,:pari)");
        $requete->bindParam(':cap', $this->username);
        $requete->bindParam(':idmatch', $idMatch);
        $requete->bindParam(':pari', $bet);
        $requete->execute();
    }

    function betIfEquals($bdd,$idMatch,$bet,$team2){
        $min=1;
        $max=2;
        $random = rand($min, $max);
        if ($random==1){
            $requete = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete->bindParam(":equipe1", $this->getTeam());
            $requete->bindParam(":equipe2", $team2);
            $requete->bindParam(":bet", $bet);
            $requete->bindParam(':idMatch',$idMatch);
            $requete->execute();
        }
        elseif ($random==2){
            $requete = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete->bindParam(":equipe1", $team2);
            $requete->bindParam(":equipe2", $this->getTeam());
            $requete->bindParam(":bet", $bet);
            $requete->bindParam(':idMatch',$idMatch);
            $requete->execute();
        }

    }

    function bet($bdd,$idMatch,$bet,$team2){
        $requete = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
        $requete->bindParam(":equipe1", $this->getTeam());
        $requete->bindParam(":equipe2", $team2);
        $requete->bindParam(":bet", $bet);
        $requete->bindParam(':idMatch',$idMatch);
        $requete->execute();
    }

    function getBet($bdd,$idMatch){
        $req=$bdd->prepare("SELECT * FROM bet WHERE (idmatch=:idmatch)");
        $req->bindParam(':idmatch',$idMatch);
        $req->execute();
        $resultats=$req->fetchAll();
        return $resultats;
    }

    function checkScoreEntered($bdd){
        $matchsNotValidated=$this->getMatchNotValidated($bdd);
        $matchNotPlayed=$this->getMatchNotPlayed($bdd);
        if ($matchsNotValidated[0][0]==$matchNotPlayed[0][0]){
            return false;
        }
        else{
            return true;
        }
    }

    function checkPenalty($bdd){
        $matchNotPlayed=$this->getMatchNotPlayed($bdd);
        if ($matchNotPlayed[0][7]==1){
            return true;
        }
        else {
            return false;
        }
    }

}
