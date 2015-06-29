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
		elmt.find(".form-submit").css("background", "url(img/loader-WHITE-26.gif) no-repeat center center, #F18854");
	}

	this.removeLoader = function() {
		elmt.find(".form-submit").css("background", "#F18854");
		elmt.find(".form-submit").val(subVal);
	}

	this.flashErr = function(msg) {
		if(isErr) elmt.find(".error").html(msg);
		else {
			$("<div class='flash error'>"+msg+"</div>").insertBefore(elmt.find(".form-submit"));
			isErr = true;
		}
	}
	this.flashSuc = function(msg) {
		this.replace("<div class='flash success'>"+msg+"</div>");
	}
}