function updateImage(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            if (!document.getElementById("imageMotif")) {
                let img = document.createElement("img");
                img.id = "imageMotif";
                img.className = "w-75";
                document.getElementById("divImg").appendChild(img);
            }
            document.getElementById("imageMotif").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}