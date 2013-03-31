<?php
	$page = "project";
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
							$("#errid_project").html("");	
							$("#err_project").html("");
							$("#err_owner_id").html("");	
						}		
						
						function initElemDialog(){
							lister_user_admin();
							$('#txtid_project').val('');
							$('#txtproject').val('');
							$('#txtowner_id').val('');	
						}
						
						$(function(){
							// Initialisation des lments du dialogues	
							initErr();
							initElemDialog();
							
							// Initialisation de la liste
							lister();
							
							// Initialisation des Dialogs
							// Formulaire de confirmation de la suppression d'un project
							$('#suppr_dialog').dialog({
								autoOpen: false,
								width: 380,
								resizable:false,
								modal:true,
								buttons: {
									"Oui": function() { 
										data = {"ID":$("#id_project_suppr").val()};
										$.ajax({
												type: 'POST',
												url: 'ajax/deleteProject.php',
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
							// Formulaire d'insertion/modification d'un project
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
										if ($('#txtid_project').val() != "") {
											data = {
													"ID":$('#txtid_project').val(),
													"Name":$('#txtproject').val(), 
													"OwnerID":$('#txtowner_id').val()
													}
										}
										else {
											data = {
													"Name":$('#txtproject').val(), 
													"OwnerID":$('#txtowner_id').val() 
													}
										}
										
										$.ajax({
												type: 'POST',
												url: 'ajax/putProject.php',
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
						
						function suppr_onclick(id_project){
							$("#id_project_suppr").val(id_project);
							$("#project_suppr").html(">>"+$('#id_project'+id_project).html()+"<<");
							$('#suppr_dialog').dialog('open');
							return false;
						}
						
						function modif_onclick(id_project){
							initErr();
							lister_user_admin();
							$.ajax({
								type: 'GET',
								url: 'http://10.11.145.91:1342/ServiceProject.svc/projects/'+id_project,
								dataType: 'json',
								success: function(response){          
									$('#txtid_project').val(response.Data[0].ID);
									$('#txtproject').val(response.Data[0].Name);
									$('#txtowner_id').val(response.Data[0].OwnerID);
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
								url: 'http://10.11.145.91:1342/ServiceProject.svc/projects',
								dataType: 'json',
								success: function(response){          
									construireListeProjects(response.Data);	
								},
								error: function() {
									alert('erreur');                   
								}
							});
						}
						
						function construireListeProjects(data) {
							var contenuHTML = '';
							contenuHTML += '<table width="100%" class="tablesorter" id="table_resultat">';
							contenuHTML += '<thead>';
							contenuHTML += '<tr class="ui-widget-header">';
							contenuHTML += '<th style="width:5%;text-align:center">Id</th>';
							contenuHTML += '<th style="width:30%;text-align:center">Name</th>';
							contenuHTML += '<th style="width:15%;text-align:center">OwnerID</th>';
							contenuHTML += '<th style="width:15%;text-align:center">Steps</th>';
							contenuHTML += '<th colspan="2" style="width:30%;text-align:center"><a href="#" id="ajout" onclick="ajout_onclick();">Ajout project</a></th>';
							contenuHTML += '</tr>';
							contenuHTML += '</thead>';
							contenuHTML += '<tbody>';		
							
							if (data.length > 0) {
								var classTr = "";
								for (var i = 0; i < data.length; i++) { 
									contenuHTML += '<tr id="ligne'+data[i].ID+'">';
									contenuHTML += '<td style="width:5%;text-align:center"><span id="id_project'+data[i].ID+'">'+data[i].ID+'</span></td>';
									contenuHTML += '<td style="width:30%;text-align:center">';
									contenuHTML += '<span id="name'+data[i].ID+'"><a href="postit.html?idProject='+data[i].ID+'">'+data[i].Name+'</a></span>';
									contenuHTML += '</td>';
									contenuHTML += '<td style="width:15%;text-align:center"><span id="ownerID'+data[i].ID+'">'+data[i].OwnerID+'</span></td>';
									contenuHTML += '<td style="width:15%;text-align:center"><a href="step.php?id_project='+data[i].ID+'">Steps</a></td>';
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
						
						function lister_user_admin() {
						$.ajax({
							type: 'GET',
							url:'http://10.11.145.91:1342/ServiceUser.svc/users',
							dataType: 'json',
							success: function(response){          
								construireListeUsersAdmin(response.Data);	
							},
							error: function() {
								alert('erreur');                   
							}
						});
						
						function construireListeUsersAdmin(data) {
							var contenuHTML = '';
							for (var i = 0; i < data.length; i++) { 
								if (data[i].Admin) {
									contenuHTML += '<option value="'+data[i].ID+'">'+data[i].Username+'</option>';
								}
							}
							$('#txtowner_id').html(contenuHTML);	
						}
					}
					
					</script>
					<h2>Projects</h2>
					<div id="liste">
					
					</div>
					
					<div id="dialog" title="Info Project">
						<form>
						<div id="formBlock">
							<fieldset>
							<legend>Information sur le projet</legend>
							<p style="display:none;">
								<label for="txtid_project">Id:</label>
								<input type="text" id="txtid_project" readonly="readonly" />
								<span id="errid_project" class="info"></span>
							</p>
							<p>
								<label for="txtproject">Name:</label>
								<input type="text" id="txtproject" onBlur="validate('project');" />
								<span id="err_project" class="info"></span>
							</p>
							<p>
								<label for="txtowner_id">OwnerID:</label>
								<select id="txtowner_id">
								</select> 
							</p>
							</fieldset>
						</div>
						</form>
					</div>				
					
					<div id="suppr_dialog" title="Suppression d'un project">
						<input type="hidden" id="id_project_suppr" value="">
						<h2>Voulez-vous vraiment supprimer ce project 
							<br><span id="project_suppr"></span> ?
						</h2>
					</div>
				</div>
				
<?php
	include('include/footer.php');
?>