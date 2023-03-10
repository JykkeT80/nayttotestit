<?php

//haetaan data lomakkeelt
$liikevaihto = $_POST['liikevaihto'];
$materiaalit = $_POST['materiaalit'];
$henkilöstö = $_POST['henkilöstö'];
$poistot = $_POST['poistot'];
$muutkulut = $_POST['muutkulut'];
$rahoitus = $_POST['rahoitus'];
$verot = $_POST['verot'];
$kokonaismäärä = $_POST['osakemäärä'];
$osakehinta = $_POST['osakehinta'];
$sijoitus = $_POST['sijoitus'];

$dsn = "pgsql:host=localhost;dbname=jniemine"; #mikä tietokanta, missä sijaitsee, tk nimi
$user ="db_jniemine";  #käyttäjätunnus
$pass = getenv("DB_PASSWORD");#Oephadiahazoo6Ohthu); #salasana
$options = [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];# nostaa poikkeuksen virhetilanteessa.
    #PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC, #miten muodossa rivin tiedot haetaan -taulukko
    # PDO::ATTR_EMULATE_PREPARES => false,]; #emuloiko pdo esikäsiteltyjä kyselyitä niillä 
    #tietokannoilla joita ei luonnostaan tue. false määrittää käyttämään MySql tietokanta-ajurin toiminnallisuutta

try {
    $yht = new PDO($dsn, $user, $pass, $options); #luodaan PDO-olio??
    if (!$yht) {die();} #jos ei ole yht, niin lopeta

    if (!empty($liikevaihto) and !empty($materiaalit) and !empty($henkilöstö) and !empty($poistot) and !empty($muutkulut) and 
        !empty($rahoitus) and !empty($verot) and !empty($kokonaismäärä) and !empty($osakehinta) and !empty($sijoitus))   #tyhjää ei lisätä 
    { 
        $ins = "insert into vieras "; #lisätään lomakkeella oleva message vieraskirjan loppuun
        $ins .= "values (default, ?, ?, now(), now())";

        // valmistellaan sql-lause suoritusta vartenn
        $lause = $yht->prepare($ins);

        $lause ->bindValue(1, $liikevaihto);
        $lause ->bindValue(2, $materiaalit);
        $lause ->bindValue(3, $henkilöstö);
        $lause ->bindValue(4, $poistot);
        $lause ->bindValue(5, $muutkulut);
        $lause ->bindValue(6, $rahoitus);
        $lause ->bindValue(7, $verot);
        $lause ->bindValue(8, $kokonaismäärä);
        $lause ->bindValue(9, $osakehinta);
        $lause ->bindValue(10, $sijoitus);

        //suorita lisäys
        $ret = $lause->execute();

        //tyhjennetään muuttujan jottei F5 lisää samaa tekstiä uuudelleen ja uuudelleene
        // fiksumpi tapa tehdä $_SESSION - tämä asia tulee myöhemmin
       /*
       
        unset($mess);
        unset($kirj);
        unset($_POST);
        unset($_REQUEST);
        header ("Location: index.php");

        */

        unset($liikevaihto);
        unset($materiaalit);
        unset($henkilöstö);
        unset($poistot);
        unset($muutkulut);
        unset($rahoitus);
        unset($verot);
        unset($kokonaismäärä);
        unset($osakehinta);
        unset($sijoitus);
        unset($_POST);
        unset($_REQUEST);
        header ("Location: index.php");
    }

}catch(PDOException $e) {
    echo $e->getMessage();
    die();
}
        
        

?>