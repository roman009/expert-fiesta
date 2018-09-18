$(document).ready(function () {
    $('#form_query').autocomplete({
        source: function (request, response) {
            $.get({
                url: $('#form_query').data('endpoint'),
                dataType: 'json',
                data: {
                    query: $('#form_query').val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        response: function (event, ui) {
            if (ui.content.length === 0) {
                ui.content.push({'image': '', 'title': 'No results found', 'synopsis': ''});
            }
        },
        minLength: 1,
        focus: function (event, ui) {
            return false;
        }
    }).autocomplete('instance')._renderItem = function (ul, item) {
        if (item.title === 'No results found') {
            return $('<li>')
                .append('<span class="image"></span><span class="description"><span class="title">' + item.title + '</span><br><span class="synopsis"></span></span>')
                .appendTo(ul);
        }

        return $('<li>')
            .append('<span class="image"><img src="' + item.image + '"></span><span class="description"><span class="title">' + item.title + '</span><br><span class="synopsis">' + item.synopsis + '</span></span>')
            .appendTo(ul);
    };
});