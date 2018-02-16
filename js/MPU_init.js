var image_field;
console.log("MP Utilities init");
jQuery(function($){
	/*$(document).on('click', 'input.select-img', function(evt){
		image_field = $(this).siblings('.img');
		tb_show('Choose an image', 'media-upload.php?type=image&amp;TB_iframe=true');
		//store old send to editor function
		window.restore_send_to_editor = window.send_to_editor;
		// Display the Image link in TEXT Field
		window.send_to_editor = function(html) {
			imgurl = $('img', html).attr('src');
			image_field.val(imgurl);
			tb_remove();
			window.send_to_editor = window.restore_send_to_editor;
		} 
		evt.preventDefault();
	});*/
	$('.color-field').each(function(){
                    $(this).wpColorPicker();
            });
	
	var mediaUploader;

	$('.button.mediapicker').on("click", this, function(e) {
		var target = $(this).prev("input");
		e.preventDefault();
/*		// If the uploader object has already been created, reopen the dialog
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}*/
		// Extend the wp.media object
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
		button: {
			text: 'Choose Image'
		}, multiple: false });
		
		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader.on('select', function() {
		
			attachment = mediaUploader.state().get('selection').first().toJSON();
			target.val(attachment.url);
		});
		// Open the uploader dialog
		mediaUploader.open();
	});
	
    $(".MP_utils .tabpanel").on("click", "nav a", function(e){
		var $target = $($(this).attr("href"));
		$("nav a.active, .tabBody.active").removeClass("active");
		$(this).addClass("active");
		$target.addClass("active");
		setTab();
		e.preventDefault();
		
	});
	function setTab(){
		var activeHeight = $(".tabBody.active").innerHeight() + $(".tabpanel nav").innerHeight() + parseInt($(".tabpanel nav").css("margin-bottom"));
		$(".tabpanel").css({"height": activeHeight});
	}
	setTab();
	
	if(!$(".mpu_sidebar_menuholder #mpu_enablesidebar").is(":checked")){$(".mpu_sidebar_menuholder .sidebarContentHolder").addClass("active");}
	$(".mpu_sidebar_menuholder").on("click","input#mpu_enablesidebar", function(e){
		if($("#mpu_enablesidebar").is(":checked")){
			$(".sidebarContentHolder").removeClass("active");
		}
		else{
			$(".sidebarContentHolder").addClass("active");
		}
		
	});


});