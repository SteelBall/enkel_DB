<?php
				/*-----------------------------------------------------------------------------------------------------------
				Hanterar delete av länkar
				-----------------------------------------------------------------------------------------------------------*/
				if(isset($_POST['typdel'])){//deleta typer
					try{
						$delete = "DELETE FROM typer WHERE id='".$_POST['id']."'";
						$db->exec($delete);
						header("Location: {$_SERVER['PHP_SELF']}");
						exit();
					}
					catch (PDOException $e){
						echo "fel vid delete: ".$e->getMessage();
					}
				}
				if(isset($_POST['linksdel'])){ //Delete links
					try{
						$delete = "DELETE FROM links WHERE id='".$_POST['id']."'";
						$db->exec($delete);
						header("Location: {$_SERVER['PHP_SELF']}");
						exit();
					}
					catch (PDOException $e){
						echo "fel vid delete: ".$e->getMessage();
					}
				}
				/*-----------------------------------------------------------------------------------------------------------
				Hanterar inmatning
				-----------------------------------------------------------------------------------------------------------*/
				echo "<div class ='top-info'>";
				if(!isset($_SESSION['linkerror'])){
					$_SESSION['linkerror'] = null;
				}
				if($_SESSION['linkerror']){
					echo "Given link is invalid: '".$_SESSION['linkerror']."'";
				}
				echo "</div>";
				if(isset($_POST['add'])){
					$link = $_POST['link'];
					$namn = filter_input(INPUT_POST,"namn",FILTER_SANITIZE_STRING);
					$valType = $_POST['valType'];
					for($i = 0; $i < count($link);$i++){
						if(preg_match("/\s/i",$_POST['type'])){//kollar efter whitespace då det inte får finnas i ett filnamn
							//felhantering
							if(!isset($_SESSION['linkerror'])){
								$_SESSION['linkerror'] = $_POST['type'];
							}else{
								$_SESSION['linkerror'] = $_POST['type'];
							}
							break;
						}
						else{
							$_SESSION['linkerror'] = null;
							try{
								$insert = "INSERT INTO links(namn,link,typ) VALUES(:namn, :link,:typ)"; //:namn = placeholder,
								$st = $db->prepare($insert);
								//kollar ifall länk är en länk
								$st->bindValue(':namn',$namn);
								$st->bindValue(':link',$link);
								$st->bindValue(':typ',$valType);
							}
							catch(PDOException $e){
								echo "fel vid insättning".$e->getMessage();
							}
							$st->execute();
							header("LOCATION: {$_SERVER['PHP_SELF']}");
							exit();
						}
					}
					header("LOCATION: {$_SERVER['PHP_SELF']}");
				}
				if(isset($_POST['newtype'])){
					$new_type = $_POST['type'];
					for($i = 0; $i < count($link);$i++){
						if(preg_match("/\s/i",$_POST['type'])){//kollar efter whitespace då det inte får finnas i ett filnamn
							//felhantering
							if(!isset($_SESSION['linkerror'])){
								$_SESSION['linkerror'] = $_POST['type'];
							}else{
								$_SESSION['linkerror'] = $_POST['type'];
							}
							break;
						}
						else{
							$insert = "INSERT INTO typer(typnamn) VALUES('$new_type')";//behöver ingen prepare för att det är så lite information
							$db->exec($insert);
							header("LOCATION: {$_SERVER['PHP_SELF']}");
						}
					}
				}
				?>
				<div class ="row">
					<div class ="col-md-6">
						<h2>Lägg till kategori</h2>
						<form action = "?" method="post" role = "form">
							<div class ="form-group">
								<input type="text" name = "type" placeholder="skriv in ny kategori" class = "form-control" required>
							</div>
							<div class ="form-group">
								<input type ="submit" name ="newtype" value="add new type" class = "btn btn-default">
							</div>
						</form>
						<br>
						<br>
						<br>
							<h2>Kategorier som finns</h2>
						<table class="table table-striped">
							<tr>
								<th>id</th><th>namn</th><th>Tag bort</th>
							</tr>
							<?php
							$typer = regsort("typer","id");
							foreach($typer as $r){
								echo "<tr>";
								echo "<td>".$r['id']."</td>";
								echo "<td>".$r['typnamn']."</td>";
								echo "<td>".delete($r['id'],"typ")."</td>";
								echo "</tr>";
							}
							?>
						</table>
					</div>
					<div class ="col-md-6">
						<h2>Lägg till Länk</h2>
						<form action = "?" method = "post" role = "form">
							<div class = "form-group">
								<input type = "text" name = "namn" placeholder = "input name" class = "form-control" required></input>
								<input type = "text" name = "link" placeholder = "input link" class = "form-control" required></input>
								<select name="valType" class="form-control">
									<?php
									$types = regsort("typer","id");
									foreach($types as $r){
										echo "
										<option value = '".$r['id']."'>".$r['typnamn']."</option>
										";
									}
									?>
								</select>
							</div>
							<div class = "form-group">
								<input type = "submit" value = "add" name = "add" class = "btn btn-default" id = "submit"></input>
							</div>
						</form>
						<hr>
						<h2>Länkar som finns</h2>
						<table class="table table-striped">
							<tr>
								<th>id</th><th>namn</th><th>link url</th><th>typ_id</th><th>Tag bort</th>
							</tr>
							<?php
							$links = regsort("links","id");
							foreach($links as $r){
								echo "<tr>";
								echo "<td>".$r['id']."</td>";
								echo "<td>".$r['namn']."</td>";
								echo "<td>".$r['link']."</td>";
								echo "<td>".$r['typ']."</td>";
								echo "<td>".delete($r['id'],"links")."</td>";
								echo "</tr>";
							}
							?>
						</table>
					</div>
				</div>