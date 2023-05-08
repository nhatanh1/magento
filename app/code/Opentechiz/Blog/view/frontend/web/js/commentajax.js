define(["jquery", "jquery/jquery-ui"], function ($) {
    "use strict";

    function main(config) {
        var AjaxCommentPostUrl = config.AjaxCommentPostUrl;

        var dataForm = $("#comment-form");
        dataForm.mage("validation", {});

        $(document).on("click", ".submit", function () {
            if (dataForm.valid()) {
                event.preventDefault();
                var param = dataForm.serialize();
                alert(param);
                $.ajax({
                    url: AjaxCommentPostUrl,
                    data: param,
                    type: "POST",
                    success: function (data) {
                        if (data["result"] === "success") {
                            $(".note").html(data["message"]);
                            $(".note").css("color", "green");
                            $(".private-comment").removeClass("hidden");
                            var html = $(".private-comment-list").html();
                            var comment = `<li class="comment-item">                                     
                                <div class="comment-title">
                                `+ data['data']['title'] +`
                                </div>
                                <div class="comment-author">
                                `+ data['data']['nickname'] +`
                                </div>
                                </div>
                                <div class="flex comment-content">
                                    <div class="comment-detail">
                                    `+ data['data']['detail'] +`
                                    </div>
                                    <div class="comment-time">
                                    `+ data['data']['creation_time'] +`
                                    </div>
                                </div>
                            </li>`;
                        
                            var private_comment = comment + html;
                            $(".private-comment").html(private_comment);
                        } else {
                            $(".note").html(data["message"]);
                            $(".note").css("color", "red");
                        }
                        document.getElementById("comment-form").reset();
                    },
                });
            }
        });
    }

    return main;
});
