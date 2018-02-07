$(document).ready(() => {
    $(".user-item__visible-icon").click((event) => {
        const icon = event.target;
        const seriesId = icon.getAttribute("data-id");
        const dataId = icon.getAttribute("data-parentId");
        const positionToUrl = (location.href).indexOf("season");
        const baseUrl = (location.href).substring(0, positionToUrl);

        const className = "user-item__visible-icon_active";

        const state = $(icon).hasClass(className);
        $(icon).toggleClass(className, !state);
        $.post(baseUrl + "serial/updateStatusSeries", {id: seriesId}, (data) => {
            if (data)
            {
                $(icon).toggleClass(className, data.state);
            }
        });

        $.post(baseUrl + "serial/updateStatus", {id: dataId});
    });
});