<?php

include_once('Member.php');

class Administrator extends Member
{
    /**
     * @param String $un le pseudo de l'administrateur
     * @param String $m le mail de l'administrateur
     * @param String $n le nom de l'administrateur
     * @param String $fn le prénom de l'administrateur
     * @param String $b la date de naissance de écrit sous la forme jj/mm/aaaa
     * @param String $p le mot de passe de l'administrateur
     */
    public function __construct($un, $m, $n, $fn, $b, $p)
    {
        parent::__construct($un, $m, $n, $fn, $b, $p);
    }


    /**
     * passe le visiteur qui est en train de s'enregistrer en membre
     *
     * @param $un
     * @param $bdd
     * @return void
     */
    //à modifier
    function BecomeMember($un, $bdd)
    {
        $req = $bdd->prepare("UPDATE Guests set isregistered = true WHERE username = :username");
        $req->bindValue(':username', $un, PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * obtenir tout les membres qui se sont désinscrit
     *
     * @param $bdd
     * @return void
     */
    function getDeleted(): array {
        $req = $this->db->prepare("select username, mail, name, firstname, birthday from Guests where isDeleted = true");
        $req->execute();
        return $req->fetchAll();
    }

    function upgradeMember($bdd, $username){
        $req = $bdd->prepare("UPDATE Guests set isAdmin = true WHERE username = '$username'");
        $req->execute();
    }

    function getNotRegistrered() {
        $req = $this->db->prepare("SELECT username, mail, name, firstname, birthday FROM Guests WHERE isRegistered = false and isDeleted = false");
        $req->execute();
        return $req->fetchAll();
    }
    function getMember($bdd, $player)
    {
        $req = $bdd->prepare("select username ,firstname, name, team, isadmin from Guests where isDeleted = false AND isregistered = true AND isplayer = true AND username != :player ORDER BY team");
        $req->bindValue(':player', $player);
        $req->execute();
        return $req->fetchall();
    }

    function createTeamByStrench($team, $cap, $P1, $bdd){
        $this->createTeam($team, $cap, $bdd);
        $this->addPlayerBis($team, $P1);
    }

    public function createTeam($teamName, $playerUsername, $bdd)
    {
        $requete = $bdd->prepare("INSERT INTO Team VALUES (:teamName,0,0,0)");
        $requete->bindParam(':teamName', $teamName);
        $requete->execute();

        $requete0 = $bdd->prepare("INSERT INTO Capitain VALUES (:capUsername,:teamName)");
        $requete0->bindParam(':capUsername', $this->username);
        $requete0->bindParam(':teamName', $teamName);
        $requete0->execute();

        $requete1 = $bdd->prepare("UPDATE Guests SET Team=:teamName WHERE username=:playerUsername");
        $requete1->bindParam(':teamName', $teamName);
        $requete1->bindParam(':playerUsername', $playerUsername);
        $requete1->execute();

        $requete2 = $bdd->prepare("UPDATE Guests SET Team=:teamName WHERE username=:thisUsername");
        $requete2->bindParam(':teamName', $teamName);
        $requete2->bindParam(':thisUsername', $this->username);
        $requete2->execute();
    }
    function addPlayerBis($teamname, $player){
        $bdd = __init__();
        $request = $bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $teamname, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }

    /**
     * repasse les membres désinscrit en membre
     *
     * @param $username
     * @param $bdd
     * @return void
     */
    function resetDeleted($username, $bdd)
    {
        $req = $bdd->prepare("Update Guests set isDeleted = false where username = :username");
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
        $req = $bdd->prepare("Update Guests set isRegistered = true where username = :username");
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * supprime définitivement un membre
     *
     * @param $username
     * @param $bdd
     * @return void
     */
    function deletePermenantly($username, $bdd)
    {
        $req = $bdd->prepare("DELETE FROM Guests WHERE username = :username");
        $req->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
    }


    /**
     * ouvre les inscription du tournois
     *
     * @param $bdd
     * @return void
     */
    function setIsOpen($bdd)
    {
        $req = $bdd->prepare("UPDATE Inscription SET open = true WHERE open = false");
        $req->execute();
    }


    /**
     * ferme les inscription du tournois
     *
     * @param $bdd
     * @return void
     */
    function setIsClosed($bdd)
    {
        $req = $bdd->prepare("Update Inscription set open = false WHERE open = true");
        $req->execute();
    }

    function setAdmin($bdd, $username)
    {
        $req = $bdd->prepare("Update Guests set isAdmin = true where username = :username");
        $bdd->bindValue(':username', $username, PDO::PARAM_STR);
        $req->execute();
    }

    function getPlayer($db) {
        $req = $db->prepare("select username ,firstname, name, team, isadmin from Guests where isDeleted = false AND isregistered = true AND isplayer = true ORDER BY team");
        $req->execute();
        return $req->fetchAll();
    }

    function getMatch($bdd, $t = null)
    {
        if ($t == null) {
            $req = $bdd->prepare("select * from Match 
                                  join public.run r on r.idrun = Match.idrun
                                  order by r.orderrun");
            $req->execute();
            return $req->fetchAll();
        } else {
            $req = $bdd->prepare("select * from Match 
                                  join public.run r on r.idrun = Match.idrun
                                  where attack = :t or defend = :t
                                  order by r.orderrun");
            $req->bindValue(":t", $t, PDO::PARAM_STR);
            $req->execute();
            return $req->fetchAll();
        }
    }

    function getOneMatch($bdd, $id)
    {
        $req = $bdd->prepare("select * from Match where idmatch = :id");
        $req->bindValue(':id', $id);
        $req->execute();
        return $req->fetchAll();
    }

    function getRun($bdd,$idr = null)
    {
        if ($idr == null) {
        $req = $bdd->prepare('select * from run order by orderrun');
        $req->execute();
        return $req->fetchAll();
        } else {
            $req = $bdd->prepare('select * from run where idrun = :idr');
            $req->bindValue(':idr', $idr);
            $req->execute();
            return $req->fetchAll();
        }
    }

    /**
     * compte le nombre d'administrateur
     *
     * @param $bdd
     * @return int;
     */
    function lenghtAdmin($bdd)
    {
        $req = $bdd->prepare("select count(*) from Guests where isAdmin = true");
        $req->execute();
        $req = $req->fetchall();
        return $req[0][0];
    }

    function getMatchInRun($bdd, $idR)
    {
        $req = $bdd->prepare("select * from Match where idrun = :idr");
        $req->bindValue(":idr", $idR);
        $req->execute();
        return $req->fetchAll();
    }

    function getContest($bdd, $id)
    {
        $req = $bdd->prepare("select * from Match where idmatch = :id");
        $req->bindValue(':id', $id);
        $req->execute();
        return $req->fetchAll();
    }

    function setContest($bdd, $id, $result, $moves)
    {
        $req = $bdd->prepare("update Match set goal = :result, countmoves = :moves, contest = null where idmatch = :id");
        $req->bindValue(':result', $result);
        $req->bindValue(':id', $id);
        $req->bindValue(':moves', $moves);
        $req->execute();
    }

    function setScoreContest($bdd, $id, $st1, $st2)
    {
        $req = $bdd->prepare("update Match set countattack = :st1, countdefend = :st2, contest = null where idmatch = :id");
        $req->bindValue(':st1', $st1);
        $req->bindValue(':st2', $st2);
        $req->bindValue(':id', $id);
        $req->execute();
    }

    function getTeamInRun($bdd, $idr)
    {
        $req = $bdd->prepare("select Attack, Defend from Match where idrun = :idr");
        $req->bindValue(':idr', $idr);
        $req->execute();
        $req = $req->fetchAll();
        $tab = array();
        foreach ($req as $r) {
            $tab[-1] = $r[0];
            $tab[-1] = $r[1];
        }
        return $tab;
    }

    function getTeamsNotInRun($bdd, $idr)
    {
        $req = $bdd->prepare("select Team.teamname from Team
                where Team.teamName not in (
                Select Team.teamname from Team
                join Match on Team.teamname = Match.attack
                where idRun = :idr
                union (select Team.teamname from Team
                join Match on Team.teamname = Match.defend
                where idRun = :idr))");
        $req->bindValue(":idr", $idr);
        $req->execute();
        return $req->fetchAll();

    }

    function getTeams($bdd)
    {
        $req = $bdd->prepare("select teamname from team");
        $req->execute();
        return $req->fetchAll();
    }



    function addRun($title,$data, $pdd, $pda, $order, $nbpm, $bdd){
        $req = $bdd->prepare("INSERT INTO run (title, image_data, starterpoint, finalpoint, orderrun, maxbet) VALUES (:title, :data, :pdd, :pda, :order, :paris)");
        $req->bindValue(":title", $title);
        $req->bindValue(":data", $data,PDO::PARAM_LOB);
        $req->bindValue(":pdd", $pdd);
        $req->bindValue(":pda", $pda);
        $req->bindValue(':order', $order);
        $req->bindValue(":paris", $nbpm);
        $req->execute();
    }


    function deleteRun($id, $bdd)
    {
        $req = $bdd->prepare("DELETE From run where title= :id ");
        $req->bindValue(":id", $id);
        $req->execute();
    }

    function updateRun($link,$data,$pdd,$pda,$remplacer,$nbpm,$bdd)
    {
        $req = $bdd->prepare("UPDATE run SET title = :link, maxBet = :nbpm, image_data = :data, starterPoint = :pdd, finalPoint = :pda WHERE title = :remplacer");
        $req->bindValue(":link", $link);
        $req->bindValue(":data", $data, PDO::PARAM_LOB);
        $req->bindValue(":pdd", $pdd);
        $req->bindValue(":pda", $pda);
        $req->bindValue(":nbpm", $nbpm);
        $req->bindValue(":remplacer", $remplacer);
        $req->execute();
    }

    public function createTeamF($teamName, $capiUsername, $bdd) {
        $requete = $bdd->prepare("INSERT INTO Team VALUES (:teamName,0,0,0)");
        $requete->bindParam(':teamName', $teamName);
        $requete->execute();
        $requete0 = $bdd->prepare("INSERT INTO Capitain VALUES (:capUsername,:teamName)");
        $requete0->bindParam(':capUsername', $capiUsername);
        $requete0->bindParam(':teamName', $teamName);
        $requete0->execute();
        $requete1 = $bdd->prepare("UPDATE Guests SET Team=:teamName WHERE username=:playerUsername");
        $requete1->bindParam(':teamName', $teamName);
        $requete1->bindParam(':playerUsername', $capiUsername);
        $requete1->execute();

    }

    function searchFile($title,$bdd){
        $req = $bdd->prepare("select image_data from run where title = :title");
        $req-> bindValue(":title",$title);
        $req->execute();
        $req=$req->fetchall();
        return $req[0][0];
    }

    function addPlayerF($teamname, $player)
    {
        $bdd = __init__();
        $request = $bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $teamname, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }

    function createMatchs($bdd)
    {
        $countTeam = $bdd->prepare("Select count(*) from team");
        $countTeam->execute();
        $countTeam = $countTeam->fetchAll()[0];
        $runs = $this->getRun($bdd);
        $teams = $this->getTeams($bdd);
        if ($countTeam[0] % 2 != 0) {
            return false;
        } else {
            $middle = $countTeam[0] / 2;
            foreach ($runs as $r) {
                for ($i = 0; $i < $middle; $i++) {
                    $t1 = $teams[$i]['teamname'];
                    $j = $countTeam[0] - 1 - $i;
                    $t2 = $teams[$j]['teamname'];
                    $match = array($t1, $t2, $r[0]);
                    if ($r[6] == 0) {
                        $request = $bdd->prepare("INSERT INTO match VALUES (DEFAULT, :attack, :defend, null, null, :year, :idrun, true, null, null, null, 0)");
                    } else {
                        $request = $bdd->prepare("INSERT INTO match VALUES (DEFAULT, :attack, :defend, null, 0, :year, :idrun, false, null, null, null, null)");
                    }
                    $date = date("Y");
                    $request->bindParam(':attack', $match[0]);
                    $request->bindParam(':defend', $match[1]);
                    $request->bindParam(':year', $date);
                    $request->bindParam(':idrun', $match[2]);
                    $request->execute();
                }
                $tmp = $teams[1];
                for ($i = 1; $i < $countTeam[0] - 1; $i++) {
                    $teams[$i] = $teams[$i + 1];
                }
                $teams[$countTeam[0] - 1] = $tmp;
            }
            return true;
        }
    }

    function destroyTournament($bdd){
        $requete = $bdd->prepare("DELETE FROM match");
        $requete->execute();
    }

    function checkAllMatch($bdd) {}
}
