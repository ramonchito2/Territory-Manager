var $ = jQuery;
$(document).ready(function(){

	$mainContainer = $('#main-container');
	$popup = $('#popup');

	/* CHECKING IN TERRITORY(IES) */
	$('a.checkin').click(function(){
		/* ... single terr */
		if( !$(this).hasClass('all') ) {
			var details = $(this).find('.details'),
				name 	= details.attr('name'),
				id 		= details.attr('id'),
				tid		= details.attr('tid'),
				msg 	= 'Are you sure you want check in Terr #'+tid+' for '+name+'?';
			openPop(msg,name,tid,id);
		} else { /* ... group of terrs */
			var id, tid = [],
				name = $(this).siblings('h3').text(),
				terrs = $(this).parent('.user').next('.tco').find('.terrDetails');
			terrs.each(function(ix, el){
				var d = $(this).find('.details');
				id = d.attr('id');
				tid.push(d.attr('tid'));
			});
			terrs = tid.join(',');
			msg = 'Are you sure you want check in all territories belonging to '+name+'? ( '+terrs+' )';
			openPop(msg,name,terrs,id);
		}
	})

	$('#pcontainer').find('span.yes').click(function(){
		$('#chIn').submit();
	})

	/* Open Popup */
	openPop = function(msg,name,tid,id) {
		$mainContainer.addClass('blur');
		$popup.addClass('show')
			.find('h3').text(msg).end()
			.find('form #uid').val(id).end()
			.find('form #tid').val(tid);
	}

	/* Resets popup form and hides stuff */
	resetPop = function() {
		$('#popup').find('h3').text('Nothing to see here...').end()
			.find('form input').val('');
		$('#popup').removeClass('show');
		$('#main-container').removeClass('blur');
	}


})