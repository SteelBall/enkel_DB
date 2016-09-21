<?php
/**
 * Created by PhpStorm.
 * User: Vinne
 * Date: 2016-05-05
 * Time: 23:38
 *
 *
 * Filen innehåller funktioner och länkar till bibliotek/css
 */
function delete($id,$name=null){//$name är optional
    echo "<td>
		<form action='' method='POST'>
			<input type ='hidden' value ='$id' name='id'>
			<input type ='submit' name='".$name."del' value = 'tag bort' class='btn btn-default'>
		</form>
		</td>";
}
?>
<!DOCTYPE html>
<head>
    <title>relationsdatabaser</title>
    <meta charset= "utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type = "text/css" href = "custom.css">
</head>

