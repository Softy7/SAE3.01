<?php

include('PlayerAdministrator.php');
class AdminCapitain extends PlayerAdministrator
{
    function __construct($un, $m, $n, $fn, $b, $p, $tn)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p, $tn);
    }

    function addPlayerInTeam($player, $team)
    {
        $bdd = __init__();
        $request = $this->db->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $team, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }


    function removePlayerInTeam($player)
    {
        $this->team->removePlayer($player);
    }

    public function askPlayer($player, $team)
    {

        $request = $this->db->prepare("INSERT INTO request VALUES (:Player, false, :team)");
        $request->bindValue(':team', $team, PDO::PARAM_STR);
        $request->bindValue(':Player', $player, PDO::PARAM_STR);
        $request->execute();
    }

    function addPlayer($teamname, $player)
    {

        $request = $this->db->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $teamname, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }

    public function deleteTeam($team)
    {//dissoudre

        $request = $this->db->prepare("Delete 
                                        from capitain
                                        WHERE username = :username ");//retire le capitaine de son equipe
        $request->bindValue(':username', $this->username, PDO::PARAM_STR);
        $request->execute();
        $prepare = $this->db->prepare("UPDATE Guests SET Team=null where Team = :teamname");
        $prepare->bindValue(':teamname', $team);
        $prepare->bindValue(':teamname', $this->team->name);
        $prepare->execute();
        $request2 = $this->db->prepare("Delete
                                        From Team
                                        where teamname = :teamname ");
        $request2->bindParam(':teamname', $team);
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

    function searchPlayer($search/*recherche nom,prénom ou username,*/): array
    {
        $players = array();

        $lines = array("username", "name", "firstname");
        for ($i = 0; $i < 3; $i++) {
            $SUN = $this->db->prepare("SELECT username, name, firstname, team 
                                        FROM Guests 
                                        WHERE :lines = :search");//recherche dans la base de donné
            $SUN->bindParam(':lines', $lines[i]);
            $SUN->bindParam(':search', $search);
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
     * @param String $playerSelectedUsername le pseudo du joueur que le capitain souhaite passer capitain
     * @return void
     */
    function chooseNewCapitain($playerSelectedUsername)
    {

        $request = $this->db->prepare("DELETE FROM capitain WHERE username = :ancienCapUsername");
        $request->bindValue(':ancienCapUsername', $this->username);
        $request->execute();

        $request1 = $this->db->prepare("INSERT INTO Capitain VALUES(:playerSelectedUsername,:teamName)");
        $request1->bindValue(':playerSelectedUsername', $playerSelectedUsername);
        $request1->bindValue(':teamName', $this->team);
        $request1->execute();

    }

    function nextMatchBet($id)
    {
        $req = $this->db->prepare("SELECT maxbet FROM run where idrun = :id ORDER BY(orderrun)");
        $req->bindParam(':id', $id);
        $req->execute();
        return $req->fetchAll()[0][0];
    }


    function getMatchNotPlayed($bdd)
    {

        $requete = $bdd->prepare("SELECT * FROM Match join run on Match.idRun = run.idRun 
         WHERE ((goal = 0 OR goal > 2 OR (penal = true or (penal = true and countmoves = 1))) 
         AND (attack=:equipeCap OR defend=:teamCap)) ORDER BY (orderrun)");
        $t = $this->getTeam();
        $requete->bindParam(':equipeCap', $t);
        $requete->bindParam(':teamCap', $t);
        $requete->execute();
        $req = $requete->fetchAll();
        return $req;
    }

    function enterScore($bdd, $nbDechole, $gameResult, $idMatch)
    {
        $requete = $bdd->prepare("Update Match SET countmoves=:score, goal=:win WHERE idmatch=:idMatch");
        $requete->bindParam(':score', $nbDechole);
        $requete->bindParam(':win', $gameResult);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function enterScorePenal($bdd, $nbCountAttack, $nbCountDefend, $idMatch, $count = 0)
    {
        $requete = $bdd->prepare("Update Match SET countattack=:countattack, countdefend=:countdefend, countmoves = :count WHERE idmatch=:idMatch");
        $requete->bindParam(':countattack', $nbCountAttack);
        $requete->bindParam(':countdefend', $nbCountDefend);
        $requete->bindParam(':count', $count);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function contest($id)
    {
        $req = $this->db->prepare("Update Match SET contest = true where idmatch = :id");
        $req->bindParam(':id', $id);
        $req->execute();
    }

    function getMatchNotValidated($bdd)
    {
        $requete = $bdd->prepare("SELECT * FROM Match WHERE (contest IS null) AND (attack=:equipeCap OR defend=:teamCap) ORDER BY(idmatch)");
        $team = $this->getTeam();
        $requete->bindParam(':equipeCap', $team);
        $requete->bindParam(':teamCap', $team);
        $requete->execute();
        $req = $requete->fetchAll();
        return $req;
    }

    function insertIntoBet($bdd, $idMatch, $bet)
    {
        $requete = $bdd->prepare("INSERT INTO bet VALUES(:cap,:idmatch,:pari)");
        $requete->bindParam(':cap', $this->username);
        $requete->bindParam(':idmatch', $idMatch);
        $requete->bindParam(':pari', $bet);
        $requete->execute();
    }

    function betIfEquals($bdd, $idMatch, $bet, $team2)
    {
        $min = 1;
        $max = 2;
        $random = rand($min, $max);
        $requete = $bdd->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
        $t1 = $this->getTeam();
        if ($random == 1) {
            $requete->bindParam(":equipe1", $t1);
            $requete->bindParam(":equipe2", $team2);
        } else {
            $requete->bindParam(":equipe2", $t1);
            $requete->bindParam(":equipe1", $team2);
        }
        $requete->bindParam(":bet", $bet);
        $requete->bindParam(':idMatch', $idMatch);
        $requete->execute();
    }

    function bet($idMatch, $bet, $team)
    {
        $req = $this->db->prepare("Select attack from match where idmatch = :idMatch");
        $req->bindValue(":idMatch", $idMatch);
        $req->execute();
        $req = $req->fetchAll()[0][0];
        if ($req == $this->getTeam()) {
            $requete = $this->db->prepare("UPDATE match set betteamkept=:bet WHERE idmatch=:idMatch");
            $requete->bindParam(":bet", $bet);
            $requete->bindParam(':idMatch', $idMatch);
            $requete->execute();
        } else {
            $requete = $this->db->prepare("UPDATE match SET attack=:equipe1, defend=:equipe2, betteamkept=:bet WHERE idmatch=:idMatch");
            $requete->bindParam(":equipe1", $req);
            $requete->bindParam(":equipe2", $team);
            $requete->bindParam(":bet", $bet);
            $requete->bindParam(':idMatch', $idMatch);
            $requete->execute();
        }
    }

    function getBet($bdd, $idMatch)
    {
        $req = $bdd->prepare("SELECT * FROM bet WHERE (idmatch=:idmatch)");
        $req->bindParam(':idmatch', $idMatch);
        $req->execute();
        $result = $req->fetchAll();
        return $result;
    }

    function checkScoreEntered($bdd)
    {
        $matchsNotValidated = $this->getMatchNotValidated($bdd);
        $matchNotPlayed = $this->getMatchNotPlayed($bdd);
        if ($matchsNotValidated[0][0] == $matchNotPlayed[0][0]) {
            return false;
        } else {
            return true;
        }
    }

    function checkPenalty($bdd)
    {
        $matchNotPlayed = $this->getMatchNotPlayed($bdd);
        if ($matchNotPlayed[0][7] == 1) {
            return true;
        } else {
            return false;
        }
    }
    function getPlayerFree() {
        $req = $this->db->prepare('Select guests.* from guests left join request on guests.username = request.username 
         where isplayer = true and isregistered = true and isdeleted = false and guests.team is null and request.username is null');
        $req->execute();
        return $req->fetchAll();
    }
}
