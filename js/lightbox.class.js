function lightbox (propiedades) {
	var width = propiedades.width;
	var height = propiedades.height;
	var tipo = propiedades.tipo;
	if(propiedades.autoplay)
	{
		var autoplay = propiedades.autoplay != null || propiedades.autoplay != false ? propiedades.autoplay : false;
		var propiedades_video = autoplay == false ? "?wmode=opaque" : "?autoplay=1&wmode=opaque";
	}
	else
	{
		var propiedades_video = "";
	}

	var PropertyCssWrap = {};
	var PropertyCssContent = {};
	PropertyCssWrap["width"] = width+"px";

	if(tipo == "url" || tipo == "video")
	{
		// PropertyCssWrap["max-height"] = height+"px";
		// PropertyCssContent["max-height"] = height+"px";
		PropertyCssWrap["height"] = height+"px";
		PropertyCssContent["height"] = height+"px";
		
	}
	else
	{
		PropertyCssWrap["max-height"] = "100%";
		PropertyCssContent["max-height"] = "100%";
	}

	var url = propiedades.url;
	this.open = function(){
		// console.log("Lightbox Class Open");
		jQuery(".wrap-lightbox").css(
			PropertyCssWrap
		);

		jQuery(".content-lightbox").css(
			PropertyCssContent
		);


		switch(tipo) {
		    case "url":
		        jQuery(".content-lightbox").html('<iframe id="cg_lightbox" frameborder="0" hspace="0" scrolling="auto" src="'+url.url+'" width="100%" height="100%" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>');
	        break;
	        case "video":
		        jQuery(".content-lightbox").html('<iframe id="cg_lightbox" frameborder="0" hspace="0" scrolling="auto" src="'+url.url+(url.url == "" || url.url == null ? "" : propiedades_video)+'" width="100%" height="100%" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>');
	        break;
	        default:
	        	jQuery(".content-lightbox").html('<a id="cg_lightbox_img" href="'+(url.url == null || url.url == "" ? "#" : url.url)+'"><img id="cg_lightbox" src="'+url.img+'" width="100%" alt=""></a>');
	        break;

		}
		
		jQuery(".lightbox").fadeIn("fast", function(){
			jQuery(".wrap-lightbox").slideDown(function(){
				jQuery("#close-lightbox").css("display", "block");
			});
		});
	}

	this.close = function(){
		console.log("Lightbox Class Close");
		setCookie("view_cg_lightbox", true, 30);
		jQuery("#close-lightbox").css("display", "none");
		jQuery(".wrap-lightbox").slideUp(function(){
			jQuery(".content-lightbox").html(null);
			jQuery(".lightbox").fadeOut("slow");
		});
	}

	jQuery(document).ready(function() {
		jQuery("#close-lightbox, .lightbox").click(function(e){
			if(e.target.className == 'lightbox' || e.target.id == 'close-lightbox'){
	            // console.log("Lightbox Class Close");
				setCookie("view_cg_lightbox", true, 30);
				jQuery("#close-lightbox").css("display", "none");
				jQuery(".wrap-lightbox").slideUp(function(){
					jQuery(".content-lightbox").html(null);
					jQuery(".lightbox").fadeOut("slow");
				});
	        }
	        else
	        {
	        	if(e.target.id == "cg_lightbox")
	        	{
	        		setCookie("view_cg_lightbox", true, 30);
	        	}
	        }     
		});
	});
}


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}