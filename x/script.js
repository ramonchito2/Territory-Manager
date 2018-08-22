var $ = jQuery;
$(document).ready(function(){

	$body = $('body');
	$mbutton = $('#menu-button');
	$mclose = $('#menu-close');
	$menu = $('#menu');
	$mainContainer = $('#main-container');
	$popup = $('#popup');

	/* Open-Close Menu */
	$mbutton.click(function(){
		$body.addClass('menuOpen');
	})
	$mclose.click(function(){
		$body.removeClass('menuOpen');
	})

	/* CHECKING IN TERRITORY(IES) */
	$('a.checkin').click(function(){
		/* ... single terr */
		if( !$(this).hasClass('all') ) {
			var details = $(this).find('.details'),
				name 	= details.attr('name'),
				id 		= details.attr('id'),
				tid		= details.attr('tid'),
				time	= details.attr('time'),
				msg 	= 'Are you sure you want check in Terr #'+tid+' for '+name+'?';
			openPop(msg,name,tid,id,time);
		} else { /* ... group of terrs */
			var id, tid = [], time = [],
				name  	= $(this).siblings('h3').text(),
				terrs 	= $(this).parent('.user').next('.tco').find('.terrDetails');
			terrs.each(function(ix, el){
				var d = $(this).find('.details');
				id = d.attr('id');
				tid.push(d.attr('tid'));
				time.push(d.attr('time'));
			});
			terrs = tid.join(',');
			msg = 'Are you sure you want check in all territories belonging to '+name+'? ( '+terrs+' )';
			openPop(msg,name,terrs,id,time);
		}
	})

	$('#pcontainer').find('span.yes').click(function(){
		$('#chIn').submit();
	})

	/* Open Popup */
	openPop = function(msg,name,tid,id,time) {
		$mainContainer.addClass('blur');
		$popup.addClass('show');

		if( msg !== "New Pub" ) {
			$popup.find('h3').text(msg).end()
			.find('form #uid').val(id).end()
			.find('form #tid').val(tid).end()
			.find('form #time').val(time);
		}
	}

	/* Resets popup form and hides stuff */
	resetPop = function() {
		$('#popup').find('h3').text('Nothing to see here...').end()
			.find('form input').val('');
		$('#popup').removeClass('show');
		$('#main-container').removeClass('blur');
	}

	/* Admin group filter */
	select = document.getElementById("group");
	if( select ) {
	    groupFilter = function() {
	        filter = select.value.toUpperCase();
	        values = document.querySelectorAll("#publisher option, #terr-select label, #all-checkedout .userWterrs");

	        // Loop through all values, and hide those who are in the requested group
	        for (i = 0; i < values.length; i++) {
	            value = values[i].getAttribute("group");
	            if (value) {
	            	// console.log(filter);
	                if( select.selectedOptions[0].hasAttribute('all') ) {
	                	values[i].classList.remove('hidden');
	                } else {
	                	valueMatch = value.toUpperCase().indexOf(filter) > -1;
	                	// console.log('value match is '+valueMatch);
	                	// clear publisher name value
	                	document.getElementById('publisher').value = '';
	                	if (valueMatch) {
	                	    values[i].classList.remove('hidden');
	                	} else {
	                	    values[i].classList.add('hidden');
	                	}
	                }
	            }
	        }
	    }
	}

})