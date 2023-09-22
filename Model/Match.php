<?php
class Match
{
    private $team1;
    private $team2;
    private $parcours;
    private $chole; //equipe qui chole
    private $betT1; // capitaine equipe 1 que pari
    private $betT2; // capitaine equipe 2 que pari
    private $goal; //pour voir si l'équipe qui chole a marquer.

    function __construct($team1, $team2, $parcours)
    {
        $this->team1 = $team1;
        $this->team2 = $team2;
        $this->parcour = $parcours;
        $this->goal = false;
    }

    /**
     * @return mixed
     */
    public function getTeam1()
    {
        return $this->team1;
    }

    /**
     * @param mixed $team1
     *
     * /**
     * @param mixed $betT1
     */
    public function setBetT1($betT1)
    {
        $this->betT1 = $betT1;
    }

    /**
     * @param mixed $betT2
     */
    public function setBetT2($betT2)
    {
        $this->betT2 = $betT2;
    }

    /**
     * @param mixed $chole
     */
    public function setChole() {
        if ($this->betT1 < $this->betT2) {
            $this->chole = $this->team1;
        }
        else if ($this->betT1 > $this->betT2) {
            $this->chole = $this->team2;
        }
        else {
            $random = random_int(0, 1);
            if ($random = 0) {
                $this->chole = $this->team1;
            }
            else {
                $this->chole = $this->team2;
            }
        }
    }


    /**
     * @param mixed $goal
     */
    public function setGoal() {
        $this->goal = true;
    }
}