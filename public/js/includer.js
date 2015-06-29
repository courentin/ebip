function include(liste, callback) {
	if (typeof liste === "object") {
		for(type in liste) {
			for(fichier in liste[type]) {
				includeOne(liste[type][fichier],type);
			}
		}
	} else return false;
	if(callback) callback();
}

function includeOne(file, ext) {
	var f = ext+"/"+file+"."+ext
	switch(ext) {
		case 'js':
			var js = document.createElement("script");
			js.setAttribute("src",f);
			document.body.appendChild(js);
		break;

		case 'css':
			var css = document.createElement("link");
			css.setAttribute("rel","stylesheet");
			css.setAttribute("type","text/css");
			css.setAttribute("href",f);
			document.head.appendChild(css);
		break;

		default: return false;
		break;
	}
}