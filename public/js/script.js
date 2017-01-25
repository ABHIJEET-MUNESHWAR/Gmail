$(function () {
    $("#js-compose-email-to").select2({
        placeholder: "openingknots@gmail.com"
    });
    getInEmails("Inbox");
    populateComposeToEmails();
});

function populateComposeToEmails() {
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
};

$(document).on("click", "#js-inbox-lbl", function (e) {
    e.preventDefault();
    getInEmails("Inbox");
});

$(document).on("click", "#js-draft-lbl", function (e) {
    e.preventDefault();
    getOutEmails("Draft");
});

$(document).on("click", "#js-sent-lbl", function (e) {
    e.preventDefault();
    getOutEmails("Sent");
});

$(document).on("click", "#js-trash-lbl", function (e) {
    e.preventDefault();
    getInEmails("Trash");
});

$(document).on("submit", "#js-compose-email-form", function () {
    var to = $("#js-compose-email-to").val();
    var subject = $("#js-compose-subject").val();
    var body = $("#js-compose-body").val();
    var $composeSendBtn = $("#js-compose-send");
    var is_reply = $composeSendBtn.data("is_reply");
    var parent_email_id = $composeSendBtn.data("parentEmailID");

    var email = {
        to: to,
        subject: subject,
        body: body,
        is_reply: is_reply,
        parent_email_id: parent_email_id,
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

$(document).on("click", "#js-compose-close", function () {
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
        url: "/draftEmail",
        type: "POST",
        data: email,
        dataType: "json",
        success: function (data) {
            var email_type = $("#js-box-name").text();
            $("#js-panel-alert-type").addClass("panel-success");
            $("#js-box-name").text("Email is drafted.");
            setTimeout(function () {
                $("#js-box-name").text(email_type).show().delay(2000).fadeIn();
                $("#js-panel-alert-type").removeClass("panel-success");
            }, 5000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //
        }
    });
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
                $("#js-inbox-unread-count").text(inbox);
                $("#js-drafts-count").text(drafts);
            }
        },
        complete: function () {
            // Schedule the next request when the current one's complete
            setTimeout(worker, 5000);
        }
    });
})();


function getInEmails(emailType) {
    $.ajax({
        url: "/get" + emailType + "Emails",
        type: "GET",
        cache: true,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.message == "success") {
                var parent_emails = response.data.inbox;
                var html = "";
                i = 1;
                for (var parent_email in parent_emails) {
                    if (parent_emails.hasOwnProperty(parent_email)) {
                        parent_email = parent_emails[parent_email];
                        var subject = parent_email.subject;
                        var email_id = parent_email.email_id;
                        var parent_email_id = parent_email.parent_email_id;
                        var has_read = parent_email.has_read;
                        html += '<div class="panel panel-default" id="js-panel-container-' + parent_email_id + '">';
                        html += '<div class="panel-heading js-panel-email-subject" data-parent-email-id="' + parent_email_id + '" data-email-id="' + email_id + '" data-has-read="' + has_read + '" role="tab" id="heading' + i + '">';
                        if (!!has_read) {
                            html += '<div class="panel-title">';
                        } else {
                            html += '<b class="panel-title">';
                        }
                        html += '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '" aria-expanded="false" aria-controls="collapse' + i + '">';
                        html += subject;
                        html += "</a>";
                        if (!!has_read) {
                            html += "</div>";
                        } else {
                            html += "</b>";
                        }
                        html += "</div>";
                        html += '<div id="collapse' + i + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + i + '">';
                        html += '<div class="panel-body" id="js-panel-body-' + parent_email_id + '">';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        i++;
                    }
                }
                $("#js-box-name").text(emailType);
                $("#accordion").empty().append(html);
            }
        }
    });
};

function getOutEmails(emailType) {
    $.ajax({
        url: "/get" + emailType + "Emails",
        type: "GET",
        cache: true,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.message == "success") {
                var emails = response.data.inbox;
                var html = "";
                i = 1;
                for (var email in emails) {
                    if (emails.hasOwnProperty(email)) {
                        email = emails[email];
                        var body = email.body;
                        var created_at = email.created_at;
                        var email_id = email.email_id;
                        var to_user_email = email.to_user_email;
                        var to_user_id = email.to_user_id;
                        var to_user_name = email.to_user_name;
                        var has_read = email.has_read;
                        var parent_email_id = email.parent_email_id;
                        var subject = email.subject;
                        html += '<div class="panel panel-default" id="js-panel-container-' + parent_email_id + '">';
                        html += '<div class="panel-heading js-panel-email-subject" data-parent-email-id="' + parent_email_id + '" data-email-id="' + email_id + '" data-has-read="' + has_read + '"  role="tab" id="heading' + i + '">';
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
                        html += '<div class="panel-body" id="js-panel-body-' + parent_email_id + '">';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        i++;
                    }
                }
                $("#js-box-name").text(emailType);
                $("#accordion").empty().append(html);
            }
        }
    });
};

