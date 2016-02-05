var actorInfoModel = Backbone.Model.extend({
    initialize: function () {

    },
    defaults: {
        id: 0,
        name: undefined,
        profile_path: undefined,
        birthday: undefined,
        place_of_birth: undefined,
        biography: undefined,
        cast: undefined
    },

    urlRoot: '/api.php/actor/'
});