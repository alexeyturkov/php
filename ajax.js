$( document ).ready(function() {
    $("#btn").click(
		function(){
			sendAjaxForm('result_form', 'ajax_form', 'ajax_form.php');
			return false; 
		}
	);
});
 
function sendAjaxForm(result_form, ajax_form, url) {
    jQuery.ajax({
        url:    "ajax_form.php", 
        type:     "POST", 
        dataType: "html", 
        data: jQuery("#"+ajax_form).serialize(),  
        success: function(response) { 
              
        	result = jQuery.parseJSON(response);

        	document.getElementById(result_form).innerHTML = result.name+"<br>"+result.email;
             
    	},
    	error: function(response) { 
    		document.getElementById(result_form).innerHTML = "Ошибка. Данные не отправленны.";
    	}
     
 	});
}


