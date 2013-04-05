define(['Handlebars'], function ( Handlebars ) {
  function pathBreadcrumb ( context, options ) {
    if(context === undefined) {
      return;
    }

    var segments = context.split('/');
    var out = '<ul class="breadcrumb">';
    for(var i in segments) {
      if(i == segments.length -1 && segments[i].length<1) {
        break;
      }

      out += '<li><a href="#" class="browser-link" data-path="'
      + "/" + segments.slice(0, Number(i)+1).join('/')
      + '">'
      + (segments[i]?segments[i]:"..")
      + '</a> <span class="divider">/</span></li>';
    }
    out += '</ul>';
    return new Handlebars.SafeString(out);
  }

  Handlebars.registerHelper( 'pathBreadcrumb', pathBreadcrumb );
  return pathBreadcrumb;
});