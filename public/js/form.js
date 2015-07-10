var Form = function(argId) {
	var id   = argId;
	var dura = 300;
	var elmt = $("#"+id);
	var subVal = elmt.find(".form-submit").val();
	var isErr = false;

	this.get = function(input) {
		return elmt.find("#"+input).val();
	}

	this.replace = function(argHtml) {
		elmt.fadeOut(dura,function() {
			elmt.html(argHtml);
		});			
		elmt.fadeIn(dura);
	}

	this.setLoader = function() {
		elmt.find(".form-submit").val("");
		elmt.find(".form-submit").css("background", "url(/public/img/loader-WHITE-26.gif) no-repeat center center, #F18854");
	}

	this.removeLoader = function() {
		elmt.find(".form-submit").css("background", "#F18854");
		elmt.find(".form-submit").val(subVal);
	}

	this.flashErr = function(errors) {

		var content = "";
		if(errors.isArray) {
			for (var error in errors) {
				content += errors[error]+"<br/>";
			}
		} else {
			content = errors;
		}
		

		if(isErr) {
			elmt.find(".error").html(content);
		}
		else {
			$("<div class='flash error'>"+content+"</div>").insertBefore(elmt.find(".form-submit"));
			isErr = true;
		}
	}
	this.flashSuc = function(msg) {
		this.replace("<div class='flash success'>"+msg+"</div>");
	}
}