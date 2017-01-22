$(function () {
    $("#js-compose-email-to").select2({
        placeholder: "openingknots@gmail.com"
    });
    getInboxEmails();
});

$(document).on("click", "#js-compose-btn", function () {
    $("#js-compose-subject").val("");
    $("#js-compose-body").val("");

    $.ajax({
        url: "/emailList",
        type: "GET",
        cache: true,
        success: function (data) {
            var options = "";
            for (var user_id in data) {
                if (data.hasOwnProperty(user_id)) {
                    options += "<option value='" + user_id + "'>" + data[user_id] + "</option>";
                }
            }
            $("#js-compose-email-to").empty().append(options);
        }
    });
});

$(document).on("submit", "#js-compose-email-form", function () {
    var to = $("#js-compose-email-to").val();
    var subject = $("#js-compose-subject").val();
    var body = $("#js-compose-body").val();
    var email = {
        to: to,
        subject: subject,
        body: body,
        _token: $('input[name=_token]').val()
    };
    $.ajax({
        url: "/sendEmail",
        type: "POST",
        data: email,
        dataType: "json",
        success: function (data) {
            var boxName = $("#js-box-name").text();
            $("#js-panel-alert-type").addClass("panel-success");
            $("#js-box-name").text("Email is sent.");
            setTimeout(function () {
                $("#js-box-name").text(boxName).show().delay(2000).fadeIn();
                $("#js-panel-alert-type").removeClass("panel-success");
            }, 5000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //
        }
    });
    $('#composeModal').modal('toggle');
    return false;
});
(function worker() {
    $.ajax({
        url: "/checkEmail",
        type: "GET",
        cache: true,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.message == "success") {
                var unread = response.data;
                var inbox = unread.inbox;
                var drafts = unread.drafts;
                if (inbox > 0) {
                    $("#js-inbox-unread-count").text(inbox);
                }
                if (drafts > 0) {
                    $("#js-drafts-count").text(drafts);
                }
            }
        },
        complete: function () {
            // Schedule the next request when the current one's complete
            setTimeout(worker, 5000);
        }
    });
})();

function getInboxEmails() {
    $.ajax({
        url: "/getInboxEmails",
        type: "GET",
        cache: true,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.message == "success") {
                var emails = response.data.inbox;
                var html = "";
                var emailLength = emails.length;
                for (var j = 0; j < emailLength; j++) {
                    email = emails[j];
                    i = j + 1;
                    var body = email.body;
                    var created_at = email.created_at;
                    var email_id = email.email_id;
                    var from_user_email = email.from_user_email;
                    var from_user_id = email.from_user_id;
                    var from_user_name = email.from_user_name;
                    var has_read = email.has_read;
                    var parent_email_id = email.parent_email_id;
                    var subject = email.subject;
                    html += '<div class="panel panel-default">';
                    html += '<div class="panel-heading" role="tab" id="heading' + i + '">';
                    if (!!has_read) {
                        html += '<div class="panel-title">';
                    } else {
                        html += '<h4 class="panel-title">';
                    }
                    html += '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '" aria-expanded="false" aria-controls="collapse' + i + '">';
                    html += subject;
                    html += "</a>";
                    if (!!has_read) {
                        html += "</div>";
                    } else {
                        html += "</h4>";
                    }
                    html += "</div>";
                    html += '<div id="collapse' + i + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + i + '">';
                    html += '<div class="panel-body">';
                    html += body;
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    i++;
                }
                $("#js-box-name").text("Inbox");
                $("#accordion").append(html);
            }
        }
    });
}