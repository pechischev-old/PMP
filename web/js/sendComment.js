$(document).ready(() => {
    $("#sendComment").click((event) => {

        const textareaElement = $("#comment");
        const text = textareaElement.val();
        const id = textareaElement.attr("data-id");

        if (text == "")
        {
            return;
        }

        const positionToUrl = (location.href).indexOf("item");
        const baseUrl = (location.href).substring(0, positionToUrl);

        $("#comment").val("");
        $.post(baseUrl + "sendcomment", {text, id}, (data) => {
            if (!data)
            {
                return;
            }

            const element = document.createElement("div");
            element.setAttribute("class", "comment-list__comment-item col-xs-12 col-sm-12");

            element.innerHTML = `<div class="user__icon" style="background-image: url('${data.userIcon}')"></div>\n` +
                `                <div class="text-container">\n` +
                `                    <div class="user__name">${data.username}<span>, оставлен ${data.date}</span></div>\n` +
                `                    <div class="user__comment">${data.text} </div>\n` +
                `                </div>`;

            $(".comment-list").append(element);
            $(window).resize();
        });
    });
});