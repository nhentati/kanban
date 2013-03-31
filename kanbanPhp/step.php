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
										<li><a href="step.html">Liste</a></li>			
									</ul>
								</li>
							
								<li class=""><a href="javascript:void(0)">Steps</a>
									<ul class="sousmenu">
										<li><a href="step.html">Liste</a></li>
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
				<p id="le_titre">Liste des steps du projet <?php echo $_GET['id_project']; ?></p>
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
							$("#errid_step").html("");	
							$("#err_step").html("");
							$("#err_order").html("");	
						}		
						
						function initElemDialog(){
							$('#txtid_step').val('');
							$('#txtstep').val('');
							$('#txtorder').val('');	
						}
						
						$(function(){
							// Initialisation des lments du dialogues	
							initErr();
							initElemDialog();
							
							// Initialisation de la liste
							lister();
							
							// Initialisation des Dialogs
							// Formulaire de confirmation de la suppression d'un step
							$('#suppr_dialog').dialog({
								autoOpen: false,
								width: 380,
								resizable:false,
								modal:true,
								buttons: {
									"Oui": function() { 
										data = {"ID":$("#id_step_suppr").val()};
										$.ajax({
												type: 'POST',
												url: 'ajax/deleteStep.php',
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
							// Formulaire d'insertion/modification d'un step
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
										if ($('#txtid_step').val() != "") {
											data = {
													"ID":$('#txtid_step').val(),
													"Name":$('#txtstep').val(), 
													"Order":$('#txtorder').val(),
													"ProjectID":$('#txtid_project').val()
													}
										}
										else {
											data = {
													"Name":$('#txtstep').val(), 
													"Order":$('#txtorder').val(),
													"ProjectID":$('#txtid_project').val()
													}
										}
										
										$.ajax({
												type: 'POST',
												url: 'ajax/putStep.php',
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
						
						function suppr_onclick(id_step){
							$("#id_step_suppr").val(id_step);
							$("#step_suppr").html(">>"+$('#id_step'+id_step).html()+"<<");
							$('#suppr_dialog').dialog('open');
							return false;
						}
						
						function modif_onclick(id_step){
							initErr();
							$.ajax({
								type: 'GET',
								url: 'http://10.11.145.91:1342/ServiceStep.svc/steps/'+id_step,
								dataType: 'json',
								success: function(response){          
									$('#txtid_step').val(response.Data[0].ID);
									$('#txtstep').val(response.Data[0].Name);
									$('#txtorder').val(response.Data[0].Order);
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
								url: 'http://10.11.145.91:1342/ServiceStep.svc/steps',
								dataType: 'json',
								success: function(response){          
									construireListeSteps(response.Data);	
								},
								error: function() {
									alert('erreur');                   
								}
							});
						}
						
						function construireListeSteps(data) {
							var contenuHTML = '';
							contenuHTML += '<table width="100%" class="tablesorter" id="table_resultat">';
							contenuHTML += '<thead>';
							contenuHTML += '<tr class="ui-widget-header">';
							contenuHTML += '<th style="width:5%;text-align:center">Id</th>';
							contenuHTML += '<th style="width:30%;text-align:center">Name</th>';
							contenuHTML += '<th style="width:15%;text-align:center">Order</th>';
							contenuHTML += '<th colspan="2" style="width:30%;text-align:center"><a href="#" id="ajout" onclick="ajout_onclick();">Ajout step</a></th>';
							contenuHTML += '</tr>';
							contenuHTML += '</thead>';
							contenuHTML += '<tbody>';		
							
							if (data.length > 0) {
								var classTr = "";
								for (var i = 0; i < data.length; i++) { 
									//if (data[i].ProjectID == <?php echo $_GET['id_project']; ?>) {
										contenuHTML += '<tr id="ligne'+data[i].ID+'">';
										contenuHTML += '<td style="width:5%;text-align:center"><span id="id_step'+data[i].ID+'">'+data[i].ID+'</span></td>';
										contenuHTML += '<td style="width:30%;text-align:center">';
										contenuHTML += '<span id="name'+data[i].ID+'">'+data[i].Name+'</span>';
										contenuHTML += '</td>';
										contenuHTML += '<td style="width:15%;text-align:center"><span id="ownerID'+data[i].ID+'">'+data[i].Order+'</span></td>';
										contenuHTML += '<td style="width:15%;text-align:center"><a href="#" id="modif" onclick="modif_onclick('+data[i].ID+');">Modif.</a></td>';
										contenuHTML += '<td style="width:15%;text-align:center"><a href="#" id="suppr" onclick="suppr_onclick('+data[i].ID+');">Suppr.</a></td>';
										contenuHTML += '</tr>';
									}
								//}
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
					<h2>Steps du project <?php echo $_GET['id_project']; ?></h2>
					<div id="liste">
					
					</div>
					
					<div id="dialog" title="Info Step">
						<form>
						<div id="formBlock">
							<fieldset>
							<legend>Information sur le step</legend>
							<p style="display:none;">
								<label for="txtid_step">Id:</label>
								<input type="text" id="txtid_step" readonly="readonly" />
								<input type="hidden" id="txtid_project" readonly="readonly" value="<?php echo $_GET['id_project']; ?>" />
							</p>
							<p>
								<label for="txtstep">Name:</label>
								<input type="text" id="txtstep" onBlur="validate('step');" />
								<span id="err_step" class="info"></span>
							</p>
							<p>
								<label for="txtorder">Order:</label>
								<input type="text" id="txtorder" onBlur="validate('order');" /> 
							</p>
							</fieldset>
						</div>
						</form>
					</div>				
					
					<div id="suppr_dialog" title="Suppression d'un step">
						<input type="hidden" id="id_step_suppr" value="">
						<h2>Voulez-vous vraiment supprimer ce step 
							<br><span id="step_suppr"></span> ?
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