$(document).ready(() => {
    $(".user-item__visible-icon").click((event) => {
        const icon = event.target;
        const dataId = icon.getAttribute("data-id");
        const positionToUrl = (location.href).indexOf("season");
        const baseUrl = (location.href).substring(0, positionToUrl);
        $.post(baseUrl + "series", {id: dataId}, function (state) {
            if (state == undefined)
            {
                return;
            }
            $(icon).toggleClass("user-item__visible-icon_active", state);
        });
    });
});