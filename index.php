<?php

$liikevaihto = $_POST['liikevaihto'];
$materiaalit = $_POST['materiaalit'];
$henkilosto = $_POST['henkilosto'];
$poistot = $_POST['poistot'];
$muutkulut = $_POST['muutkulut'];
$rahoitus = $_POST['rahoitus'];
$verot = $_POST['verot'];
$osakkeidenMaara = $_POST['osakemaara'];
$osakehinta = $_POST['osakehinta'];
$sijoitus = $_POST['sijoitus'];

function liikevoitto($l, $ma, $h, $mk, $p) {
    return $l-$ma-$h-$mk-$p;
}
$liikevoitto = liikevoitto($liikevaihto, $materiaalit, $henkilosto, $muutkulut, $poistot);

function voittoEnnenVeroja ($lv, $r) {
    return $lv-$r;
}
$voittoEnnenVeroja = voittoEnnenVeroja($liikevoitto, $rahoitus);

function tilikaudenVoitto ($vev, $ve) {
    return $vev-$ve;
}
$tilikaudenVoitto = tilikaudenVoitto ($voittoEnnenVeroja, $verot);

function osaketuotto($tkv, $om) {
    return $tkv/$om;
}
$osaketuotto = osaketuotto($tilikaudenVoitto, $osakkeidenMaara);
#$osaketuotto = ROUND(osaketuotto($tilikaudenVoitto, $osakkeidenMaara), 2);

function osakkeetAlussa($si, $oh) {
    return $si/$oh;
}
$osakkeetAlussa = osakkeetAlussa($sijoitus, $osakehinta);

function sipo ($ostu, $osal, $si) {
    return array($ostu * $osal, (($ostu * $osal)/$si)*100); 
}
$tulos = sipo($osaketuotto, $osakkeetAlussa, $sijoitus);
$tuotto€ = $tulos[0];
$tuottoPros= $tulos[1];

function tuottoVuosittain ($t€, $oh ) {
    return $t€/$oh;
}
$uudetOsakkeet = tuottoVuosittain($tuotto€, $osakehinta);

function yhteismaara ($osal, $uudos) {
    return $osal + $uudos;
}
$yhtmaara = yhteismaara($osakkeetAlussa, $uudetOsakkeet);

echo "TIEDOT OSAKKEISTA"; 
echo "<br>";
echo "Osakkeiden kokonaismäärä  $osakkeidenMaara";
echo "<br>";
echo "Osakkeen hinta $osakehinta";
echo "<br>";
echo "Osaketuotto $osaketuotto";
echo "<br>";

echo "SIJOITUSLASKURI"; 
echo "<br>";
echo "Sijoitettava summa $sijoitus";
echo "<br>";
echo "Sijoituksella saadut osakkeet $osakkeetAlussa";
echo "<br>";

echo "SIJOITETUN PÄÄOMAN TUOTTO"; 
echo "<br>";
echo "Tuotto $tulos[0]";
echo "<br>";
echo "Tuotto suhteessa sijoitukseen $tulos[1]";
echo "<br>";

echo "<table>";
echo "<tr>";
echo "<th></th>";
for ($i=2; $i<6; $i++) {
    echo "<th>$i. vuosi</th>"; 
}
echo "</tr>";

$maara = array();
$euro = array();
$pros= array();
echo "<tr>";
echo "<td>Edellisen vuoden tuotolla hankitut osakkeet (kpl)</td>";
for ($i=0; $i<4; $i++) {
    array_push($maara, ROUND($uudetOsakkeet,2));
    echo "<td>$maara[$i]</td>";
    $tulos = sipo($osaketuotto, $yhtmaara, $sijoitus);
    array_push($euro, ROUND($tulos[0],2));   #sipo euromääräinen tuotto   
    array_push($pros, ROUND($tulos[1],2));   #sipo prossat
    $uudetOsakkeet = tuottoVuosittain($tulos[0], $osakehinta); 
    $yhtmaara += $uudetOsakkeet;
}
"</tr>";

echo "<tr>";
echo "<td>Osakkeiden yhteismäärä (kpl)</td>"; 
$yht = $osakkeetAlussa;
for ($i=0; $i<4; $i++) {
    $yht += $maara[$i];
    echo "<td>$yht</td>";
}
echo "</tr>";

echo "<tr>";
echo "<td>Tuotto (€)</td>";
for ($i=0; $i<4; $i++) {
    echo "<td>$euro[$i]</td>";
}
echo "</tr>";

echo "<tr>";
echo "<td>Tuotto suhteessa alkusijoitukseen (%)</td>";
for ($i=0; $i<4; $i++) {
    echo "<td>$pros[$i]</td>";
}
echo "</tr>";
echo "</table>";


/*
echo "Edellisen vuoden tuotolla hankitut osakkeet (kpl)" . " " . $hankitutOsakkeet = ROUND(tuottoVuosittain($tuotto€, $osakehinta),2);
echo "<br>";
echo "Osakkeiden yhteismäärä (kpl)" . " " . $osakkeetYht = $saadutOsakkeet + $hankitutOsakkeet;
echo "<br>";
#$tulos = sipo($osaketuotto, $osakkeetYht, $sijoitus);
echo "<br>";
#$t€ = sipo($osaketuotto, $osakkeetYht, $sijoitus);
echo "Tuotto (€)" . " " . $tuotto€;
echo "<br>";
echo "Tuotto suhteessa alkusijoitukseen" . " " . $tuottoPros . "%";
echo "<br>";


echo "<table>";
echo "<tr>";
echo "<th></th>";
echo "<th>2. vuosi</th>";  #myös $i. . " " . vuosi
echo "<th>3. vuosi</th>";
echo "<th>4. vuosi</th>";
echo "<th>5. vuosi</th>";
echo "</tr>";
echo "<hr>";

echo "<tr>";
echo "<td>Edellisen vuoden tuotolla hankitut osakkeet (kpl)</td>";
echo "<td>$hankitutOsakkeet</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Osakkeiden yhteismäärä (kpl)</td>"; 
echo "<td>$osakkeetYht</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Tuotto (€)</td>";
echo "<td>$tuotto€</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Tuotto suhteessa alkusijoitukseen (%)</td>";
echo "<td>$tuottoPros</td>";
echo "</tr>";
echo "</table>";
*/

/*
echo "Liikevoitto (-tappio): " . $liikevoitto = liikevoitto($liikevaihto, $materiaalit, $henkilosto, $muutkulut, $poistot);
echo "<br>";

echo "Voitto (tappio) ennen tilinpäätössiirtoja ja veroja: " . $voittoEnnenVeroja = voittoEnnenVeroja($liikevoitto, $rahoitus);
echo "<br>";

echo "Tilikauden voitto (tappio): " . $tilikaudenVoitto = tilikaudenVoitto ($voittoEnnenVeroja, $verot);
echo "<br>";

echo "Osaketuotto: " . $osaketuotto = ROUND(osaketuotto($tilikaudenVoitto, $osakkeidenMaara), 2);
echo "<br>";

echo "Sijoituksella saadut osakkeet: " . $saadutOsakkeet = saadutOsakkeet($sijoitus, $osakehinta);
echo "<br>";

echo "Tuotto: " . $tuotto€ = ROUND($tulos[0], 2);
echo "<br>";
echo "Tuotto suhteessa sijoitukseen: " . $tuottoPros= ROUND($tulos[1], 2) . "%";
echo "<br>";




*/
?>

