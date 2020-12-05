$(document).ready(function() {



	// $('#ajax').load("inc/view.php", {_: new Date().getTime(),id: 5});
	var $x;
	var $y = 0;
	var $auto_refresh = true;
	// document.title = 'ProTempMail';
	// 
	setInterval(function(){
		if ($auto_refresh == true) {
			if ($y == 0) {
				$x = setInterval(function(){
					if($y > 100){
						$y=0;
						$('#progress').css('width', $y+'%');
						clearInterval($x);
					}else{
						$y++;
						$('#progress').css('width', $y+'%');
					}
				},5);
			}else if($y > 100){
				$y=0;
				$('#progress').css('width', $y+'%');
				clearInterval($x);
			}

			// $('#progress').css('width', '0%');
			$('#ajax').load("inc/list.php", {_: new Date().getTime()},function(){
				var counter = $('#mail_list').attr('data-counter');
				document.title = 'ProTempMail ('+counter+')';
			});
			console.log('auto refresh');
		}
	},7000);

	$('#ajax').load("inc/list.php?old", {_: new Date().getTime()},function() {
		var new_email = $('#mail_list').attr('data-email');
		var counter = $('#mail_list').attr('data-counter');
		document.title = 'ProTempMail ('+counter+')';

		$('#email_id').val(new_email);
		$('#email_id').attr('data-value',new_email);
		$('#item_to_copy').attr('data-clipboard-text',new_email);
	});

    var clipboard = new Clipboard('.item');
	clipboard.on('success', function(e) {
	    console.info('Action:', e.action);
	    // console.info('Text:', e.text);
	    // console.info('Trigger:', e.trigger);
	    e.clearSelection();
	});
	clipboard.on('error', function(e) {
	    console.error('Action:', e.action);
	    // console.error('Trigger:', e.trigger);
	});

	$('#logo').click(function(event) {
		$('#ajax').load("inc/list.php", {_: new Date().getTime()},function(){
			var counter = $('#mail_list').attr('data-counter');
			document.title = 'ProTempMail ('+counter+')';
		});
		$auto_refresh = true;
	});

	$('.item').click(function(event) {
		var $target = $(this).attr('data-target');
		if ($target == 'copy') {
			console.log('copy');
			$('#email_id').keyup();
		}else if($target == 'refresh'){
			console.log('refresh');
			clearInterval($x);
			$x = setInterval(function(){
				if($y > 100){
					$y=0;
					$('#progress').css('width', $y+'%');
					clearInterval($x);
				}else{
					$y++;
					$('#progress').css('width', $y+'%');
				}
			},5);
			$('#ajax').load("inc/list.php", {_: new Date().getTime()},function(){
				var counter = $('#mail_list').attr('data-counter');
				document.title = 'ProTempMail ('+counter+')';
			});
			$auto_refresh = true;
		}else if($target == 'change'){
			console.log('change');
			$('#ajax').load("inc/change.php", {_: new Date().getTime()},function() {
				$auto_refresh = false;
			});
		}else if($target == 'delete'){
			console.log('delete');
			$('#ajax').load("inc/list.php?new", {_: new Date().getTime()},function() {
				var new_email = $('#mail_list').attr('data-email');
				var counter = $('#mail_list').attr('data-counter');
				document.title = 'ProTempMail ('+counter+')';
				$('#email_id').val(new_email);
				$('#email_id').attr('data-value',new_email);
				$('#item_to_copy').attr('data-clipboard-text',new_email);
			});
		}
	});

	$('#email_id').keyup(function(event) {
		$('#email_id').val($('#email_id').attr('data-value')).select();
	});
	$('#email_id').mouseup(function(event) {
		$('#email_id').val($('#email_id').attr('data-value')).select();
	});

	$('#ajax').delegate('.view_msg', 'click', function(event) {
		var $msgID = $(this).attr('data-message-id');
		$('#ajax').load("inc/view.php", {_: new Date().getTime(), id: $msgID},function() {
			$auto_refresh = false;
		});
	});

	$('#ajax').delegate('#back_btn', 'click', function(event) {
		$('#ajax').load("inc/list.php", {_: new Date().getTime()},function() {
			var counter = $('#mail_list').attr('data-counter');
			document.title = 'ProTempMail ('+counter+')';
			$auto_refresh = true;
		});
	});

	$('#ajax').delegate('#source_btn', 'click', function(event) {
		var $target = $(this).attr('data-target');
		// console.log($target);
		window.open('source/'+$target,'_blank');
	});


	$('#ajax').delegate('#delete_btn', 'click', function(event) {
		var $target = $(this).attr('data-target');
		$('#ajax').load("inc/list.php?del="+$target, {_: new Date().getTime()},function() {
			var counter = $('#mail_list').attr('data-counter');
			document.title = 'ProTempMail ('+counter+')';
			$auto_refresh = true;
		});
	});

	$('#ajax').delegate('#download_btn', 'click', function(event) {
		var $target = $(this).attr('data-target');
		window.open('download/'+$target,'_blank');
		// $('#ajax').load("inc/download.php?id="+$target, {_: new Date().getTime()});
	});


	$('#lang_btn').click(function(event) {
		$('#lang_list').toggle();
	});




	$('#ajax').delegate('#save_change', 'click', function(event) {
        if (/[0-9a-zA-Z\.-_]{1,50}/.test($('#login_change').val()) == false) {
            $('#login_change').focus();
            return false;
        };
		
		$('#ajax').load("inc/list.php?change", {
			_: new Date().getTime(),
			login: $('#login_change').val(),
			domain: $('#domain_change').val()
		},function(){
			var new_email = $('#mail_list').attr('data-email');
			var counter = $('#mail_list').attr('data-counter');
			document.title = 'ProTempMail ('+counter+')';
			$('#email_id').val(new_email);
			$('#email_id').attr('data-value',new_email);
			$('#item_to_copy').attr('data-clipboard-text',new_email);
		});
		$auto_refresh = true;
	});


	$('.lang_item').click(function(event) {
		var $target = $(this).attr('data-lang');
		document.cookie = "language="+$target;
		location.reload(); 
	});

	$('#terms').click(function(event) {
		$('#ajax').load("inc/terms.php", {_: new Date().getTime()},function() {
			$auto_refresh = false;
		});
	});
	
	$('#faq').click(function(event) {
		$('#ajax').load("inc/faq.php", {_: new Date().getTime()},function() {
			$auto_refresh = false;
		});
	});

	$('#contact').click(function(event) {
		window.open('http://samirdjelal.info','_blank');
	});
		


});