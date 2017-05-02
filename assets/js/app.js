/**
 * this is the script, that controls all the
 * js effects and DOM manipulation
 */
var app = {
	/**
	 * this will hide the two options in homepage
	 * and display only the upload csv field.
	 */
	initHome: function(){
		$('.btn_show_form, .btn-cancel-form').click(function(){
			$('.section-default, .section-form').toggleClass('hidden');
		});

		// check total # of histories
		var totalHistoryItems = parseInt($('.btn_link_history').data('history-count')) || 0;
		if (totalHistoryItems == 0) {
			$('.section-default, .section-form').toggleClass('hidden');
		}

		// dropzone init
		$('#csv_upload_dropzone').dropzone({
			url: 'csv/upload'
		})
	}
}