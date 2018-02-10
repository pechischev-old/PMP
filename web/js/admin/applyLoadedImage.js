
$(document).ready(() => {
    $(".image").click(() => {
        const applyImage = (event) => {
            $(".image").attr("src", event.target.result);
        };

        const input = $("[type='file']");
        input.change((e) => loadImage(e, applyImage));
        input.click();
    });
});