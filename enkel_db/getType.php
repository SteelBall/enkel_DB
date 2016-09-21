<?php
/*-------------------------------------------------------------------------
Filen laddar data n�r man selectar typ av bok
---------------------------------------------------------------------------*/
include "db_connect.php";
include "global.php";
if(isset($_GET['linkType'])){
    $q = $_GET['linkType'];
}
try{
    $select = " SELECT links.namn, links.link, typer.typnamn,links.id
											FROM links
											INNER JOIN typer
											ON links.typ=typer.id
											WHERE typer.id = '$q';";
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //
    $joined = [];
    $res = $db ->query($select); //returnerar tabellerna $res = resarset pdo tables  query skickar en f�rfr�gan till databasen
    while($r = $res->fetch(PDO::FETCH_ASSOC)){
        $joined[] = $r;
    }

}
catch (PDOException $e){
    echo "fel vid h�mtning: ".$e->getMessage();
}
echo <<<TABLE
                        <table class = "table table-striped">
							<tr>
								<th>namn</th><th>link-url</th><th>typ</th>
							</tr>
TABLE;

foreach($joined as $r){
    echo "<tr>";
    //echo "<td>".$r['id']."</td>";
    echo "<td>".$r['namn']."</td>";
    echo "<td>".$r['link']."</td>";
    echo "<td>".$r['typnamn']."</td>";
    echo "</tr>";
}
echo "</table>";
?>