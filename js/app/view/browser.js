define(["hbs!app/tpl/browser", "app/model/directory", 'hljs'], function(browserTpl, DirectoryModel) {
    var Browser = Backbone.View.extend({
        events: {
            "click a.browser-link": "browse"
        },
        initialize: function() {
            this.model = new DirectoryModel("/");
            this.render();
            this.listenTo(this.model, "change", this.render);
            this.model.fetch();
        },
        render: function() {
            this.$el.html(browserTpl(this.model.attributes));
            this.$el.find('pre.code').each(function(i, e) {hljs.highlightBlock(e);});
            this.delegateEvents();
            return this;
        },
        browse: function(e) {
            var path = $(e.currentTarget).data('path');
            this.stopListening(this.model);
            this.model = new DirectoryModel(path);
            this.listenTo(this.model, "change", this.render);
            this.model.fetch();
        }
    });

    return Browser;
});