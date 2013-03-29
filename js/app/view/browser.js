define(["hbs!app/tpl/browser", "app/model/directory"], function(browserTpl, DirectoryModel) {
    var Browser = Backbone.View.extend({
        initialize: function() {
            this.model = new DirectoryModel("/");
            this.render();
            this.listenTo(this.model, "change", this.render);
            this.model.fetch();
        },
        render: function() {
            this.$el.html(browserTpl(this.model.attributes));
        }
    });

    return Browser;
});