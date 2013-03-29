define(['Handlebars'], function ( Handlebars ) {
  function fileSize ( context, options ) {
    return context + " B";
  }
  Handlebars.registerHelper( 'fileSize', fileSize );
  return fileSize;
});