// CREAR EVENTOS //
function removeEvent(el, eventName, handler){
	if(el[0])
	{
		for (var i = 0; i < el.length; i++) {
			el[i].removeEventListener(eventName, handler, false);
		}
	}
	else
	{
		el.removeEventListener(eventName, handler, false);
	}
	
}

function addEvent(el, eventName, handler){
	if(el[0])
	{
		for (var i = 0; i < el.length; i++) {
			if (el[i].addEventListener) {
		           el[i].addEventListener(eventName, handler);
		    } else {
		        el[i].attachEvent('on' + eventName, function(){
		          handler.call(el[i]);
		        });
		    }	
		}
	}
	else
	{
		if (el.addEventListener)
		{
           el.addEventListener(eventName, handler);
	    }
	    else
	    {
	        el.attachEvent('on' + eventName, function(){
	          handler.call(el);
	        });
	    }
	}
    
}
///////////////////
var current_width, current_height;

function ProportionWidth()
{
	// console.log("ancho: "+current_width, "alto: "+current_height);
	var proportion = jQuery("input:checkbox[name='cg_lightbox_settings[proportion]']").is(":checked");
	var new_width = jQuery("input[name='cg_lightbox_settings[width]']").val();
	var new_height = jQuery("input[name='cg_lightbox_settings[height]']").val();
	if(proportion)
	{
		jQuery("input[name='cg_lightbox_settings[height]']").val(Math.round((new_width*current_height)/current_width));
	}
}

function ProportionHeight()
{
	// console.log("ancho: "+current_width, "alto: "+current_height);
	var proportion = jQuery("input:checkbox[name='cg_lightbox_settings[proportion]']").is(":checked");
	var new_width = jQuery("input[name='cg_lightbox_settings[width]']").val();
	var new_height = jQuery("input[name='cg_lightbox_settings[height]']").val();
	if(proportion)
	{
		jQuery("input[name='cg_lightbox_settings[width]']").val(Math.round((new_height*current_width)/current_height));
	}
}

function disableOption()
{
	var tipo = jQuery("input[name='cg_lightbox_settings[tipo]']:checked").val();

	// console.log(tipo);

	switch(tipo)
	{
		case "img":
			jQuery("#cg_lightbox_video").hide();
			jQuery("#cg_lightbox_img").show();
			jQuery("#cg_lightbox_url").show();
			jQuery("#cg_lightbox_post").hide();
		break;

		case "url":
			jQuery("#cg_lightbox_url").show();
			jQuery("#cg_lightbox_video").hide();
			jQuery("#cg_lightbox_img").hide();
			jQuery("#cg_lightbox_post").hide();
		break;

		case "blog":
			jQuery("#cg_lightbox_video").hide();
			jQuery("#cg_lightbox_img").show();
			jQuery("#cg_lightbox_url").hide();
			jQuery("#cg_lightbox_post").show();
			
		break;

		case "video":
			jQuery("#cg_lightbox_video").show();
			jQuery("#cg_lightbox_url").show();
			jQuery("#cg_lightbox_post").hide();
			jQuery("#cg_lightbox_img").hide();
		break;
	}
}

jQuery(document).ready(function(){
	current_width = jQuery("input[name='cg_lightbox_settings[width]']").val();
	current_height = jQuery("input[name='cg_lightbox_settings[height]']").val();
	// console.log("ancho: "+current_width, "alto: "+current_height);
	addEvent(document.querySelector("input[name='cg_lightbox_settings[width]']"),'keyup', ProportionWidth);
	addEvent(document.querySelector("input[name='cg_lightbox_settings[height]']"),'keyup', ProportionHeight);
	addEvent(jQuery("input:checkbox[name='cg_lightbox_settings[proportion]']"),'change', ProportionWidth);

	addEvent(jQuery("input[name='cg_lightbox_settings[tipo]']"),'change', disableOption);
	addEvent(window,'load', disableOption);

});
