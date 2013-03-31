<html>
	<head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">
        
		<link rel="stylesheet" href="css/main.css">
        <!--<link rel="stylesheet" href="css/style.css" />-->

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.1/themes/base/jquery-ui.css" />
        <link type="text/css" href="http://code.jquery.com/ui/1.8.1/themes/base/jquery.ui.datepicker.css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/i18n/jquery.ui.datepicker-fr.min.js"></script>

        <style type="text/css">
            .ui-datepicker
            {
                z-index: 100002;
            }
        </style>
		
		<script language="javascript" src="js/main_control.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="css/tablesorter.css" />
				
	</head>
	
	<body>
		<div id="wrapper" class="" style="background-repeat: no-repeat; background-position: center bottom;">
			<div id="header">
				<div id="head_left">
					<p id="titre"><!--<img src="images/logo.jpg" alt="logo" style="margin-top:5px;" />--></p>
					<div id="menu">
						<a href="javascript:void(0)" id="menu_launcher">Liste des menus</a>
						<div id="menu_content">
							<ul class="menu">
								<li class="actif"><a href="javascript:void(0)">Users</a>
									<ul class="sousmenu">
										<li><a href="user.html">Liste</a></li>			
									</ul>
								</li>
							
								<li class=""><a href="javascript:void(0)">Projects</a>
									<ul class="sousmenu">
										<li><a href="project.html">Liste</a></li>
									</ul>
								</li>
								
								<li class=""><a href="javascript:void(0)">Categories</a>
									<ul class="sousmenu">
										<li><a href="category.html">Liste</a></li>
									</ul>
								</li>
								
								<li class=""><a href="javascript:void(0)">States</a>
									<ul class="sousmenu">
										<li><a href="state.html">Liste</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div id="head_right">
					<a href="deconnexion.php" id="deconnect">Se d&eacute;connecter</a>
				</div>
			</div>
			<div id="content">
				<p id="le_titre">States</p>
				<div id="le_contenu">
					<script type="text/javascript" language="javascript">
						function validate(elem){
							if ($("#txt"+elem).val()==""){
								$("#err"+elem).html("&nbsp;Err&nbsp;");
							}
							else{
								$("#err"+elem).html("");
							}
						}
						
						function initErr(){
							$("#errid_state").html("");	
							$("#errlabel").html("");	
						}		
						
						function initElemDialog(){
							$('#txtid_state').val('');
							$('#txtlabel').val('');
						}
						
						$(function(){
							// Initialisation des lments du dialogue	
							initErr();
							initElemDialog();
							
							// Initialisation de la liste
							lister();
							
							// Initialisation des Dialogs
							// Formulaire de confirmation de la suppression d'un state
							$('#suppr_dialog').dialog({
								autoOpen: false,
								width: 380,
								resizable:false,
								modal:true,
								buttons: {
									"Oui": function() { 
										data = {"ID":$("#id_state_suppr").val()};
										$.ajax({
												type: 'POST',
												url: 'ajax/deleteState.php',
												data: data,
												success: function(response){                 
													lister();													
												},
												error: function(){
													alert('erreur');                   
												}
										});
										$(this).dialog("close"); 
									},				
									"Non": function() { 
										$(this).dialog("close"); 
									}				
								}
							});				
							// Formulaire d'insertion/modification d'un state
							$('#dialog').dialog({
								autoOpen: false,
								width: 400,
								resizable:false,
								modal:true,
								buttons: {
									"Appliquer": function() { 
										/* traitement AJAX de la mise  jour*/
										var data;
										var url;
										if ($('#txtid_state').val() != "") {
											data = {
													"ID":$('#txtid_state').val(),
													"Label":$('#txtlabel').val()
													}
										}
										else {
											data = {
													"Label":$('#txtlabel').val()
													}
										}
										
										$.ajax({
												type: 'POST',
												url: 'ajax/putState.php',
												data: data,
												success: function(response){                 
													lister();
												},
												error: function(){
													alert('erreur');                   
												}
											}
										);
										
										$(this).dialog("close"); 
									}, 
									"Annuler": function() { 
										$(this).dialog("close"); 
									}				
								}
							});		
						});	
						
						function suppr_onclick(id_state){
							$("#id_state_suppr").val(id_state);
							$("#state_suppr").html(">>"+$('#id_state'+id_state).html()+"<<");
							$('#suppr_dialog').dialog('open');
							return false;
						}
						
						function modif_onclick(id_state){
							initErr();
							
							$.ajax({
								type: 'GET',
								url: 'http://10.11.145.91:1342/ServiceState.svc/states/'+id_state,
								dataType: 'json',
								success: function(response){          
									$('#txtid_state').val(response.Data[0].ID);
									$('#txtlabel').val(response.Data[0].Label);
									$('#dialog').dialog('open');
								},
								error: function() {
									alert('erreur');                   
								}
							});
							return false;
						}
						
						function ajout_onclick(){
							initErr();
							initElemDialog();
							$('#dialog').dialog('open');
							return false;
						}
						
						function show_sousmenu(numero){
							for (i=1;i<=3;i++){
								if (i==numero){	
									$("#SousMenu"+i).css("visibility","visible")
													.css("height","auto");
								}
								else{
									$("#SousMenu"+i).css("visibility","hidden")
													.css("height","0px");
								}
							}
						}	
						
						function lister() {
							$.ajax({
								type: 'GET',
								url : 'http://10.11.145.91:1342/ServiceState.svc/states' ,
								dataType: 'json',
								success: function(response){          
									construireListeStates(response.Data);	
								},
								error: function() {
									alert('erreur');                   
								}
							});
						}
						
						function construireListeStates(data) {
							var contenuHTML = '';
							contenuHTML += '<table width="100%" class="tablesorter" id="table_resultat">';
							contenuHTML += '<thead>';
							contenuHTML += '<tr class="ui-widget-header">';
							contenuHTML += '<th style="width:5%;text-align:center">Id</th>';
							contenuHTML += '<th style="width:30%;text-align:center">Label</th>';
							contenuHTML += '<th colspan="2" style="width:30%;text-align:center"><a href="#" id="ajout" onclick="ajout_onclick();">Ajout state</a></th>';
							contenuHTML += '</tr>';
							contenuHTML += '</thead>';
							contenuHTML += '<tbody>';		
							
							if (data.length > 0) {
								for (var i = 0; i < data.length; i++) { 
									contenuHTML += '<tr id="ligne'+data[i].ID+'">';
									contenuHTML += '<td style="width:5%;text-align:center"><span id="id_state'+data[i].ID+'">'+data[i].ID+'</span></td>';
									contenuHTML += '<td style="width:30%;text-align:center">';
									contenuHTML += '<span id="label'+data[i].ID+'">'+data[i].Label+'</span>';
									contenuHTML += '</td>';
									contenuHTML += '<td style="width:15%;text-align:center"><a href="#" id="modif" onclick="modif_onclick('+data[i].ID+');">Modif.</a></td>';
									contenuHTML += '<td style="width:15%;text-align:center"><a href="#" id="suppr" onclick="suppr_onclick('+data[i].ID+');">Suppr.</a></td>';
									contenuHTML += '</tr>';
								}
							}
							contenuHTML += '</tbody>';
							contenuHTML += '</table>';
							
							$("#table_resultat").tablesorter({
															widgets: ['zebra'],
															headers: { 2: { sorter: false}}
															}) 
												.tablesorterPager({
															container: $("#pager"),
															positionFixed:false
															});
															
							$('#liste').html(contenuHTML);
									
						}
					
					</script>
					<h2>States</h2>
					<div id="liste">
					
					</div>
					
					<div id="dialog" title="Info State">
						<form>
						<div id="formBlock">
							<fieldset>
							<legend>Information sur la state</legend>
							<p style="display:none;">
								<label for="txtid_state">Id:</label>
								<input type="text" id="txtid_state" readonly="readonly" />
								<span id="errid_state" class="info"></span>
							</p>
							<p>
								<label for="txtlabel">Label:</label>
								<input type="text" id="txtlabel" onBlur="validate('label');" />
								<span id="errlabel" class="info"></span>
							</p>
							</fieldset>
						</div>
						</form>
					</div>				
					
					<div id="suppr_dialog" title="Suppression d'un state">
						<input type="hidden" id="id_state_suppr" value="">
						<h2>Voulez-vous vraiment supprimer cette state 
							<br><span id="state_suppr"></span> ?
						</h2>
					</div>
				</div>
				<div id="push"></div>
			</div>		
		</div>
		<div id="footer" class="">
			<p>Pr&ecirc;t &hellip;</p>
		</div>
	</body>
</html>