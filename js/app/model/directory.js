define(['backbone', 'config'], function(Backbone, config){
	var Directory = Backbone.Model.extend({
		constructor: function(path) {
			this.path = path;
			this.items = [];
			Backbone.Model.apply(this, arguments);
		},
		url: function() {
			return config.browse_path.replace(/__path__/ig, this.path);
		}
	});

	return Directory;
});