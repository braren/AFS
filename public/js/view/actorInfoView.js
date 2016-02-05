var actorInfoView = Backbone.View.extend({
    el: '.actor-info',
    template: _.template($('#tpl_actor_info').html()),

    initialize: function (id_actor) {
        var self = this;
        $('.actor-info').html('');

        var itActorInfoModel = new actorInfoModel({
            id: id_actor
        });

        itActorInfoModel.fetch({
            success: function () {
                self.render(itActorInfoModel.toJSON());
                $('.lst_suggestion').html('');
            }
        });
    },

    render: function (itActorInfoModel) {
        var self = this;

        if (itActorInfoModel.profile_path === undefined || itActorInfoModel.profile_path === null) {
            itActorInfoModel.profile_path = 'img/user_icon.jpg'
        } else {
            itActorInfoModel.profile_path = 'https://image.tmdb.org/t/p/w185/' + itActorInfoModel.profile_path;
        }

        $('.actor-info').append(
            self.template(itActorInfoModel)
        );

        if (itActorInfoModel.cast !== null &&
            itActorInfoModel.cast.length > 0 &&
            itActorInfoModel.cast !== undefined) {
            var templateCast = _.template($('#tpl_info_cast').html())

            itActorInfoModel.cast.forEach(function (itCast) {
                if (itCast.poster_path === undefined || itCast.poster_path === null) {
                    itCast.poster_path = 'img/no-poster.jpg'
                } else {
                    itCast.poster_path = 'https://image.tmdb.org/t/p/w185/' + itCast.poster_path;
                }

                $('.info-cast').append(
                    templateCast(itCast)
                );
            });
        }

        return self;
    }
});

function getActorInfo(id_actor) {
    new actorInfoView(id_actor);
}