/* Submit the title change */
$("#edit-title").submit(function (e) {
    var url = window.location.pathname;
    if (url[url.length - 1] != '/')
        url = url + "/title";
    else
        url = url + "title";

    $.ajax({
        type: "POST",
        url: url,
        data: $("#edit-title").serialize(),
        success: function (data) {
            if (JSON.parse(data).status == 'success') {
                $("#title-error").html("");
                $("#title-success").html("Title updated.");
            } else {
                $("#title-success").html("");
                $("#title-error").html("Error changing title.");
            }
        }
    });

    e.preventDefault();
});

/* Submits the description change */
$("#edit-description").submit(function (e) {
    var url = window.location.pathname;
    if (url[url.length - 1] != '/')
        url = url + "/description";
    else
        url = url + "description";

    $.ajax({
        type: "POST",
        url: url,
        data: $("#edit-description").serialize(),
        success: function (data) {
            // Display success or error message.
            if (JSON.parse(data).status == 'success') {
                $("#description-error").html("");
                $("#description-success").html("Title updated.");
            } else {
                $("#description-success").html("");
                $("#description-error").html("Error changing title.");
            }
        }
    });

    e.preventDefault();
});

/* Add tags */
$("#edit-tags").submit(function (e) {
    var url = window.location.pathname;
    if (url[url.length - 1] != '/')
        url = url + "/addtags";
    else
        url = url + "addtags";

    $.ajax({
        type: "POST",
        url: url,
        data: $("#edit-tags").serialize(),
        error: function (x, y) {
            console.log(y);
        },
        success: function (data) {
            if (JSON.parse(data).status == "success") {
                // console.log(data);
                console.log(JSON.parse(data).tags[0].name);
                var tags = JSON.parse(data).tags;
                tags.forEach(function (tag) {
                    var newItem = '<form method="POST" action="http://localhost:8000" accept-charset="UTF-8" id="del-tag" class="edit-tag">';
                    newItem += '<span class="tag">' + tag.name + '</span>';
                    newItem += '<input name="tid" value="' + tag.crypt + '" type="hidden">';
                    newItem += '<input class="btn btn-primary" value="X" type="submit">';
                    newItem += '</form>';

                    $("#display-tags").append(newItem);
                });
            }
        }
    });
    $("#add-tag").val("");

    e.preventDefault();
});

/* Remove Tag */
$(document.body).on('submit', '.edit-tag', function(e) {
    var tag = this;
    var url = window.location.pathname;
    if (url[url.length - 1] != '/')
        url = url + "/deltag";
    else
        url = url + "deltag";

    $.ajax({
        type: "POST",
        url: url,
        data: $(this).serialize(),
        success: function (data) {
            if (JSON.parse(data).status == "success") {
                tag.remove();
            }
        }
    });

    e.preventDefault();
});