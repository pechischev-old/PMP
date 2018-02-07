$(document).ready(() => {
    $(".user-item__visible-icon").click((event) => {
        const icon = event.target;
        const dataId = icon.getAttribute("data-id");
        const positionToUrl = (location.href).indexOf("season");
        const baseUrl = (location.href).substring(0, positionToUrl);

        const state = $(icon).hasClass("user-item__visible-icon_active");
        $(icon).toggleClass("user-item__visible-icon_active", !state);
        $.post(baseUrl + "series", {id: dataId}, (data) => {
            if (data == undefined)
            {
                $(icon).toggleClass("user-item__visible-icon_active", state);
                return;
            }
        });
    });
});