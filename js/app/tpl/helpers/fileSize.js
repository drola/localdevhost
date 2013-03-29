define(['Handlebars'], function ( Handlebars ) {
  var lst = ['bytes','KB','MB','GB'];
  function fileSize ( context, mime, options ) {
  	if(mime == "directory") {
  		return "";
  	}
  	
    for(var x in lst) {
    	if(context < 1024.0) {
    		return context.toFixed(1) + " " + lst[x];
    	}
    	context /= 1024.0;
    }
    return context.toFixed(1) + " TB";
  }
  Handlebars.registerHelper( 'fileSize', fileSize );
  return fileSize;
});