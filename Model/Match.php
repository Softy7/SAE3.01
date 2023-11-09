<?php
class Match {
    private Team $team1;
    private Team $team2;
    private string $parcours;
    private Team $chole; //equipe qui chole
    private int $betT1; // capitaine equipe 1 que pari
    private int $betT2; // capitaine equipe 2 que pari
    private bool $goal; //pour voir si l'équipe qui chole a marqué.

    /**
     *
     * @param Team $team1
     * @param Team $team2
     * @param String $parcours parcours sur le quel les deux équipes joue
     */

    function __construct($team1, $team2, $parcours)
    {
        $this->team1 = $team1;
        $this->team2 = $team2;
        $this->parcours = $parcours;
        $this->goal = false;
    }
    public function getTeam1()
    {
        return $this->team1;
    }

    public function getTeam2()
    {
        return $this->team2;
    }
    public function setBetT1($betT1)
    {
        $this->betT1 = $betT1;
    }

    public function setBetT2($betT2)
    {
        $this->betT2 = $betT2;
    }

    public function setChole($bdd, $annee) {
        if ($this->betT1 < $this->betT2) { //l'équipe 1 a un plus petit pari que l'equipe 2.
            $this->chole = $this->team1;
            $request = $bdd->prepare("update Match 
                                        set betteamkept = :betT1 and attack = :team1 and defend = :team2
                                        where attack = :team1Name and defend = :team2Name and annee = :annee");
            $request->bindValue(':betT1',$this->betT1,PDO::PARAM_INT);
            $request->bindParam(':team1',$this->team1);
            $request->bindParam(':team2',$this->team2);
            $request->bindValue(':team1Name',$this->team1->name,PDO::PARAM_STR);
            $request->bindValue(':team2Name',$this->team2->name,PDO::PARAM_STR);
            $request->bindValue(':annee',$annee,PDO::PARAM_INT);
            $request->execute();
        }
        else if ($this->betT1 > $this->betT2) {
            $this->chole = $this->team2;
            $request = $bdd->prepare("update Match 
                                        set betteamkept = :betT2 and attack = :team2 and defend = :team1
                                        where attack = :team1Name and defend = :team2Name and annee = :annee");
            $request->bindValue(':betT2',$this->betT2,PDO::PARAM_INT);
            $request->bindParam(':team1',$this->team1);
            $request->bindParam(':team2',$this->team2);
            $request->bindValue(':team1Name',$this->team1->name,PDO::PARAM_STR);
            $request->bindValue(':team2Name',$this->team2->name,PDO::PARAM_STR);
            $request->bindValue(':annee',$annee,PDO::PARAM_INT);
            $request->execute();
        }
        else {
            $random = random_int(0, 1);
            if ($random = 0) {
                $this->chole = $this->team1;
                $request = $bdd->prepare("update Match 
                                        set betteamkept = :betT1 and attack = :team1 and defend = :team2
                                        where attack = :team1Name and defend = :team2Name and annee = :annee");
                $request->bindValue(':betT1',$this->betT1,PDO::PARAM_INT);
                $request->bindParam(':team1',$this->team1);
                $request->bindParam(':team2',$this->team2);
                $request->bindValue(':team1Name',$this->team1->name,PDO::PARAM_STR);
                $request->bindValue(':team2Name',$this->team2->name,PDO::PARAM_STR);
                $request->bindValue(':annee',$annee,PDO::PARAM_INT);
                $request->execute();
            }
            else {
                $this->chole = $this->team2;
                $request = $bdd->prepare("update Match 
                                        set betteamkept = :betT2 and attack = :team2 and defend = :team1
                                        where attack = :team1Name and defend = :team2Name and annee = :annee");
                $request->bindValue(':betT2',$this->betT2,PDO::PARAM_INT);
                $request->bindParam(':team1',$this->team1);
                $request->bindParam(':team2',$this->team2);
                $request->bindValue(':team1Name',$this->team1->name,PDO::PARAM_STR);
                $request->bindValue(':team2Name',$this->team2->name,PDO::PARAM_STR);
                $request->bindValue(':annee',$annee,PDO::PARAM_INT);
                $request->execute();
            }
        }
    }

    public function setGoal($bdd, $annee, $isScored) {
        $this->goal = true;
        $request = $bdd->prepare("update Match 
                                        set goal = true
                                        where attack = :team1Name and defend = :team2Name and annee = :annee");
        $request->bindValue(':team1Name',$this->team1->name,PDO::PARAM_STR);
        $request->bindValue(':team2Name',$this->team2->name,PDO::PARAM_STR);
        $request->bindValue(':annee',$annee,PDO::PARAM_INT);
        $request->execute();
    }
}