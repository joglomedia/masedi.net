;(function($){
	$(document).ready(function(){
		//create initial hidden form
		var htmlform = $('#popup_domination_tab_htmlform textarea').val();
		if (htmlform.length > 0){
			$('#popup_domination_tab_htmlform #hidden-form').html($('#popup_domination_tab_htmlform textarea').val());
			createForm();
			$('#popup_domination_tab_htmlform #popup_domination_name_box').val($('#popup_domination_tab_htmlform #popup_domination_name_box_selected').val());
			$('#popup_domination_tab_htmlform #popup_domination_email_box').val($('#popup_domination_tab_htmlform #popup_domination_email_box_selected').val());
			$('#popup_domination_tab_htmlform #popup_domination_name_box').val($('#popup_domination_tab_htmlform #popup_domination_name_box_selected').val());
			$('#popup_domination_tab_htmlform #popup_domination_email_box').val($('#popup_domination_tab_htmlform #popup_domination_email_box_selected').val());
		}
		
		
		
		
		/*var value = "", selected = "";
			
		selected = $('#popup_domination_tab_htmlform #popup_domination_name_box').val();
		$('#popup_domination_tab_htmlform #popup_domination_name_box').empty().append(options);
		value = $('#popup_domination_tab_htmlform #popup_domination_name_box_selected').val();
		$('#popup_domination_tab_htmlform #popup_domination_name_box').attr('selected', value);
		
		$('#popup_domination_tab_htmlform #popup_domination_email_box').empty().append(options);
		value = $('#popup_domination_tab_htmlform #popup_domination_email_box_selected').val();
		$('#popup_domination_tab_htmlform #popup_domination_email_box').attr('selected', value);*/
	
	
		
		
		
		//create a new form everytime form is edited
		$('#popup_domination_tab_htmlform #popup_domination_formhtml').blur(function(){
			if ($(this).val().length == 0){
				$(this).addClass('input-error');
			} else {
				$(this).removeClass('input-error');
			}
			$('#popup_domination_tab_htmlform #hidden-form').html($(this).val());
			createForm();
		});
		
		function createForm(){
			var fields = "";
			$('#popup_domination_tab_htmlform #hidden-form input[type="text"], #popup_domination_tab_htmlform #hidden-form input[type="email"], #popup_domination_tab_htmlform #hidden-form input[type="hidden"]').each(function(){
				var type = $(this).attr('type');
				var name = $(this).attr('name');
				var value = $(this).attr('value');
				var placeholder = ($(this).val().length != 0) ? 'placeholder="Enter your '+name+'..."': '';
				fields += '<input type="'+type+'" value="'+value+'" name="'+name+'" class="name" '+placeholder+' />';
			});
			var action = $('#popup_domination_tab_htmlform #hidden-form form').attr('action');
			//set action
			$('#popup_domination_tab_htmlform #popup_domination_action').val(action);
			
			//set name and email fields
			var options = getOptions();
			
			
			//print form
			var form = '<form method="post" action="'+action+'" target="_blank" >';
			form += fields;
			form += '<input type="submit" value="Submit" /></form>';
			return form;
		}
		
		function getOptions(){
			var options = '';
			$('#popup_domination_tab_htmlform #hidden-form input[type="text"], #popup_domination_tab_htmlform #hidden-form input[type="email"]').each(function(){
				var value = $(this).attr('name');
				options += '<option value="'+value+'">'+value+'</option>';
			});
			return options;
		}
	});
})(jQuery);










