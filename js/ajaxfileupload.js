jQuery.extend({createUploadIframe:function(a,b){var c="jUploadFrame"+a;if(window.ActiveXObject){var d=document.createElement('<iframe id="'+c+'" name="'+c+'" />');if(typeof b=="boolean"){d.src="javascript:false"}else if(typeof b=="string"){d.src=b}}else{var d=document.createElement("iframe");d.id=c;d.name=c}d.style.position="absolute";d.style.top="-1000px";d.style.left="-1000px";document.body.appendChild(d);return d},createUploadForm:function(a,b){var c="jUploadForm"+a;var d="jUploadFile"+a;var e=$('<form  action="" method="POST" name="'+c+'" id="'+c+'" enctype="multipart/form-data"></form>');var f=$("#"+b);var g=$(f).clone();$(f).attr("id",d);$(f).before(g);$(f).appendTo(e);$(e).css("position","absolute");$(e).css("top","-1200px");$(e).css("left","-1200px");$(e).appendTo("body");return e},ajaxFileUpload:function(a){a=jQuery.extend({},jQuery.ajaxSettings,a);var b=(new Date).getTime();var c=jQuery.createUploadForm(b,a.fileElementId);var d=jQuery.createUploadIframe(b,a.secureuri);var e="jUploadFrame"+b;var f="jUploadForm"+b;if(a.global&&!(jQuery.active++)){jQuery.event.trigger("ajaxStart")}var g=false;var h={};if(a.global)jQuery.event.trigger("ajaxSend",[h,a]);var i=function(b){var d=document.getElementById(e);try{if(d.contentWindow){h.responseText=d.contentWindow.document.body?d.contentWindow.document.body.innerHTML:null;h.responseXML=d.contentWindow.document.XMLDocument?d.contentWindow.document.XMLDocument:d.contentWindow.document}else if(d.contentDocument){h.responseText=d.contentDocument.document.body?d.contentDocument.document.body.innerHTML:null;h.responseXML=d.contentDocument.document.XMLDocument?d.contentDocument.document.XMLDocument:d.contentDocument.document}}catch(f){jQuery.handleError(a,h,null,f)}if(h||b=="timeout"){g=true;var i;try{i=b!="timeout"?"success":"error";if(i!="error"){var j=jQuery.uploadHttpData(h,a.dataType);if(a.success)a.success(j,i);if(a.global)jQuery.event.trigger("ajaxSuccess",[h,a])}else jQuery.handleError(a,h,i)}catch(f){i="error";jQuery.handleError(a,h,i,f)}if(a.global)jQuery.event.trigger("ajaxComplete",[h,a]);if(a.global&&!--jQuery.active)jQuery.event.trigger("ajaxStop");if(a.complete)a.complete(h,i);jQuery(d).unbind();setTimeout(function(){try{$(d).remove();$(c).remove()}catch(b){jQuery.handleError(a,h,null,b)}},100);h=null}};if(a.timeout>0){setTimeout(function(){if(!g)i("timeout")},a.timeout)}try{var c=$("#"+f);$(c).attr("action",a.url);$(c).attr("method","POST");$(c).attr("target",e);if(c.encoding){c.encoding="multipart/form-data"}else{c.enctype="multipart/form-data"}$(c).submit()}catch(j){jQuery.handleError(a,h,null,j)}if(window.attachEvent){document.getElementById(e).attachEvent("onload",i)}else{document.getElementById(e).addEventListener("load",i,false)}return{abort:function(){}}},uploadHttpData:function(r,type){var data=!type;data=type=="xml"||data?r.responseXML:r.responseText;if(type=="script")jQuery.globalEval(data);if(type=="json")eval("data = "+data);if(type=="html")jQuery("<div>").html(data).evalScripts();return data}})