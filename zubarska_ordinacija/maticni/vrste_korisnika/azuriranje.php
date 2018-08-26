<?php
include_once "../../inc/header.php";
require '../../inc/konekcija.php';
session_start();
autentifikacija($_SESSION);
?>
			<a href="pregled.php" class="nazad"><img src="../../img/back.jpg" width=30 height=30> </a>
	<?php
		if($_REQUEST['akcija'] == 'n'){
	?>
			</header>
			<main>
				<form name="unos" action="" method="post">
					<table class="tabelaUnos" align="center"  border="1">
						<caption>UNOS NOVE VRSTE KORISNIKA</caption>
						<tr>
							<td>Vrsta: </td>
							<td><input type="text" required name="naziv" value=<?php echo (isset($_REQUEST['naziv']))?$_REQUEST['naziv']:"";?>></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" name="snimi" value="Snimi novu vrstu korisnika u bazu"></td>
						</tr>
					</table>
					<input type="hidden" name="akcija" value="n">
				</form>
			</main>	
	<?php
			if(isset($_REQUEST['snimi'])){
				$naziv = validacijaPodatka($_REQUEST['naziv']);
				$sqlQuery = "INSERT INTO vrsta_korisnika VALUES (null, '$naziv')";
				$res = mysqli_query($conn, $sqlQuery);
				if(!$res)
					greska("Vrsta korisnika nije upisana u bazu! <br> opis: ".mysqli_error($conn));
				else
					header("Location: pregled.php");	
			}
		}
		else if($_REQUEST['akcija'] == 'b'){
			if(is_numeric($_REQUEST['id']) && $_REQUEST['id']>0){
				
				$sqlQuery = "DELETE FROM vrsta_korisnika WHERE id=".$_REQUEST['id'];
				$res = mysqli_query($conn, $sqlQuery);
				if(!$res)
					greska("Vrsta korisnika nije obrisana! <br> opis: ".mysqli_error($conn));
				else
					header("Location: pregled.php");	
			}
			else{
				greska("Nije korektan id vrste korisnika!");
			}
			
		}
		else if($_REQUEST['akcija'] == 'i'){
			if(is_numeric($_REQUEST['id']) && $_REQUEST['id']>0){
				$sqlQuery = "SELECT * FROM vrsta_korisnika WHERE id=".$_REQUEST['id'];
				$res = mysqli_query($conn, $sqlQuery);
				while($row = mysqli_fetch_assoc($res)){	
	?>
			</header>
			<main>
				<form name="unos" action="" method="post">
					<table class="tabelaUnos" align="center">
						<caption>IZMENA VRSTE KORISNIKA</caption>
						<tr>
							<td>Vrsta: </td>
							<td><input type="text" required name="naziv" value="<?=$row['naziv'];?>"></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" name="snimi" value="Snimi izmenu korisnika u bazu"></td>
						</tr>
					</table>
					<input type="hidden" name="akcija" value="i">
					<input type="hidden" name="id" value="<?=$row['id'];?>">
				</form>
			</main>	
		</body>
		</html>
	<?php
		}
			if(isset($_REQUEST['snimi'])){
				$naziv = validacijaPodatka($_REQUEST['naziv']);
						
				$sqlQuery = "UPDATE vrsta_korisnika SET naziv='$naziv' WHERE id=".$_REQUEST['id'];
				$res = mysqli_query($conn, $sqlQuery);
				if(!$res)
					greska("Vrsta korisnika nije izmenjena! <br> opis: ".mysqli_error($conn));
				else
					header("Location: pregled.php");	
			}		
		}
		else{
			greska("Nije korektan id vrste korisnika!");
		}
	}
	else{
		greska("Ne prepoznajemo akciju");
	}
?>