$(document).on("click", ".js-panel-email-subject", function (e) {
    var email_id = $(this).data("emailId");
    var parent_email_id = $(this).data("parentEmailId");
    var has_read = $(this).data("hasRead");
    var email_type = $("#js-box-name").text();
    var email = {
        email_id: email_id,
        has_read: has_read,
        parent_email_id: parent_email_id,
        email_type: email_type,
        _token: $('input[name=_token]').val()
    }
    $.ajax({
        url: "/getEmailDetails",
        type: "POST",
        dataType: "json",
        data: email,
        success: function (data) {
            var response = data;
            var email_type = $("#js-box-name").text();
            if (response.message == "success") {
                var emails = response.data.inbox;
                var html = "";
                var email_length = emails.length;
                for (var i = 0; i < email_length; i++) {
                    var email = emails[i];
                    var body = email.body;
                    var created_at = email.created_at;
                    var email_id = email.email_id;
                    var from_user_email = email.from_user_email;
                    var from_user_id = email.from_user_id;
                    var from_user_name = email.from_user_name;
                    var to_user_email = email.to_user_email;
                    var to_user_id = email.to_user_id;
                    var to_user_name = email.to_user_name;
                    var has_read = email.has_read;
                    var parent_email_id = email.parent_email_id;
                    subject = email.subject;
                    html += '<em>';
                    html += '<mark>From</mark>: ' + from_user_name + ' &lt;' + from_user_email + '&gt; <mark>to</mark> ' + to_user_name + ' &lt;' + to_user_email + '&gt; <mark>at</mark>: ' + created_at;
                    html += '</em>';
                    html += '<div class="container-fluid">';
                    html += body;
                    html += '</div><br>';
                }
                if (email_type != "Trash") {
                    html += "<div class='pull-right'>";
                    var btn_name = "Reply";
                    if (email_type == "Draft") {
                        btn_name = "Send";
                    }
                    html += '<button type="button" class="btn btn-default btn-xs js-panel-email-reply" data-email-body="' + body + '" data-email-subject="' + subject + '" data-parent-email-id="' + parent_email_id + '" data-email-id="' + email_id + '" data-from-user-id="' + from_user_id + '"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> ' + btn_name + '</button> ';
                    html += '<button type="button" class="btn btn-default btn-xs js-panel-email-delete" data-delete-parent-email-id="' + parent_email_id + '" data-delete-email-id="' + email_id + '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>';
                    html += '</div>';
                }
                $("#js-panel-body-" + parent_email_id).empty().append(html);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //
        }
    });
});

$(document).on("click", ".js-panel-email-delete", function (e) {
    e.preventDefault();
    var email_id = $(this).data("deleteEmailId");
    var parent_email_id = $(this).data("deleteParentEmailId");
    var email = {
        email_id: email_id,
        parent_email_id: parent_email_id,
        _token: $('input[name=_token]').val()
    }
    $.ajax({
        url: "/deleteEmail",
        type: "POST",
        dataType: "json",
        data: email,
        success: function (data) {
            var email_type = $("#js-box-name").text();
            $("#js-panel-container-"+parent_email_id).remove();
            $("#js-panel-alert-type").addClass("panel-success");
            $("#js-box-name").text("Email is trashed.");
            setTimeout(function () {
                $("#js-box-name").text(email_type).show().delay(2000).fadeIn();
                $("#js-panel-alert-type").removeClass("panel-success");
            }, 5000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //
        }
    });
});

$(document).on("click", ".js-panel-email-reply", function (e) {
    e.preventDefault();
    var email_type = $("#js-box-name").text();
    var $email_body_id = $("#js-compose-body");
    var $composeSendBtn = $("#js-compose-send");
    var email_id = $(this).data("emailId");
    var body = $(this).data("emailBody");
    var parent_email_id = $(this).data("parentEmailId");
    var subject = $(this).data("emailSubject");
    var from_user_id = $(this).data("fromUserId");
    $composeSendBtn.data("is_reply", 1);
    $composeSendBtn.data("parentEmailID", parent_email_id);
    $("#js-compose-email-to").select2().val(from_user_id).trigger("change");
    $("#js-compose-subject").val(subject);
    $email_body_id.val("");
    if (email_type == "Draft") {
        $email_body_id.val(body);
    }
    $('#composeModal').modal('toggle');
});

$(document).on("click", "#js-compose-btn", function(){
    $("#js-compose-subject").val("");
    $("#js-compose-body").val("");
    $("#js-compose-email-to").select2.defaults.reset();
});