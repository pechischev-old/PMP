$(document).ready(() =>{

    $("#load").click(() => {
        const applyImage = (event) => {
            $(".image-loader__image").css("background-image", `url(${event.target.result})`);
        };

        const input = $("#fileReader");
        input.change((e) => loadImage(e, applyImage));
        input.click();
    });
});