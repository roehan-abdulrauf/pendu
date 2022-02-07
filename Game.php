<?php

class Pendu
{
    public $play;

    // Affiche la page d'accueil
    public function Index()
    {

        if (!empty($_SESSION['victoires'])) {

?>
            <div class='textalign paddingtop15'>
                <?php
                echo "<p class='fontsize-rem1'> Bon retour parmis sur le jeu du Pendu, <br> continuer votre ascenssion ou débuter une autre partie </p>";
                echo "<a class='new-coontinuerP continuerPos' href='index.php?etat=play'>Continuer</a></p>";
                echo "<p class='new-coontinuerP nouvellePos'><a href='Newgame.php'>Nouvelle partie</a></p>";
                ?>
            </div>
        <?php
        } else {
        ?>
            <div class='textalign paddingtop15'>
                <?php
                echo "<p class='fontsize-rem1'> Bienvenue sur le jeu du Pendu, commencer une partie</p>";
                echo "<a class='new-coontinuerP nouvellePos2' href='Newgame.php'>Nouvelle partie</a>";
                ?>
            </div>
<?php
        }
    }

    // Permet de prendre un mot au hasard dans le fichier mots.txt
    public function choseWord($fichier)
    {

        if (!isset($_SESSION["word"])) {
            $_SESSION["word"] = rtrim($fichier[array_rand($fichier)]);
        }
    }

    // Remplace les characteres speciaux par des normaux
    public function normalCharacter($mot)
    {

        $delete = ['À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'];
        $replace = ['A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y'];

        $newWord = str_replace($delete, $replace, $mot);
        return strtoupper($newWord);
    }


    public function partieGagne($mot)
    {
        echo " <div class='textalign paddingtop15 fontsize-rem2'>
        <p> Gagné vous avez réussi à trouver le mot <br></p>
        <p class=' motcorrect'> $mot</p>  <a class='new-coontinuerP recommencerPos' href='recommencer.php'>Nouveau Mot</a>
        </div>";
        $_SESSION['victoires']++;
        echo $_SESSION['victoires'];
        exit();
    }

    public function partiePerdue($mot)
    {
        echo " <div class='textalign paddingtop15 fontsize-rem2'>
        <p>Perdu le mot était <br></p>
        <p class=' motcorrect'> $mot </p>  <a class='new-coontinuerP recommencerPos' href='recommencer.php'>Recommencer</a>
        </div>";
        exit();
    }

    public function Affichage($lettres)
    {

        for ($i = 0; isset($lettres[$i]); $i++) {

            if (!empty($this->play) && in_array($lettres[$i], $this->play)) {

                echo "";
            } else {

                echo '<input type="submit" name="lettres" value="' . $lettres[$i] . '">';
            }
        }
    }

    // Je stocke les lettres jouées dans une variable de session
    public function lettresJouees()
    {

        $lettresJouees = $_POST['lettres'];
        $_SESSION['played'][] = $lettresJouees;
    }


    public function mauvaisesLettres($mot)
    {

        $played = $_SESSION['played'];
        $this->play = $played;
        for ($i = 0; isset($played[$i]); $i++) {

            if (!in_array($played[$i], str_split($mot))) { /*str_plit Transforme mon mot en tableau */

                $_SESSION['false']++;
            }
        }
    }


    public function bonnesLettres($mot)
    {
        for ($j = 0; isset($mot[$j]); $j++) {

            if (!empty($this->play) && in_array($mot[$j], $this->play)) {

                $_SESSION['true']++;
                echo $mot[$j];
            } else {
                echo " _ ";
            }
        }
    }
}
