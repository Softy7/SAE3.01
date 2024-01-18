<?php
session_start();

require_once('../../Model/Capitain.php');
require_once('../../Model/AdminCapitain.php');
require_once('../../ConnexionDataBase.php');
require_once("../../Controller/launch.php");

$bdd=__init__();
$user=launch();

if ($_SESSION['connected']) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quarouble Chôlage.fr</title>
        <link href="HomeTournaments.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <h1><?php echo $_SESSION['view'] ?></h1>
    <p>Bienvenue sur votre espace de Tournois! Monsieur <?php echo $_SESSION['username']?></p>
    <button onclick="window.location.href='../../Controller/Connect/CheckConnect.php'" id="retour">Retour</button>
    <form action="../../Controller/Connect/Deconnect.php" method="post">
        <input type="submit" value="Déconnexion" id="deconnexion"/>
    </form>
    <?php
    if ($_SESSION['teamName'] != null) {
        ?>
        <p><?php echo 'Vous êtes dans l\'équipe ', $_SESSION['teamName'];?></p>
    <?php
    }

    if($_SESSION['isPlayer']==1){
        ?>
        <?php
        if($_SESSION['captain']==1){
            $Matchs=$user->getMatchNotValidated($bdd);
            $bets=$user->getBet($bdd,$Matchs[0][0]);
            $MatchsNotPlayed=$user->getMatchNotPlayed($bdd);
            if(empty($MatchsNotPlayed)){ ?>
                <p>vous n'avez plus de match à joué</p>
                <?php
            }
            //les deux équipes n'ont pas parié
            elseif(empty($bets)){
                $bets=$user->getBet($bdd,$Matchs[0][0]);
            ?>
                <h1>Aucun pari n'a été effectuer pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <button onclick="window.location.href='../Capitain/Bet.php'" id="parier">parier</button>

            <?php
            }
            //si le match est un pénalti, que le capitaine est en attaque et que le score n'est pas entré
            elseif ($user->checkPenalty($bdd) && $Matchs[0][1] == $user->username && !$user->checkScoreEntered($bdd)){
                $Matchs=$user->getMatchNotValidated($bdd);
                ?>
                <h1>Le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?> est un match de penalty</h1>
                <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">entrerScore</button>
                <?php
            }
            //si le match est un pénalti, que le capitaine est en attaque et que le score est entré
            elseif ($user->checkPenalty($bdd) && $Matchs[0][1] == $user->username && $user->checkScoreEntered($bdd)){
                $Matchs=$user->getMatchNotValidated($bdd);
                ?>
                <h1>Vous avez entré que votre equipe a marqué <?php echo $Matchs[0][9]; ?> et que l'equipe adverse a marqué <?php $Matchs[0][10] ?> match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <?php
            }
            //si le match est un pénalti, que le capitaine est en défense et que le score n'est pas entré
            elseif ($user->checkPenalty($bdd) && $Matchs[0][2] == $user->username && !$user->checkScoreEntered($bdd)){
                $Matchs=$user->getMatchNotValidated($bdd);
                ?>
                <h1>Le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?> est un match de penalty et le score n'a pas été entrer</h1>
                <?php
            }
            //si le match est un pénalti, que le capitaine est en défense et que le score est entré
            elseif ($user->checkPenalty($bdd) && $Matchs[0][2] == $user->username && $user->checkScoreEntered($bdd)){
                $Matchs=$user->getMatchNotValidated($bdd);
                ?>
                <h1>le capitaine adverse a entré que son equipe a marqué <?php echo $Matchs[0][9]; ?> et que votre equipe a marqué <?php $Matchs[0][10] ?> pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <?php
            }

            //le capitaine de l'equipe n'a pas parié
            elseif($bets[0][0]!=$user->username && $bets[1][0]==""){?>
                <h1>Votre pari n'a pas été effectuer pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <button onclick="window.location.href='../Capitain/Bet.php'" id="parier">parier</button>
            <?php
                $bets=$user->getBet($bdd,$Matchs[0][0]);
            }
            //le capitaine de l'equipe a parié mais le capitaine de l'equipe advairse n'a pas parié
            elseif($bets[0][0]==$user->username && $bets[1][0]==""){
                $bets=$user->getBet($bdd,$Matchs[0][0]);
                ?>
                <h1>Vous avez parié que vous pouvez gagné en <?php echo $bets[0][2]; ?> coup de déchole pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <?php
            }
            //le capitaine est le premier a avoir parier
            elseif($bets[0][0]==$user->username && $bets[1][0]!=$user->username){
                ?>
                <h1>Vous avez parié que vous pouvez gagné en <?php echo $bets[0][2]; ?> coup de déchole, votre adversaire a pari qu'ils gagneront en <?php echo $bets[1][2]; ?> pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <?php
                $Matchs=$user->getMatchNotValidated($bdd);
                //le parie du capitaine est le plus petit et le score n a pas encore été entrer
                if($bets[0][2]<$bets[1][2] && !$user->checkScoreEntered($bdd)){
                    ?>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">entrerScore</button>
                    <?php
                }
                //le parie du capitaine est le plus petit et le score a été entrer
                elseif($bets[0][2]<$bets[1][2] && $user->checkScoreEntered($bdd)){
                    $Matchs=$user->getMatchNotValidated($bdd);?>
                    <p>vous avez entré que vous avez <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <?php
                }
                //le parie du capitaine est le plus grand et le score n'a pas été entré
                elseif ($bets[0][2]>$bets[1][2] && $Matchs[0][4]==0){?>
                        <p>le score n'a pas encore été entrée</p>
                    <?php
                }

                //le parie du capitaine est le plus grand et le score a été entré
                elseif ($bets[0][2]>$bets[1][2] && $Matchs[0][4]!=0 ){?>
                    <p>le capitaine a entré qu'il a <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">confirmation</button>
                    <?php
                }

                //le pari est du capitaine est égale et le capitaine attaque et le score n'a pas été entrer
                elseif ($bets[0][2]==$bets[1][2] && $Matchs[0][1]==$user->username && !$user->checkScoreEntered($bdd)){?>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">entrerScore</button>
                    <?php
                }
                //le pari est du capitaine est égale et le capitaine attaque et le score a été entrer
                elseif ($bets[0][2]==$bets[1][2] && $Matchs[0][1]==$user->username && $user->checkScoreEntered($bdd)){
                    $Matchs=$user->getMatchNotValidated($bdd);
                    ?>
                    <p>vous avez entré que vous avez <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <?php
                }

                //le pari est du capitaine est égale, l'équipe du capitaine defend et le score a été entré
                elseif ($bets[0][2]==$bets[1][2] && $Matchs[0][4]==0){?>
                    <p>le score n'a pas encore été entrée</p>
                    <?php
                }

                //le pari est du capitaine est égale, l'équipe du capitaine defend et le score a été entré
                elseif ($bets[0][2]==$bets[1][2] && $Matchs[0][4]!=0){?>
                    <p>le capitaine a entré qu'il a <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">confirmation</button>
                    <?php
                }
            }
            //le capitaine est le deuxieme a avoir parié
            elseif($bets[0][0]!=$user->username && $bets[1][0]==$user->username){ ?>
                <h1>Vous avez parié que vous pouvez gagné en <?php echo $bets[1][2]; ?> coup de déchole, votre adversaire a pari qu'ils gagneront en <?php echo $bets[0][2]; ?> pour le match de <?php echo $Matchs[0][1]; ?> contre <?php echo $Matchs[0][2]; ?></h1>
                <?php
                $Matchs=$user->getMatchNotValidated($bdd);

                //le parie du capitaine est le plus petit et le score n'a pas été entrer
                if($bets[1][2]<$bets[0][2] && !$user->checkScoreEntered($bdd)){ ?>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">entrerScore</button>
                    <?php
                }
                //le parie du capitaine est le plus petit et le score a été entrer
                elseif($bets[1][2]<$bets[0][2] && $user->checkScoreEntered($bdd)){
                    $Matchs=$user->getMatchNotValidated($bdd);
                    ?>
                    <p>vous avez entré que vous avez <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <?php
                }

                //le parie du capitaine est le plus grand et le score n'a pas été entré
                elseif ($bets[1][2]>$bets[0][2] && $Matchs[0][4]==0){?>
                    <p>le score n'a pas encore été entrée</p>
                    <?php
                }

                //le parie du capitaine est le plus grand et le score a été entré
                elseif ($bets[1][2]>$bets[0][2] && $Matchs[0][4]!=0){?>
                    <p>le capitaine a entré qu'il a <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">confirmation</button>
                    <?php
                }

                //le pari est du capitaine est égale et le capitaine attaque
                elseif ($bets[1][2]==$bets[0][2] && $Matchs[0][1]==$user->username && !$user->checkScoreEntered($bdd)){?>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">entrerScore</button>
                    <?php
                }

                elseif ($bets[1][2]==$bets[0][2] && $Matchs[0][1]==$user->username && $user->checkScoreEntered($bdd)){
                    $Matchs=$user->getMatchNotValidated($bdd);
                    ?>
                    <p>vous avez entré que vous avez <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <?php
                }
                //le pari est du capitaine est égale, l'équipe du capitaine defend et le score a été entré
                elseif ($bets[1][2]==$bets[0][2] && $Matchs[0][4]==0){?>
                    <p>le score n'a pas encore été entrée</p>
                    <?php
                }

                //le pari est du capitaine est égale, l'équipe du capitaine defend et le score a été entré
                elseif ($bets[1][2]==$bets[0][2] && $Matchs[0][4]!=0){?>
                    <p>le capitaine a entré qu'il a <?php if($Matchs[0][4]==1){echo "gagné";} else{echo "perdu";}?> en <?php echo $Matchs[0][11]; ?> coups de déchole</p>
                    <button onclick="window.location.href='../Capitain/EntrerScore.php'" id="entrerScore">confirmation</button>
                    <?php
                }

            }
        }
    }
    $results = $user->getMatchs($bdd);
    if ($_SESSION['isPlayer']!=1){
        $resultats=$user->viewMatch($bdd);
        foreach ($resultats as $res){

            if($res[4]==0){

        ?>
                <h1>Match: <?php echo $res[1]; ?> - <?php echo $res[2]; ?> Parcours: <?php echo $res[6]; ?>à jouer</h1>

    <?php }
            else{
                if($res[4]==1){
                    ?>

                                <h1>Le match <?php echo $res[1]; ?> contre <?php echo $res[2]; ?> sur le parcour <?php echo $res[6]; ?> a été joué<br>L'equipe qui été en attaque a gagné avec <?php echo $res[5]; ?> décholes</h1>
            <?php } else if ($res[4]==2){?>
                    <h1>Le match <?php echo $res[1]; ?> contre <?php echo $res[2]; ?> sur le parcour <?php echo $res[6]; ?> a été joué<br>L'equipe qui été en défence a gagné </h1>
                <?php }
            }
        }
    }

        ?>

        <button id="matchs" onclick="window.location.href='../AdminViews/viewRunMatch.php'">Rencontres</button>
        <?php

    ?>
    </body>
    <button id="return" onclick="window.location.href='../../Controller/Connect/CheckConnect.php'">Retour</button>
    </html>
    <?php
} else {
    header('location: ../Guest_Home.html');
}