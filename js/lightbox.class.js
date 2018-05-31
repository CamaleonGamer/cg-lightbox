
function lightbox_cg (propiedades) {
	var uuid_cg = makeid();
	jQuery("body").prepend('<!--LIGHTBOX--><div class="lightbox '+uuid_cg+'"><div class="wrap-lightbox"><div class="content-lightbox"></div><a id="close-lightbox"></a></div></div><!--LIGHTBOX-->');
	var width = propiedades.width;
	var height = propiedades.height;
	var tipo = propiedades.tipo;
	var text = propiedades.text;
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

	if(tipo == "url" || tipo == "video" || tipo == "text")
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
		jQuery(".lightbox."+uuid_cg+" .wrap-lightbox").css(
			PropertyCssWrap
		);

		jQuery(".lightbox."+uuid_cg+" .content-lightbox").css(
			PropertyCssContent
		);


		switch(tipo) {
		    case "url":
		    	jQuery(".lightbox."+uuid_cg+" .content-lightbox").addClass('url');
		        jQuery(".lightbox."+uuid_cg+" .content-lightbox").html('<iframe id="cg_lightbox" frameborder="0" hspace="0" scrolling="auto" src="'+url.url+'" width="100%" height="100%" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>');
	        break;
	        case "video":
	        	jQuery(".lightbox."+uuid_cg+" .content-lightbox").addClass('video');
		        jQuery(".lightbox."+uuid_cg+" .content-lightbox").html('<iframe id="cg_lightbox" frameborder="0" hspace="0" scrolling="auto" src="'+url.url+(url.url == "" || url.url == null ? "" : propiedades_video)+'" width="100%" height="100%" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>');
	        break;
	        case "text":
	        	jQuery(".lightbox."+uuid_cg+" .content-lightbox").css({
					"height": "-webkit-fill-available"
	        	});
	        	jQuery(".lightbox."+uuid_cg+" .content-lightbox").addClass('text');
		        jQuery(".lightbox."+uuid_cg+" .content-lightbox").html('<div id="cg_lightbox" style="width:100%;height:100%">'+text+'</div>');
	        break;
	        default:
	        	jQuery(".lightbox."+uuid_cg+" .content-lightbox").html('<a id="cg_lightbox_img" href="'+(url.url == null || url.url == "" ? "#" : url.url)+'"><img id="cg_lightbox" src="'+url.img+'" width="100%" alt=""></a>');
	        break;

		}
		
		jQuery(".lightbox."+uuid_cg).fadeIn("fast", function(){
			jQuery(".lightbox."+uuid_cg+" .wrap-lightbox").slideDown(function(){
				jQuery(".lightbox."+uuid_cg+" #close-lightbox").css("display", "block");
			});
		});
	};

	this.close = function(){
		// console.log("Lightbox Class Close");
		setCookie("view_cg_lightbox_wp", true, 30);
		jQuery(".lightbox."+uuid_cg).find("#close-lightbox").css('display', 'none');
		jQuery(".lightbox."+uuid_cg).find(".wrap-lightbox").slideUp(function(){
			jQuery(".lightbox."+uuid_cg).find(".content-lightbox").html(null);
			jQuery(".lightbox."+uuid_cg).fadeOut("slow");
		});
	};

	$(document).ready(function() {
		// console.log("LIGHTBOX CG");
		// console.log("uuid_cg",uuid_cg);
		$(".lightbox."+uuid_cg+",.lightbox."+uuid_cg+" #close-lightbox").click(function(e){
			// console.log(e);
			if(e.target.className == 'lightbox '+uuid_cg || e.target.id == 'close-lightbox'){
	            // console.log("Lightbox Class Close",e.target.className);
				setCookie("view_cg_lightbox_wp", true, 30);
				$(".lightbox."+uuid_cg).find("#close-lightbox").css("display", "none");
				$(".lightbox."+uuid_cg).find(".wrap-lightbox").slideUp(function(){
					$(".lightbox."+uuid_cg).find(".content-lightbox").html(null);
					$(".lightbox."+uuid_cg).fadeOut("slow");
				});
	        }
	        else
	        {
	        	if(e.target.id == "cg_lightbox")
	        	{
	        		setCookie("view_cg_lightbox_wp", true, 30);
	        	}
	        }     
		});
	});
}



function makeid() {
  var text = "cg_lightbox_";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 5; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
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