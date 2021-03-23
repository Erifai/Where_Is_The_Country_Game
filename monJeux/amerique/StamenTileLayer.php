<?php
include_once('amerique.php');
$rows = mysqli_fetch_assoc($result);
$score = (isset($_GET['sc']) ? intval($_GET['sc']) : 0);
?>
<script>
if(<?php  echo json_encode($score);?> == 0 ) 
	{localStorage.setItem("score",0); //remise à zero du score quand c'est une nouvelle partie
	var Monscore =0;}
</script>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Leaflet.js avec couche Stamen Watercolor</title>
		<meta charset="utf-8" />
	
     <link rel="stylesheet" href="../../css/style.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<script src="http://code.jquery.com/jquery-1.11.2.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/mvc/3.0/jquery.unobtrusive-ajax.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="../countries.js"></script>
	<script src="../countries.geoJson"></script>




	</head>
	<body>
		<div id="maDiv" style="width: 1200px; height: 450px; display: block; margin-left: auto; margin-right: auto; position: absolute; transform: translate(-50%, -50%);top: 50%; left: 50%"></div>

		        <a href="../../profil.php" >
                  <img id ="monlogo" src="../../images/logo3.png" alt="Image" class="img-fluid">
				</a>
				
            <div>
			<div id="scores"><h2>Ton score est a :</h2></div>
			<div class="p-2 "><span id="compteur" ></span></div>
			</div>
			<h1 id="bravo"></h1>	
			<div id="question_flag"><h2>Ce drapeau fait référence a quel pays ?</h2></div>	
			<img id="img_flag" src="<?php echo  $rows['Flag'];?>"  alt="Image" class="img-fluid"/>
			<div><input type="button" id="rejouer" value="Rejouer" onclick="myFunction()":/></div>
			<div><input type="button" id="quitter" value="Quitter" onclick="myFunctionQ()": style="top :450px;" /></div>
			<div><input type="button" id="question_suivante" value="Question suivante" onclick="myFunctionS()"/></div>	
			
			<form   action="StamenTileLayer.php" method="post">
		    <script>   
			 var variable = sessionStorage.getItem ("variable");
			 var id_pays = sessionStorage.getItem("idPays");
		
                        
				<?php 	 if ($id_pays > 15 )  // fin de la partie
						 { 
		                    $id_pays=9	; ?>
				            MonScore=0;
				            localStorage.setItem("score",MonScore);
							$("#img_flag").hide();
		                    $("#question_flag").hide();
		                    $("#compteur").hide();
						    $("#rejouer").show();
							$("#monlogo").hide();
					<?php	// si le joueur à jamais jouer on stocke son score s'il a deja joué on compare son score actuel avec celui de la base si le score actuel est le plus grand on mettre à jour le record
					$getid = $_SESSION['id'];
					$query1 =$bdd->prepare('SELECT * FROM parties where id= ?') ; 
					$query1-> execute(array($getid));
					$userexist = $query1->rowCount();
					if($userexist == 1)
						   {
							  $userinfo = $query1->fetch();
							  if($userinfo['score_max'] < $score )
								  {   
									$query0 =$bdd->prepare("DELETE from parties where id = ? ");
									$query0->execute(array($getid));
									$query2 =$bdd->prepare("INSERT INTO parties(id,score_max) VALUES(?, ?) "); // mise à jour de la base
									$query2->execute(array($getid, $score));

								  }
						}
						else
						{
							$query2 =$bdd->prepare("INSERT INTO parties(id,score_max) VALUES(?, ?) ;"); // insertion (premiere partie)
							$query2->execute(array($getid, $score));
						}
						$score = 0;  } 
						  else {	 ?>
							   $("#img_flag").show();
							   $("#question_flag").show();
							   $("#compteur").show(); 
							   $("#rejouer").hide(); 
							   $("#monlogo").hide();
					<?php  
							}
						
						$nom = $rows['Nom_pays'];
						$surface = $rows['Surface'];
						$var =  $rows['Reference'];
						$continent = $rows['Nom_continent'];
						$id = $rows['id_pays'];
						$langue = $rows['Langue']; 
						$lien = $rows['Lien']; 
						$img = $rows['Img'];
            	 	
				?>		
			</script>	
			</from>		
										 
		 </div>
	  				
		<script>
			 var index=0;
			 var click = 0;
			 var reponse;
			 var MonScore = 0;
			 MonScore = parseFloat(localStorage.getItem("score"));
			 var p;
			 var id=2;
			 var bonneReponse = 0;
			 var test = 1;
			 $("#question_suivante").hide();
			 $("#scores").hide();
			 
			// bornes pour empecher la carte StamenWatercolor de "dériver" trop loin...
			var northWest = L.latLng(90, -180);
			var southEast = L.latLng(-90, 180);
			var bornes = L.latLngBounds(northWest, southEast);
			// Initialisation de la couche StamenWatercolor
			
			var coucheStamenWatercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
				attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
				subdomains: 'abcd',
				ext: 'jpg'
			});
			// Initialisation de la carte et association avec la div
			var map = new L.Map('maDiv', {
				center: [17.03433647882419, -95.58521598519208],
				minZoom: 2,
				maxZoom: 18,
				zoom: 3,  
				maxBounds: bornes,	
			});
			//var map = L.map('maDiv').setView([48.858376, 2.294442],5);
			// Affichage de la carte
			map.addLayer(coucheStamenWatercolor);
			// Juste pour changer la forme du curseur par défaut de la souris
			document.getElementById('maDiv').style.cursor = 'crosshair'
			//map.fitBounds(bornes);
			// Initilisation d'un popup
			var popup = L.popup();
			// Fonction de conversion au format GeoJSON
			function coordGeoJSON(latlng,precision) { 
				return '[' +
				L.Util.formatNum(latlng.lng, precision) + ',' +
				L.Util.formatNum(latlng.lat, precision) + ']';
			}
			// Fonction qui réagit au clic sur la carte (e contiendra les données liées au clic)
			function onMapClick(e) {
				popup.setLatLng(e.latlng)
				.setContent("Hello click détecté sur la carte !<br/> " + e.latlng.toString()+ "<br/>en GeoJSON: " + coordGeoJSON(e.latlng,7) + "<br/>Niveau de  Zoom: " + map.getZoom().toString())
				.openOn(map);
				//map.on('click', j);
			}



			var info = L.control();
			// pour le titre en haut a droite
			info.onAdd = function (map) {
				this._div = L.DomUtil.create('div', 'info');
				this.update();
				return this._div;
			};
			function maFicheInfo (){
			info.update = function (prop) {
				this._div.innerHTML = "<h3> Bien joué !!! </h3>"+
				"<li>Nom du continent:</li><li>"+<?php echo json_encode($continent);?>+"</li>"+
				"Nom du pays:<li>"+<?php  echo json_encode($nom);?>+"</li>"+
				"La surface du pays:<li>"+<?php  echo json_encode($surface);?>+"</li>"+
				"La langue du pays: <li>"+<?php  echo json_encode($langue);?>+"</li>"+
				"Pour plus d'information:<a href="+<?php  echo json_encode($lien);?>+" ' target='_blank'>Lien</a>"+
				"<center><a href='"+<?php echo json_encode($img);?>+"' target='_blank'><img id='img'  src='"+<?php echo json_encode($img); ?>+"'></a></center>";
				
				
			}; info.addTo(map);
			}

			function myFunction() {  // fin de la partie (bouton rejouer)
				     javascript: document.location = '?id_pays=<?php echo ($id_pays + 1);?>&sc='+0;
					 localStorage.setItem("score",0);

			} 
			function myFunctionQ() { // bouton quitter pour quitter la partie
				     javascript: document.location = '../../profil.php?id=<?php echo ($_SESSION['id']); ?>';
					 localStorage.setItem("score",0);

			} 
			function myFunctionS() { //question suivante
				     javascript: document.location = '?id_pays=<?php echo ($id_pays + 1);?>&sc='+localStorage.getItem("score");
			} 
		//	console.log(idd); 

			function limiterReponse() { // pour limiter les essaies 
				  if(click >= 1 || bonneReponse == 1)
				  myFunctionS();
			}
			
			function traitement(datas,index) {
			  datas.features[0].properties.cca2;
			} 


			L.geoJson(countries, {style:function(feature) {return {color : "#000000" , fillColor : '#ffffff' , weight: 1}},
								  onEachFeature: function onEachFeature(feature, layer) {
									layer.on('mouseover', function () {
      								this.setStyle({
    							    'fillColor': '#0000ff'
								      });});
										layer.on('mouseout', function () {
      								this.setStyle({
							        'fillColor': '#ffffff'
								      });
								    });
									layer.on('click', function () {
									 click++;
									 reponse  =	 feature.properties.cca2;
										var variable2 = <?php echo json_encode($var); ?>;
										var surface2 = <?php echo json_encode($surface); ?>;
										//console.log(surface2);
										$.ajax({

                                                   url : variable2, 
                                                   type : "Get",
                                                   dataType: 'json',
                                                   success: function(datas) {
                                                     traitement(datas,index);
													 },
													 error: function(err) {
														 alert("j'ai echoué");
													 },
													 success: function(datas) {
													 if(	feature.properties.cca2 == datas.features[0].properties.cca2 )
														 {  // si réponse juste
															layer.on('mouseout', function () { // un peu de style
																this.setStyle({
																'fillColor': '#00FF00'
																});});
														    maFicheInfo();
														  $("#bravo").html("Bonne réponse");
														  $("#bravo").css("color", "#4F8A10");
														  $("#bravo").css("background-color", " #DFF2BF");
														  $("#bravo").css("padding", "12px");
														  bonneReponse = 1;
														  $("#question_suivante").show();
														//   limiterReponse();
														  if(surface2<= 800000) // attribution des points selon la superficie du pays
														         MonScore=MonScore+250;
														  else if (surface2>800000 && surface2<=2500000)	
														         MonScore=MonScore+150;
														  else if (surface2>2500000)
														          MonScore=MonScore+50; 		    	  
														  $("#compteur").html(MonScore);
														  localStorage.setItem("score",MonScore); // on sauvegarde le score localement
														 }
													 else {  // si réponse fausse
														    $("#bravo").html("Désolé! Mauvaise réponse ");
													     	$("#bravo").css("color", "#D8000C");
														    $("#bravo").css("background-color", "#FFBABA");
														    $("#bravo").css("padding", "12px");
													        bonneReponse = 0; // passer au question suivante
															limiterReponse();
														  }	 
													 },

											   })	 
									})
									   }
									  
									}).addTo(map); 
									console.log(localStorage.getItem("score")); 
										
			 						

		</script>
	</body>
</html>