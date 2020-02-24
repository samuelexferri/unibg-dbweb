<?php
	session_start();
	$ruolo_login = $_SESSION["role"];
?>
		
<html>
	<head>
		<title>Miele in vendita</title>
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>

		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	
	<body>
		<!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="js/materialize.js"></script>
	
		<header>
			<?php 
				include 'menu.php';
			?>
		</header>
		<main>
			<div class="section no-pad-bot" id="index-banner">
				<div class="container">
					<h1 class='header orange-text'>Miele in vendita</h1>	
					
					<?php
						$nomeDB ="localhost";
						$user = "beekeeperunibg";
						$psw = "";
						$database = "my_beekeeperunibg";
						
						$con = mysqli_connect($nomeDB,$user,$psw,$database);
						if(!$con) die ("Errore di connessione");
						else
						{
							$usrname = $_SESSION["login_user"];
							
							// Recuperare tutti i tipi di miele venduti
							$sql = "
							SELECT m.id_miele, t.nome_miele, m.disponibilita, m.costo_kg 
							FROM miele AS m 
							INNER JOIN users AS u 
							ON m.id_venditore = u.id_user 
							INNER JOIN tipo_miele AS t 
							ON m.id_tipo_miele = t.id_tipo_miele 
							WHERE user = '$usrname'";
							$query =mysqli_query($con, $sql);
							
							echo "<table border='1' class='striped'>";
							
							// Intestazione tabella
							echo "<tr>";
								echo "<th>Tipo di miele</th>";
								echo "<th>Disponibilità (kg)</th>";
								echo "<th>Costo al kg</th>";
								echo "<th>Modifica</th>";
								echo "<th>Elimina</th>";
							echo "</tr>";
							
							while ($row = mysqli_fetch_assoc($query)) 
							{
								$id_miele = $row['id_miele'];
								echo "<tr>";
									echo "<td>".$row['nome_miele']."</td>";
									echo "<td>".$row['disponibilita']."</td>";
									echo "<td>".$row['costo_kg']."</td>";
									echo "<td>
											<form action='miele_mod.php' method='get'>
												<input type='hidden' name='id_miele' value='$id_miele'>
												<button class='btn waves-effect waves-light' type='submit' name='action'>Modifica</button>
											</form>
										</td>";
									echo "<td>
											<form action='del_miele.php' method='get'>
												<input type='hidden' name='id_miele' value='$id_miele'>
												<button class='btn waves-effect waves-light' type='submit' name='action'>Rimuovi</button>
											</form>
										</td>";	
								echo "</tr>";
							}
							echo '</table>';
							
							echo "<br><br>
							<form method='get' action = 'new_miele.php'>
								<button class='btn-large waves-effect waves-light orange' type='submit' name='action'>Aggiungi miele</button>
							</form>";
							echo '<br><br><a href="/site/home.php"class="btn-large waves-effect waves-light orange">Torna alla home</a><br><br><br>';
							mysqli_close($con);
						}
					?>
						
					<h5 class='header col s12 light'></h5>
					
				</div>
			</div>
		</main>
		<footer class="page-footer">
            <div class="container grey-text text-darken-4">
				Beekeeper Unibg
            </div>
        </footer>
	</body>
</html>