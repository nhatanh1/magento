define(["jquery"], function ($) {
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
                        } else {
                            $(".note").html(data["message"]);
                            $(".note").css("color", "red");
                        }
                        document.getElementById("comment-form").reset();
                    },
                    error: function (e) {
                        console.log("sai");
                    },
                });
            }
        });
    }

    return main;
});
