// TODO: Create confirm delete method.
$("#delete").click(function() {

});

/* Submit the title change */
$("#edit-title").submit(function (e) {
    // var url = '/image/' . $pid . '/edit/title';

    var url = window.location.pathname;
    if (url[url.length - 1] != '/')
        url = url + "/title";
    else
        url = url + "title";

    $.ajax({
        type: "POST",
        url: url,
        data: $("#edit-title").serialize(),
        success: function(data)
        {
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
        success: function(data)
        {
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
        error: function(x,y)
        {
            console.log(y);
        },
        success: function(data)
        {
            console.log(data);
            // console.log(JSON.parse(data).tags[0]);
            if (JSON.parse(data).status == "success") {
                var tags = JSON.parse(data).tags;
                tags.forEach(function(tag) {
                    var newItem = '<li class="input-group tag-group">';
                    newItem += '<span class="tag">' + tag + '</span>';
                    newItem += '<button class="btn btn-primary">X</button>';
                    newItem += '</li>';
                    $("#tag-list").append(newItem);
                });
            }
        }
    });

    $("#add-tag").val("");

    e.preventDefault();
});