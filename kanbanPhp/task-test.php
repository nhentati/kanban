<?php
	$page = "task";
?>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">

		<link rel="stylesheet" href="css/stylePostit.css" />
		<link rel="stylesheet" href="css/main.css">
        
		
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.8.1/themes/base/jquery-ui.css" />
        <link type="text/css" href="http://code.jquery.com/ui/1.8.1/themes/base/jquery.ui.datepicker.css" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/i18n/jquery.ui.datepicker-fr.min.js"></script>
		
		<link rel="stylesheet" href="css/jquery-ui-timepicker-addon.css" />
		<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
		
		<script language="javascript" src="js/main_control.js" type="text/javascript"></script>
		
        <style type="text/css">
            .ui-datepicker
            {
                z-index: 100002;
            }			
        </style>

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
				$("#errid_task").html("");	
				$("#errname").html("");
				$("#errcontent").html("");	
				$("#errcompleted_at").html("");
				$("#errcompletion").html("");	
				$("#errcreated_at").html("");	
				$("#errestimated_time").html("");	
				$("#errpriority").html("");
				$("#errspend_time").html("");	
			}		
						
			function initElemDialog(){
				lister_user();
				lister_state();
				lister_categories();
				lister_step_id();
				$('#txtid_task').val('');
				$('#txtname').val('');
				$('#txtcontent').val('');
				$('#txtcompletion').val('');
				$('#txtestimated_time').val('');
				$('#txtpriority').val('');
				$('#txtspend_time').val('');
			}
			
			$(document).ready(function(){
				$("input#txtcreated_at").datetimepicker();				
				$("input#txtcompleted_at").datetimepicker();			
				$("input#txtupdate_at").datetimepicker();
            });

            $(function(){
				lister();
				
				$('#suppr_dialog').dialog({
                    autoOpen: false,
                    width: 380,
                    resizable:false,
                    modal:true,
                    buttons: {
							"Oui": function() { 
								id_postit=$("#id_postit_suppr").val();
								$.ajax({
										type: 'DELETE',
										url: 'http://10.11.145.91:1342/ServiceTask.svc/tasks/'+id_postit,
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
									"ID":$('#txtid_task').val(),
									"Name" :$('#txtname').val(),
									"Assignee":$('#txtassigne').val(),
									"Author":$('#txtauthor').val(),
									"Content" :$('#txtcontent').val(),
									"Completed_at" :$('#txtcompleted_at').val(),
									"Completion" :$('#txtcompletion').val(),
									"Created_at" :$('#txtcreated_at').val(),
									"Estimated_time" :$('#txtestimated_time').val(),
									"Priority" :$('#txtpriority').val(),
									"Spend_time" :$('#txtspend_time').val(),
									"StepID" :$('#txtstep_id').val(),
									"Updated_at" :$('#txtupdate_at').val(),
									"Category" :$('#txtcategory').val(),
									"State" :$('#txtstate').val()
										}
								url = 'http://10.11.145.91:1342/ServiceTask.svc/tasks/update';
							}
							else {
								data = {
										"Name" :$('#txtname').val(),
										"Assignee":$('#txtassigne').val(),
										"Author":$('#txtauthor').val(),
										"Content" :$('#txtcontent').val(),
										"Completed_at" :$('#txtcompleted_at').val(),
										"Completion" :$('#txtcompletion').val(),
										"Created_at" :$('#txtcreated_at').val(),
										"Estimated_time" :$('#txtestimated_time').val(),
										"Priority" :$('#txtpriority').val(),
										"Spend_time" :$('#txtspend_time').val(),
										"StepID" :$('#txtstep_id').val(),
										"Updated_at" :$('#txtupdate_at').val(),
										"Category" :$('#txtcategory').val(),
										"State" :$('#txtstate').val()
										}
								url = 'http://10.11.145.91:1342/ServiceTask.svc/tasks/create';
							}
							
							$.ajax({
									type: 'PUT',
									url: url,
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
			
			function getURLParameters(paramName){
				var sURL = window.document.URL.toString();  
				if (sURL.indexOf("?") > 0){
					var arrParams = sURL.split("?");         
					var arrURLParams = arrParams[1].split("&");      
					var arrParamNames = new Array(arrURLParams.length);
					var arrParamValues = new Array(arrURLParams.length);     
					var i = 0;
					for (i=0;i<arrURLParams.length;i++){
						var sParam =  arrURLParams[i].split("=");
						arrParamNames[i] = sParam[0];
						if (sParam[1] != "")
							arrParamValues[i] = unescape(sParam[1]);
						else
						arrParamValues[i] = "No Value";
					}
					for (i=0;i<arrURLParams.length;i++){
						if(arrParamNames[i] == paramName) {
							return arrParamValues[i];
						}
					}
				}
				return "";
			}
			
			function lister() {
				var idProject = getURLParameters("idProject");
				$.ajax({
						type: 'GET',
						url: 'ajax/project1.json',
						// TODO remettre url: 'http://10.11.145.91:1342/ServiceProject.svc/projects/'+idProject,
						dataType: 'json',
						success: function(response){          
							construirePagePostits(response.Data);
						},
						error: function() {
							alert('erreur');                   
						}
				});
			}
			
			function construirePagePostits(data) {
				var contenuHTML = '';
				if (data.length > 0) {
					var project = data[0];
					$('#nomProjet').html(project.Name);
					
					// steps
					var steps = project.Steps;
					if (steps.length > 0) {
						for (var i = 0; i < steps.length; i++) { 
							//console.log("steps id = " + steps[i].ID + " nb tasks : " + steps[i].Tasks.length);
							
							contenuHTML += '<div class="steps">';
							contenuHTML += '<div class="titreSteps">';
							contenuHTML += steps[i].Name;
							contenuHTML += '</div>';
                
							contenuHTML += '<ul class="sortable-list" id="stepId'+steps[i].ID+'">';
                    		
							// tasks = postits
							if (steps[i].Tasks.length > 0) {
								for (var j = 0; j < steps[i].Tasks.length; j++) { 
									//console.log("tasks id = " + steps[i].Tasks[j].ID);
									contenuHTML += '<li class="sortable-item" id="taskId'+steps[i].Tasks[j].ID+'">';
									contenuHTML += '<div class="postits">';
									contenuHTML += '<div class="titrePostits">';
									//contenuHTML += steps[i].Tasks[j].ID+' - '+steps[i].Tasks[j].Name;
									contenuHTML += steps[i].Tasks[j].Name;
									contenuHTML += '</div>';
									contenuHTML += '<div class="contenuPostits">';
									contenuHTML += steps[i].Tasks[j].Content;
									contenuHTML += '</div>';
									contenuHTML += '<div class="lienPostits">';
									contenuHTML += '<a href="javascript:void(0)" onclick="modif_onclick('+steps[i].Tasks[j].ID+');">Edit</a> | <a href="javascript:void(0)" onclick="suppr_onclick('+steps[i].Tasks[j].ID+');">Suppr</a>';
									contenuHTML += '</div>';
									contenuHTML += '</div>';
									contenuHTML += '</li>';
                    			}
							}
							contenuHTML += '</ul>';
							contenuHTML += '</div>';
						}
					}
				}
				$('#container').html(contenuHTML);
				$('#container .sortable-list').sortable({
                    connectWith: '#container .sortable-list',
					stop: function( event, ui ) {
						var taskDeplace = $(ui.item[0]);
						var idTaskDeplace = taskDeplace.attr("id").split("taskId")[1];
						var idStepCible = taskDeplace.parents('ul').attr("id").split("stepId")[1];
						console.log("TODO task " + idTaskDeplace+ " change de step " + idStepCible);
					}
                });		
			}

			function suppr_onclick(id_postit){
				$("#id_postit_suppr").val(id_postit);
				$('#suppr_dialog').dialog('open');
				return false;
			}
						
			function modif_onclick(id_postit){
				initErr();
				lister_user();
				lister_state();
				lister_categories();
				lister_step_id();
				$.ajax({
					type: 'GET',
					url: 'http://10.11.145.91:1342/ServiceTask.svc/tasks/'+id_postit,
					dataType: 'json',
					success: function(response){          
						$('#txtid_task').val(response.Data.ID);
						$('#txtname').val(response.Data.Name);
						$('#txtauthor').val(response.Data.Author);
						$('#txtassigne').val(response.Data.Assignee);
						$('#txtcontent').val(response.Data.Content);
						$('#txtcompleted_at').val(response.Data.Completed_at);
						$('#txtcompletion').val(response.Data.Completion);
						$('#txtcreated_at').val(response.Data.Created_at);
						$('#txtestimated_time').val(response.Data.Estimated_time);
						$('#txtpriority').val(response.Data.Priority);
						$('#txtspend_time').val(response.Data.Spend_time);
						$('#txtstep_id').val(response.Data.StepID);
						$('#txtupdate_at').val(response.Data.Updated_at);
						$('#txtcategory').val(response.Data.Category.ID);
						$('#txtstate').val(response.Data.State.ID);
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
			function lister_user() {
				$.ajax({
					type: 'GET',
					url: 'ajax/users.json',
					// TODO remettre : 'http://10.11.145.91:1342/ServiceUser.svc/users' 
					dataType: 'json',
					success: function(response){          
						construireListeUsersAuthor(response.Data);	
					},
					error: function() {
						alert('erreur');                   
					}
				});
			}
			function lister_state() {
				$.ajax({
					type: 'GET',
					url: 'ajax/states.json',
								// TODO remettre : 'http://10.11.145.91:1342/ServiceState.svc/states'  
					dataType: 'json',
					success: function(response){          
						construireListeState(response.Data);	
					},
					error: function() {
						alert('erreur');                   
					}
				});
			}
			
			function lister_categories() {
				$.ajax({
					type: 'GET',
					url: 'ajax/categories.json',
								// TODO remettre : 'http://10.11.145.91:1342/ServiceCategory.svc/categories'
					dataType: 'json',
					success: function(response){          
						construireListeCategories(response.Data);	
					},
					error: function() {
						alert('erreur');                   
					}
				});
			}
			
			function lister_step_id() {
				var idProject = getURLParameters("idProject");
				$.ajax({
						type: 'GET',
						url: 'ajax/project1.json',
						// TODO remettre url: 'http://10.11.145.91:1342/ServiceProject.svc/projects/'+idProject,
						dataType: 'json',
						success: function(response){          
							construireListeStep_id(response.Data);
						},
						error: function() {
							alert('erreur');                   
						}
				});
			}
			
			function construireListeUsersAuthor(data) {
				var contenuHTML = '';
				for (var i = 0; i < data.length; i++) { 
					contenuHTML += '<option value="'+data[i].ID+'">'+data[i].Username+'</option>';
				}
				$('#txtauthor').html(contenuHTML);
				$('#txtassigne').html(contenuHTML);		
			}
			
			function construireListeCategories(data) {
				var contenuHTML = '';
				for (var i = 0; i < data.length; i++) { 
					contenuHTML += '<option value="'+data[i].ID+'">'+data[i].Name+'</option>';
				}
				$('#txtcategory').html(contenuHTML);
			}
			
			function construireListeState(data) {
				var contenuHTML = '';
				for (var i = 0; i < data.length; i++) { 
					contenuHTML += '<option value="'+data[i].ID+'">'+data[i].Label+'</option>';
				}
				$('#txtstate').html(contenuHTML);
			}
			function construireListeStep_id(data) {
				var contenuHTML = '';
				if (data.length > 0) {
					var project = data[0];
					// steps
					var steps = project.Steps;
					if (steps.length > 0) {
						for (var i = 0; i < steps.length; i++) { 
							contenuHTML += '<option value="'+steps[i].ID+'">'+steps[i].Name+'</option>';
						}
					}
				}
				$('#txtstep_id').html(contenuHTML);
			}
			
        </script>
    </head>
    <body>
		<div id="wrapper" class="<?php echo $class; ?>">
			<div id="header">
				<div id="head_left">
					<p id="titre"><img src="images/kanban.gif" alt="logo" style="margin-top:5px;" /></p>
					<div id="menu">
						<a href="javascript:void(0)" id="menu_launcher">Liste des menus</a>
						<?php include('include/menu.php'); ?>
					</div>
				</div>
				<div id="head_right">
					<a href="deconnexion.php" id="deconnect">Se d&eacute;connecter</a>
					
					<?php
						if ($ariane != "")
						{
					?>
					<p id="fil_ariane">&bull; <?php echo $ariane; ?></p>
					<?php
						}
					?>
				</div>
			</div>
			<div id="content">
	
			<div id="section-header">
				<h2 id="nomProjet"></h2>
				<div id="ajout"><a href="javascript:void(0)" id="ajoutPostit" onclick="ajout_onclick();">Ajout postit</a></div>
			</div>
			
			<div id="container">
           
			</div>

			<div id="dialog" title="Postit">
				<form>
					<div id="formBlock">
						<p style="display:none;">
							<label for="txtid_task">Id:</label>
							<input type="text" id="txtid_task" readonly="readonly" />
							<span id="errid_task" class="info"></span>
						</p>
						<p>
							<label for="txtname">Name:</label>
							<input type="text" id="txtname" onBlur="validate('name');" />
							<span id="errname" class="info"></span>
						</p>
						<p>
							<label for="txtauthor">Author : </label>
							<select id="txtauthor">
							</select> 
						</p>
						<p>
							<label for="txtassigne">Assigne :</label>
							<select id="txtassigne">
							</select> 
						</p>
						<p>
							<label for="txtcontent">Content :</label>
							<textarea row="2" cols="30" id="txtcontent" onBlur="validate('content');"></textarea>
							<span id="errcontent" class="info"></span>
						</p>
						<p>
							<label for="txtcompleted_at">Completed at :</label>
							<input type="text" id="txtcompleted_at" />
							<span id="errcompleted_at" class="info"></span>
						</p>
						<p>
							<label for="txtcompletion">Completion :</label>
							<input type="text" id="txtcompletion" />
							<span id="errcompletion" class="info"></span>
						</p>
						
						<p>
							<label for="txtcreated_at">Created at :</label>
							<input type="text" id="txtcreated_at" readonly="readonly" />
							<span id="errcreated_at" class="info"></span>
						</p>
						<p>
							<label for="txtestimated_time">Estimated time :</label>
							<input type="text" id="txtestimated_time" />
							<span id="errestimated_time" class="info"></span>
						</p>
						<p>
							<label for="txtpriority">Priority :</label>
							<input type="text" id="txtpriority" />
							<span id="errpriority" class="info"></span>
						</p>
						<p>
							<label for="txtspend_time">Spend time :</label>
							<input type="text" id="txtspend_time" />
							<span id="errspend_time" class="info"></span>
						</p>
						<p>
							<label for="txtstep_id">Step id :</label>
							<select id="txtstep_id">
							</select> 
						</p>
						<p>
							<label for="txtcategory">Category :</label>
							<select id="txtcategory">
							</select> 
						</p>
						<p>
							<label for="txtstate">State :</label>
							<select id="txtstate">
							</select> 
						</p>

						<p>
							<label for="txtupdate_at">Update at :</label>
							<input type="text" id="txtupdate_at" />
						</p>
					</div>
				</form>
			</div>

			<div id="suppr_dialog" title="Suppression d'un postit">
				<input type="hidden" id="id_postit_suppr" value="">
				<h2>Voulez-vous vraiment supprimer ce postit ? </h2>
			</div>
		</div>
		<div id="push"></div>
	</div>
	<div id="footer" class="">
		<p>Pr&ecirc;t &hellip;</p>
	</div>
	</body>
</html>
    </body>
</html>
