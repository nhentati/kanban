$(document).ready(function(){
	$('a#menu_launcher').click(function(){
		$(this).blur();
		if ($(this).parent('div').hasClass('actif'))
			$(this).parent('div').removeClass('actif');
		else
			$(this).parent('div').addClass('actif');
	});
	$('ul.menu li').click(function(){
		$(this).children('a').blur();
		if ($(this).hasClass('actif'))
			$(this).removeClass('actif');
		else
			$(this).addClass('actif');
	});
	$('form#analyse>fieldset>fieldset>a#ajout_tranche').click(function(){
		$(this).blur();
		var nb_tranche = $('p.tranche').length;
		$(this).before('<p class="tranche no_fac"><select name="balise_'+((nb_tranche+1))+'" id="balise_'+(nb_tranche+1)+'" class="crit"><option value="1">Moins de </option><option value="2" selected="selected">Entre </option><option value="3">Plus de </option></select> <input name="tranche_'+(nb_tranche+1)+'" id="tranche_'+(nb_tranche+1)+'" type="text" class="tranche" /><span class="facultatif"> et </span><input name="tranche_'+(nb_tranche+1)+'_bis" id="tranche_'+(nb_tranche+1)+'_bis" type="text" class="tranche facultatif" /><a href="javascript:void(0)" class="tranche" title="Supprimer cette tranche">[-]</a></p>');
		$('select.crit').unbind().bind('change',function(){
			if ($(this).val() == 1 || $(this).val() == 3)
			{
				if ($(this).val() == 1 && $('select.crit[value=1]').length > 1)
				{
					$(this).val(2);
					alert('Impossible d\'ajouter cette tranche car elle existe d\351ja. Merci de s\351lectionner une autre.');
				}
				else if ($(this).val() == 3 && $('select.crit[value=3]').length > 1)
				{
					$(this).val(2);
					alert('Impossible d\'ajouter cette tranche car elle existe d\351ja. Merci de s\351lectionner une autre.');
				}
				else
					$(this).parent('p.tranche').removeClass('no_fac');
			}
			else
				$(this).parent('p.tranche').addClass('no_fac');
		});
		$('p.tranche>a.tranche').unbind().bind('click',function(){
			$(this).parent('p.tranche').remove();
			//redefinir les nom et id
			var i = 0;
			$('p.tranche').each(function(){
				i++;
				$(this).children('select').attr('name','balise_'+i);
				$(this).children('select').attr('id','balise_'+i);
				$(this).children('input:first').attr('name','tranche_'+i);
				$(this).children('input:first').attr('id','tranche_'+i);
				$(this).children('input.facultatif').attr('name','tranche_'+i+'_bis');
				$(this).children('input.facultatif').attr('id','tranche_'+i+'_bis');
			});
		});
	});
	$('form#analyse>fieldset>fieldset>p>select.crit').change(function(){
		if ($(this).val() == 1 || $(this).val() == 3)
			$(this).parent('p.tranche').removeClass('no_fac');
		else
			$(this).parent('p.tranche').addClass('no_fac');
	});
	$('form#analyse').submit(function(){
		var donnees = $(this).serialize();
		var vide = 0;
		$('input.tranche:visible').each(function(){
			if ($.trim($(this).val()) == "")
				vide++;
		});
		donnees += '&tranche='+$('p.tranche').length;
		if (vide != 0 || $('form#analyse>fieldset>fieldset select#fkt').val() == 0)
			alert('Aucun crit\350re ne doit pas \352tre laiss\351 vide.');
		else
		{
			$.ajax({
				url: 'ajax/ajax_construct_analyse.php',
				type: 'POST',
				data: donnees,
				success: function(data){
					$('div#tableau_analyse').html(data);
				},
				error: function(){
					alert('Une erreur est survenue.');
				}
			});
		}
	});
	$('div#footer p').ajaxStart(function(){
		$(this).text('Chargement en cours ...');
	});
	$('div#footer p').ajaxStop(function(){
		$(this).text('Pr\350t ...');
	});
	$('a.search').live('click',function(){
		$(this).blur();
		$('input.txt_search:visible').toggle();
		$(this).next('input.txt_search').toggle();
		if ($(this).next('input.txt_search:visible').length == 0)
		{
			$(this).next('input.txt_search:visible').val('');
			//désactiver la recherche
		}
		else
		{
			$(this).next('input.txt_search').focus();
		}
	});
	$('input.txt_search:visible').live('keyup',function(){
		/*
		search_nom = span#nom...
		search_nr = span#num_recensement...
		search_id = span#id_contribuable...
		span < td < tr (id: col1/2_ligne...)
		*/
		//trouver la ligne
		var cle = $.trim($(this).val());
		$('tr.ligne_choisie').removeClass('ligne_choisie');
		$('tr[id^="col"].add').remove();
		$('tr[id^="col"]:not(:visible)').toggle();
		if (cle != '')
		{
			if ($(this).attr('name') == 'search_nom')
			{
				var t = $('span[id^="nom"]:contains("'+cle+'")').parent('td').parent('tr').attr('id').split('_ligne');
			}
			else if ($(this).attr('name') == 'search_nr')
			{
				var t = $('span[id^="num_recensement"]:contains("'+cle+'")').parent('td').parent('tr').attr('id').split('_ligne');
			}
			else if ($(this).attr('name') == 'search_id')
			{
				var t = $('span[id^="id_contribuable"]:contains("'+cle+'")').parent('td').parent('tr').attr('id').split('_ligne');
			}
			if ($('tr[id^="col1_ligne"]:first').attr('id') != 'col1_ligne'+t[1])
			{
				$('tr[id="col1_ligne'+t[1]+'"]').clone().prependTo($('tr[id="col1_ligne'+t[1]+'"]').parent());
				$('tr[id="col1_ligne'+t[1]+'"]:last:visible').toggle();
				$('tr[id="col1_ligne'+t[1]+'"]:first:visible').addClass('add');
			}
			if ($('tr[id^="col2_ligne"]:first').attr('id') != 'col2_ligne'+t[1])
			{
				$('tr[id="col2_ligne'+t[1]+'"]').clone().insertAfter('tr.col2');
				$('tr[id="col2_ligne'+t[1]+'"]:last:visible').toggle();
				$('tr[id="col2_ligne'+t[1]+'"]:first:visible').addClass('add');
			}
			if ($('tr[id^="col3_ligne"]:first').attr('id') != 'col3_ligne'+t[1])
			{
				$('tr[id="col3_ligne'+t[1]+'"]').clone().insertAfter('tr.col3');
				$('tr[id="col3_ligne'+t[1]+'"]:last:visible').toggle();
				$('tr[id="col3_ligne'+t[1]+'"]:first:visible').addClass('add');
			}
			$('tr[id="col1_ligne'+t[1]+'"]').addClass('ligne_choisie');
			$('tr[id="col2_ligne'+t[1]+'"]').addClass('ligne_choisie');
			$('tr[id="col3_ligne'+t[1]+'"]').addClass('ligne_choisie');
		}
	});
});