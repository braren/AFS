var suggestionView = Backbone.View.extend({
    el: '.actor-search',
    template: _.template($('#tpl_suggestion').html()),

    initialize: function () {

    },

    events: {
        'keyup #txt_actor_search': 'getActorSuggestions',
        'click #txt_actor_search': 'getActorSuggestions'
    },

    getActorSuggestions: function () {
        var self = this;

        var txtActorSearch = $('#txt_actor_search');
        var queryActor = txtActorSearch.val().trim();

        if (queryActor !== '' && queryActor.length > 2) {
            var lstSuggestions = new suggestionCollections(queryActor);

            lstSuggestions.fetch({
                success: function () {
                    self.render(lstSuggestions);
                }
            });
        } else {
            $('.lst_suggestion').html('');
        }
    },

    render: function (lstSuggestions) {
        var self = this;
        $('.lst_suggestion').html('');

        lstSuggestions.toJSON().forEach(function (itSuggestion) {
            if (itSuggestion.id != 0) {
                $('.lst_suggestion').append(
                    self.template(itSuggestion)
                );
            }
        });

        return self;
    }
});

var lstSuggestionView = new suggestionView();