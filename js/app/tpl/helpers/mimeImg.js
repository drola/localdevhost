define(['Handlebars', 'config'], function ( Handlebars, config ) {
  function mimeImg ( mime, options ) {
    mime = mime.replace(/\//ig, "-");
    if(config.mime[mime] !== undefined) {
      return new Handlebars.SafeString('<img src="' + config.mime[mime] + '" >');
    } else {
      return "";//mime;
    }
  }
  console.log(config.mime);
  Handlebars.registerHelper( 'mimeImg', mimeImg );
  return mimeImg;
});