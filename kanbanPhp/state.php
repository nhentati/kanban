<?php
	$page = "state";
	include('include/header.php');
?>
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
	
<?php
	include('include/footer.php');
?>