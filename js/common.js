jQuery(document).ready(function($) {
$('#event-input').val($('#event-name').html());

var event_date = $('#event-date').text();
event_date = event_date.split('.');

// var monthfix = 
send_date = Math.round(new Date(event_date[2] + '-' + '0' + event_date[1] + '-' + event_date[0]).getTime()/1000.0);
// send_date = new Date(event_date[2] + '-' + '0' + event_date[1] + '-' + event_date[0]);
$('#event-date-input').val(send_date);

// FORM
$('#myform').on('submit',  function(event) {
		event.preventDefault();

		var inputs = validForm($('#myform input'));
		
			if (!inputs) {
				swal({
					title: 'שגיאה',
					text: 'חובה למלא כל השדות',
					type: 'error',
					confirmButtonText: 'OK'
				});
				return;
			}

		var a = $('#myform').serialize();
		// console.log('sent', a);
		$.post('api/api.php', a, function(data) {
			// console.log('sent', data);
			var final_data = JSON.parse(data);
			if(final_data.valid) {
				swal({
					type: 'success',
					title: 'נשלח בהצלחה',
					text: final_data.message,
				});
				document.getElementById('myform').reset();

				// setTimeout(function(){
				// 	window.location.href = 'thankyou.html';
				// },1500);

			}
			else {
				swal({
					title: 'שגיאה',
					text: final_data.message,
					type: 'error',
					confirmButtonText: 'OK'
				})
			}
		});
});

function validForm(form) {
	for (var i = 0; i < form.length; i++) {
		var element = form[i];
		if (!element.value) {
			return false;
		}
	}
	return true;
}

});