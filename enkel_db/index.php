<?php
/**
 * PROV PHP
 * User: Vincent Grenfeldt
 *
 */
session_start();
if(!isset($_SESSION['admin'])||isset($_POST['adminOut'])){
	$_SESSION['admin'] = false;
}
if(isset($_POST['admin'])){
	$_SESSION['admin'] = true;
}
//global innehåller länkar till css och js
include "global.php";
echo "<div class='top-info'>";//snygga error meddelanden
//här kontaktar vi databasen
include "db_connect.php";
try{
	$typer = "CREATE TABLE IF NOT EXISTS typer(id INTEGER PRIMARY KEY, typnamn TEXT)";
	$db->exec($typer);
	$link = "CREATE TABLE IF NOT EXISTS links(id INTEGER PRIMARY KEY,namn TEXT, link TEXT,typ INTEGER)";
	$db->exec($link);
}
catch (PDOException $e){
	echo "fel vid skapning av table: ".$e->getMessage();
}
/*-----------------------------------------------------------------------------------------------------------
REGSORT sorterar och hämtar från databas
-----------------------------------------------------------------------------------------------------------*/
function regsort($name,$order){
	try {
		global $db;
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //
		$arr = [];
		$res = $db ->query("SELECT * FROM $name ORDER BY $order"); //returnerar tabellerna $res = resarset pdo tables  query skickar en förfrågan till databasen
		while($r = $res->fetch(PDO::FETCH_ASSOC)){
			$arr[] = $r;
		}
		return $arr;
	}
	catch (PDOException $e){
		echo "fel vid hämtning: ".$e->getMessage();
	}
}

echo "</div>";
?>
	<body>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-12" id = "top">
				<h1>Relationsdatabaser(PHP fil)</h1>
				<?php
				if($_SESSION['admin']){ //ifall du är inloggad, ta fram utloggnings knapp
				?>
					<form action="?" method="post">
						<input type="submit" value="Log out" name="adminOut" class="btn btn-default">
					</form>
					<?php
				}else { //annars ta fram inloggningsknapp
					?>
					<form action="?" method="post">
						<input type="submit" value="Log in as Admin" name="admin" class="btn btn-default">
					</form>
					<?php
				}?>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-12" id = "form">
			<br><br>
				<div class ="row">
					<div class ="col-md-12">
						<h1>Sök i kategorier</h1>
						<script>
							var response;
							function laddaFiler(value){
								//skapar ajax object
								var ajax;
								//Kollar IE6 eller IE5
								if(window.XMLHttpRequest){
									ajax = new XMLHttpRequest();
								}else{
									ajax = new ActiveXObject("Microsoft.XMLHTTP");
								}
								//när ajax är redo.
								ajax.onreadystatechange = function(){
									if (ajax.readyState == 4 && ajax.status == 200) {
									}else{
										document.getElementById("joinedTable").innerHTML = ajax.responseText;
										response = ajax.responseText;
									}
								}
								ajax.open("GET","getType.php?linkType="+value,true);
								ajax.send();
							}
						</script>
						<div class = "form-group">
							<select name = "selectTyp" class = "form-control" id ="selectType" onchange ="laddaFiler(this.value)">
								<option value = "null">Select a filetype</option>
								<?php
								$typer = regsort("typer","id");
								foreach($typer as $r){
									echo "<option value = '".$r['id']."'>";
									echo $r['typnamn'];
									echo "</option>";
								}
								?>
							</select>
						</div>
						<div id ="joinedTable">
						</div>
					</div>
				</div>
				<?php
				if($_SESSION['admin']){ //ifall admin är inloggad
				include_once "admin.php";
				}
				?>
			</div>
		</div>
	</div>
	</body>