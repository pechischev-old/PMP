$(document).ready(() =>{
    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, file; file = files[i]; i++) {
            // Only process image files.
            if (!file.type.match('image.*')) {
                continue;
            }
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = function(e) {
                $(".image-loader__image").css("background-image", `url(${e.target.result})`);
            };
            // Read in the image file as a data URL.
            reader.readAsDataURL(file);
        }
    }

    $("#load").click(() => {
        const input = $("#fileReader");
        input.change(handleFileSelect);
        input.click();
    });
});