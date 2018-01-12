
$(document).ready(start);

function start() {
    const update = () => {
        $("#content").height(0); // обнуление высоты
        const height = $(".content-container").height();
        const contentHeight = $("#content").height();
        $("#content").height(height);
    };

    update();

    $(window).resize(() => {
        update();
    });
}