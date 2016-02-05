var suggestionCollections = Backbone.Collection.extend({

    initialize: function (query) {
        this.url = this.url + query;
    },

    model: suggestionModel,
    url: '/api.php/suggestion/'
});