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
    function getDeleted($bdd)
    {
        $req = $bdd->prepare("select username, mail, name, firstname, birthday, password from Guests where isDeleted = true");
        $req->execute();
        return $req->fetchall();
    }

    function upgradeMember($bdd, $username){
        $req = $bdd->prepare("UPDATE Guests set isAdmin = true WHERE username = '$username'");
        $req->execute();
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

    function TournamentEnd($bdd): bool
    {
        $req1 = $bdd->prepare("SELECT match.idrun, COUNT(attack) as count_attack, COUNT(defend) as count_defend FROM match GROUP BY match.idrun");
        $req1->execute();
        $matchesCounts = $req1->fetchAll(PDO::FETCH_ASSOC);

        $req2 = $bdd->prepare("SELECT COUNT(teamname) as count_team FROM team");
        $req2->execute();
        $count2 = $req2->fetch()['count_team'];

        $req3 = $bdd->prepare("SELECT COUNT(idrun) as count_idrun FROM run");
        $req3->execute();
        $count3 = $req3->fetch()['count_idrun'];

        if (count($matchesCounts) == $count3) {
            foreach ($matchesCounts as $match) {
                $count = $match['count_attack'] + $match['count_defend'];
                if ($count2 != $count) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }


    function RelsultCalculation($bdd, $team): array
    {
        $resAttack = $bdd->prepare("select count(goal) as count_goal from match where attack = :team AND goal = 1 AND penal = false");
        $resAttack->bindValue(':team', $team, PDO::PARAM_STR);
        $resAttack->execute();
        $WinAttack = $resAttack->fetch()['count_goal'];

        $resDefend = $bdd->prepare("select count(goal) as count_goal from match where defend = :team AND goal = 2 AND penal = false");
        $resDefend->bindValue(':team', $team, PDO::PARAM_STR);
        $resDefend->execute();
        $WinDefend = $resDefend->fetch()['count_goal'];

        $resPalAttack = $bdd->prepare("select count(idrun) as count_idrun from match where attack = :team AND countattack <= match.countdefend AND penal = true");
        $resPalAttack->bindValue(':team', $team, PDO::PARAM_STR);
        $resPalAttack->execute();
        $resPalDefend = $bdd->prepare("select count(idrun) as count_idrun from match where defend = :team AND countattack >= match.countdefend AND penal = true");
        $resPalDefend->bindValue(':team', $team, PDO::PARAM_STR);
        $resPalDefend->execute();
        $WinAttackPal = $resPalAttack->fetch()['count_idrun'];
        $WinDefendPal = $resPalDefend->fetch()['count_idrun'];

        $WinPal = $WinAttackPal + $WinDefendPal;

        $TotalWin = $WinAttack + $WinDefend + $WinPal;

        return [$team, $TotalWin, $WinAttack, $WinDefend];
    }

    function EditionCheck($bdd): bool{
        $year = date("Y");
        $req = $bdd->prepare("select Edition FROM old_tournament WHERE edition = :year");
        $req->bindValue(':year', $year);
        $req->execute();
        $res = $req->fetchall();
        if($res != null){
            return false;
        }
        return true;
    }

    function SaveTournament($bdd, $class, $Team){
        $year = date("Y");
        $req = $bdd->prepare("Insert INTO old_tournament VALUES (:year, :class, :team)");
        $req->bindValue(':year', $year);
        $req->bindValue(':class', $class, PDO::PARAM_STR);
        $req->bindValue(':team', $Team, PDO::PARAM_STR);
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
    function createMatch($bdd, $t1, $t2, $year, $run)
    {
        $check = $bdd->prepare("Select maxbet from run where idrun = :runID");
        $check->bindValue(':runId', $run);
        $check->execute();
        $check = $check->fetchAll()[0][0];
        if ($check == 0) {
            $req = $bdd->prepare("insert into Match (attack, defend, betteamkept, goal, annee, idrun, penal, contest, countattack, countdefend, countmoves) 
                              values (:t1, :t2, null, null, :year, :runID, true, null, null, null, null)");
            $req->bindValue(':t1', $t1);
            $req->bindValue(':t2', $t2);
            $req->bindValue(':year', $year);
            $req->bindValue('runID', $run);
            $req->execute();
        }
    }

    function getMatch($bdd, $t)
    {
        if ($t == null) {
            $req = $bdd->prepare("select * from Match 
                                  join public.run r on Match.idmatch = r.idrun
                                  order by r.orderrun");
            $req->execute();
            return $req->fetchAll();
        } else {
            $req = $bdd->prepare('select * from Match 
                                  join public.run r on Match.idmatch = r.idrun
                                  where attack = :t or defend = :t
                                  order by r.orderrun');
            $req->bindValue(":t", $t);
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

    function getRun($bdd)
    {
        $req = $bdd->prepare('select * from run order by orderrun');
        $req->execute();
        return $req->fetchAll();
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


    function addRun($title, $link, $data, $pdd, $pda, $order, $nbpm, $bdd){
        $req = $bdd->prepare("INSERT INTO run (title, image_data, starterpoint, finalpoint, orderrun, maxbet) VALUES (:title, :link, :pdd, :pda, :order, :paris)");
        $req->bindValue(":title", $title);
        $req->bindValue(":link", $link);
        $req->bindValue(":data", $data,PDO::PARAM_LOB);
        $req->bindValue(":pdd", $pdd);
        $req->bindValue(":pda", $pda);
        $req->bindValue(':order', $order);
        $req->bindValue(":paris", $nbpm);
        $req->execute();
    }


    function deleteRun($id, $bdd)
    {
        $req = $bdd->prepare("DELETE From run where idrun= :id ");
        $req->bindValue(":id", $id);
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

    function addPlayerF($teamname, $player)
    {
        $bdd = __init__();
        $request = $bdd->prepare("UPDATE Guests set team = :teamname where username = :username");
        $request->bindValue(':teamname', $teamname, PDO::PARAM_STR);
        $request->bindValue(':username', $player, PDO::PARAM_STR);
        $request->execute();
    }
}
