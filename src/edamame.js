document.addEventListener("DOMContentLoaded", function() {
  var mediaFileTag = document.querySelector("#ep-mediafile");
  var mediaLengthTag = document.querySelector("#ep-duration");
  var mediaSizeTag = document.querySelector("#ep-mediasize");
  var mediaNameTag = document.querySelector("#ep-medianame");
  var audioPreviewTag = document.querySelector("#ep-audiopreview");

  var imageFileTag = document.querySelector("#ep-imagefile");
  var imageNameTag = document.querySelector("#ep-imagename");
  var imagePreviewTag = document.querySelector("#ep-imagepreview");

  var imageFileTag_s = document.querySelector("#series-imagefile");
  var imageNameTag_s = document.querySelector("#series-imagename");
  var imagePreviewTag_s = document.querySelector("#series-imagepreview");

  var fileNameRegex = /\ /g;

  if (mediaFileTag) {
    mediaFileTag.addEventListener("change", function() {
      var file = mediaFileTag.files[0];

      var fileURL = URL.createObjectURL(file);
      audioPreviewTag.src = fileURL;
      mediaSizeTag.value = file.size;
      
      mediaNameTag.value = file.name.replace(fileNameRegex, "_");
    });

    audioPreviewTag.addEventListener("durationchange", function() {
      var duration = audioPreviewTag.duration;

      var hours = Math.floor(duration/3600);
      var minutes = Math.floor((duration%3600)/60);
      var seconds = Math.floor(duration%60);

      hours = hours.toString();
      minutes = minutes < 10 ? "0" + minutes.toString() : minutes.toString();
      seconds = seconds < 10 ? "0" + seconds.toString() : seconds.toString();

      mediaLengthTag.value = hours+":"+minutes+":"+seconds;
    });

    imageFileTag.addEventListener("change", function() {
      var file = imageFileTag.files[0];
      var fileURL = URL.createObjectURL(file);
      imagePreviewTag.src = fileURL;

      imageNameTag.value = file.name.replace(fileNameRegex, "_");
    });
  }

  if (imageFileTag_s) {
    imageFileTag_s.addEventListener("change", function() {
      var file = imageFileTag_s.files[0];
      var fileURL = URL.createObjectURL(file);
      imagePreviewTag_s.src = fileURL;

      imageNameTag_s.value = file.name.replace(fileNameRegex, "_");
    });
  }

  if (document.location.host.indexOf('.test') > -1) {
    // is a test server
    document.querySelector('body').classList.add('test');
  }
});
