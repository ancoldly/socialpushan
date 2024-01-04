function sendAjaxRequest(url, method, data, successCallback, errorCallback) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: successCallback,
        error: errorCallback,
    });
}

$(document).ready(function () {
    $("#search-input").on("keyup", function () {
        var searchTerm = $(this).val();

        if (searchTerm === "") {
            $("#search-results").addClass("hidden").removeClass("grid");
        }

        $.ajax({
            url: "search",
            type: "GET",
            data: { search: searchTerm },
            success: function (data) {
                $("#search-results").empty();

                if (searchTerm === "") {
                    return;
                }

                if (data.results.length > 0) {
                    var container = $(
                        '<div class="absolute mt-[10px] p-[15px] rounded-[10px] bg-blue-100 grid gap-[15px] w-full"></div>'
                    );

                    data.results.forEach(function (result) {
                        var resultDiv = $(
                            '<div class="flex justify-between items-center">' +
                                '<div class="flex gap-[20px] items-center">' +
                                '<img src="' +
                                result.avatar +
                                '" alt="" class="w-[40px] h-[40px] rounded-full avatar-user">' +
                                '<div class="grid items-center">' +
                                '<form action="/profileDetails" method="GET">' +
                                '<input type="hidden" name="userId" value="' +
                                result.id +
                                '">' +
                                '<button type="submit" class="font-semibold flex items-center gap-[5px]">' +
                                result.username +
                                '<i class="bx bxs-check-circle text-blue-500"></i></button>' +
                                "</form>" +
                                "</div>" +
                                "</div>" +
                                '<button class="flex items-center">' +
                                "</button>" +
                                "</div>"
                        );

                        container.append(resultDiv);
                    });

                    $("#search-results").append(container);

                    $("#search-results").removeClass("hidden").addClass("grid");
                } else {
                    $("#search-results").addClass("hidden").removeClass("grid");
                }
            },
        });
    });

    $("#deleteTell-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("_method", "DELETE");
        sendAjaxRequest(
            $(this).attr("action"),
            "DELETE",
            formData,
            function (response) {
                handleSuccess(response, "deleteTell");
            },
            handleError
        );
    });

    $(document).ready(function () {
        $("#create-story").on("click", function () {
            $("#submitStory").click();
        });
    });

    $(".editGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var group_id = $("#group_id_edit").val();
        formData.append("group_id", group_id);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "editGroup");
            },
            handleError
        );
    });

    $(".editChatGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var group_id = $("#group_id").val();
        formData.append("group_id", group_id);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "editChatGroup");
            },
            handleError
        );
    });

    $(".group_id_edit").click(function () {
        var groupId = $(this).data("group-id");
        console.log(groupId);
        $.ajax({
            url: "/getgroup",
            type: "GET",
            data: { group_id: groupId },
            success: function (response) {
                $("#previewAvatarGroupEdit").attr("src", response.avatar);
                $("#group_name").val(response.group_name);
                $("#group_id_edit").val(response.group_id);
                $("#form-editGroup").addClass("grid").removeClass("hidden");
            },
        });
    });

    $(".groupChat_id_edit").click(function () {
        var groupId = $(this).data("group-id");
        $.ajax({
            url: "/getgroupChat",
            type: "GET",
            data: { group_id: groupId },
            success: function (response) {
                $("#previewAvatarGroupEdit").attr("src", response.avatar);
                $("#group_name").val(response.group_name);
                $("#group_id").val(response.group_id);
                $("#form-editGroupChat").addClass("grid").removeClass("hidden");
            },
        });
    });

    $(".deleteUserGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var member_id = $(this).data("member-id");
        formData.append("_method", "DELETE");
        formData.append("member_id", member_id);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "deleteUserGroup");
            },
            handleError
        );
    });

    $(".joinGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "joinGroup");
            },
            handleError
        );
    });

    $("#createGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "createGroup");
            },
            handleError
        );
    });

    $(".deleteMemberGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var member_id = $(this).data("member-id");
        formData.append("_method", "DELETE");
        formData.append("member_id", member_id);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "deleteMemberGroup");
            },
            handleError
        );
    });

    $(".deleteGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var group_id = $(this).data("group-id");
        formData.append("_method", "DELETE");
        formData.append("group_id", group_id);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "deleteGroup");
            },
            handleError
        );
    });

    $(".deleteGroupChat-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var group_id = $(this).data("group-id");
        formData.append("_method", "DELETE");
        formData.append("group_id", group_id);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "deleteGroupChat");
            },
            handleError
        );
    });

    $(".chatMessageGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "chatMessageGroup");
            },
            handleError
        );
    });

    $(".chatMessageGroup-form").keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $(this).submit();
        }
    });

    $(".chatMessage-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "chatMessage");
            },
            handleError
        );
    });

    $(".chatMessage-form").keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $(this).submit();
        }
    });

    $("#createChatGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "createChatGroup");
            },
            handleError
        );
    });

    $("#joinChatGroup-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "joinChatGroup");
            },
            handleError
        );
    });

    $(".addFriend-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "addFriend");
            },
            handleError
        );
    });

    $(".acceptedFriend-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "acceptedFriend");
            },
            handleError
        );
    });

    $("#changeInfo-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "changeInfo");
            },
            handleError
        );
    });

    $("#changePassword-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "changePassword");
            },
            handleError
        );
    });

    $("#avatar-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "avatar");
            },
            handleError
        );
    });

    $("#biography-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "biography");
            },
            handleError
        );
    });

    $("#createPost-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "createPost");
            },
            handleError
        );
    });

    $(".editPost-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var postId = $(this).data("post-id");
        formData.append("postEdit-id", postId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "editPost");
            },
            handleError
        );
    });

    $(".deletePost-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var postId = $(this).data("post-id");
        formData.append("_method", "DELETE");
        formData.append("postId", postId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "deletePost");
            },
            handleError
        );
    });

    $(".createComment-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var postId = $(this).data("post-id");
        formData.append("post_Id", postId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "createComment");
            },
            handleError
        );
    });

    $(".likePost-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var postId = $(this).data("post-id");
        formData.append("post_Id", postId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "likePost");
            },
            handleError
        );
    });

    $(".sharePost-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var postId = $(this).data("post-id");
        formData.append("post_Id", postId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "sharePost");
            },
            handleError
        );
    });

    $(".editPostShare-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var postId = $(this).data("post-id");
        formData.append("postEdit-id", postId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "editPostShare");
            },
            handleError
        );
    });

    $(".deleteComment-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var commentId = $(this).data("id-comments");
        formData.append("commentsId", commentId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "deleteComment");
            },
            handleError
        );
    });

    $(".editComment-form").submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var commentId = $(this).data("id-comments");
        formData.append("commentsId", commentId);
        sendAjaxRequest(
            $(this).attr("action"),
            "POST",
            formData,
            function (response) {
                handleSuccess(response, "editComment");
            },
            handleError
        );
    });
});

function handleSuccess(response, functionName, xhr) {
    if (response.success) {
        const reloadFunctions = [
            'deleteTell',
            "editGroup",
            "editChatGroup",
            "deleteGroup",
            "deleteUserGroup",
            "joinGroup",
            "createGroup",
            "deleteMemberGroup",
            "deleteGroupChat",
            "joinChatGroup",
            "createChatGroup",
            "addFriend",
            "acceptedFriend",
            "changeInfo",
            "changePassword",
            "avatar",
            "biography",
            "createPost",
            "editPost",
            "deletePost",
            "createComment",
            "likePost",
            "sharePost",
            "editPostShare",
            "deleteComment",
            "editComment",
        ];

        if (reloadFunctions.includes(functionName)) {
            location.reload();
        }
    } else {
        $("#err-password").text("Incorrect current password. Try again.");
    }
}

function handleError(xhr, status, error) {}
