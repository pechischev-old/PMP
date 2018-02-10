function loadImage(evt, handler) {
    var files = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, file; file = files[i]; i++) {
        // Only process image files.
        if (!file.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = handler;
        // Read in the image file as a data URL.
        reader.readAsDataURL(file);
    }
}