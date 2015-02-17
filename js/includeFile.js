function readFilesAndDisplayPreview(files) {
    // Loop through the FileList and render image files as thumbnails.
    // Only process image files.
      if (files[0].type.match('image.*')) {
      
      var reader = new FileReader();
      //capture the file information.
      reader.onload = function(e) {
          // Render thumbnail.
          $("#"+currentElement).attr("src",e.target.result);
          elementList[currentElement].img = files[0].name;
          console.log("plop "+ files[0].name);
          elementList[currentElement].width = $("#"+currentElement).width();
          elementList[currentElement].height = $("#"+currentElement).height();
		  elementList[currentElement].base64 = e.target.result;
          updatePanelDetail();
        };
      // Read in the image file as a data URL.
      reader.readAsDataURL(files[0]);
    }
}
function handleFileSelect(evt) {
   var files = evt.target.files; // FileList object
   readFilesAndDisplayPreview(files);
}
document.getElementById('files').addEventListener('change', handleFileSelect, false);

$(document).ready(function() { 
		
$('#imgUpload').on('change', function(){ 
   $("#uploadForm").ajaxForm({
      target: '#preview', 
      //clearForm: true,
      resetForm: true,
       beforeSubmit:function(){ 
	      $("#uploadStatus").show();
	      $("#imgUploadBtn").hide();
   }, 
      success:function(){ 
	      $("#uploadStatus").hide();
	      $("#imgUploadBtn").show();
   }, 
      error:function(){ 
	      $("#uploadStatus").hide();
	      $("#imgUploadBtn").show();
   } }).submit();

   });
}); 
