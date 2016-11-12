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