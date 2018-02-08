$(document).ready(() => {

    $("#save-settings").click(() => {

        const firstName = $("#first-name").val();
        const lastName = $("#last-name").val();
        const email = $("#email").val();
        const password = $("#password").val();

        let imageData = $(".image-loader__image").css("background-image");
        imageData = imageData.replace("url(\"", "");
        imageData = imageData.replace("\")", "");

        const json = {
            firstName: firstName,
            lastName: lastName,
            email: email,
            password: password,
            icon: imageData,
        };
        $.post(location.href + "/save", json, (date) => {
            $("#first-name").val(date.firstName);
            $("#last-name").val(date.lastName);
            $("#email").val(date.email);

            $(".user__icon").css("background-image", `url(${date.capture})`);
        });
    });
});