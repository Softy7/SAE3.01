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

    function getPlayer($bdd)
    {
        $req = $bdd->prepare("select username ,firstname, name, team from Guests where isDeleted = false AND isregistered = true AND isplayer = true ORDER BY team");
        $req->execute();
        return $req->fetchall();
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

    function createMatch($bdd, $t1, $t2, $year, $run)
    {
        $req = $bdd->prepare("insert into Match (attack, defend, betteamkept, goal, annee, penal, contest, countattack, countdefend, countmoves) 
                              values (:t1, :t2, null, false, :year, :runID, false, null)");
        $req->bindValue(':t1', $t1);
        $req->bindValue(':t2', $t2);
        $req->bindValue(':year', $year);
        $req->bindValue('runID', $run);
        $req->execute();
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

    function getRun($bdd) {
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

    function getMatchInRun($bdd,$idR) {
        $req = $bdd->prepare("select * from Match where idrun = :idr");
        $req->bindValue(":idr", $idR);
        $req->execute();
        return $req->fetchAll();
    }

    function getTeamInRun($bdd, $idr) {
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

    function getTeamsNotInRun($bdd, $idr) {
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

    function getTeams($bdd) {
        $req = $bdd->prepare("select teamname from team");
        $req->execute();
        return $req->fetchAll();
    }

    function addRun($link, $data, $pdd, $pda, $nbpm, $o, $bdd) {
        $req = $bdd->prepare("INSERT INTO run (title, image_data, starterpoint, finalpoint, orderrun, maxbet) VALUES (:link, :data, :pdd, :pda, :paris, :o)");
        $req->bindValue(":link", $link);
        $req->bindValue(":data", $data, PDO::PARAM_LOB);
        $req->bindValue(":pdd", $pdd);
        $req->bindValue(":o", $o);
        $req->bindValue(":paris", $nbpm);
        $req->execute();
    }

function deleteRun($link, $bdd)
{
    $req = $bdd->prepare("DELETE From run where title= :link ");
    $req->bindValue(":link", $link);
    $req->execute;
}

function updateRun($link, $data, $pdd, $pda, $remplacer, $nbpm, $bdd)
{
    $req = $bdd->prepare("UPDATE run SET title= :link and maxBet= :nbpm AND image_data=:data And starterPoint=:pdd And finalPoint=:pda  where title= :remplacer ");
    $req->bindValue(":link", $link);
    $req->bindValue(":data", $data);
    $req->bindValue(":pdd", $pdd);
    $req->bindValue(":pda", $pda);
    $req->bindValue(":paris", $nbpm);
    $req->bindValue(":remplacer", $remplacer);
    $req->execute;
}

    /**/



}
