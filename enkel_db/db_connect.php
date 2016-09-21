<?php
//filen hanterar bara databas kontakt
try {
    $db = new PDO('sqlite:links.db'); //skapar nytt objekt f�r databasen och pdo, om inte links.db existerar skapar den  en databas f�r links
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //error mode
}
catch(PDOException $e){
    echo "fel vid kontakt av database ".$e->getMessage();
    exit;
}


?>

