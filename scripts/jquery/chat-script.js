$(document).ready(function(){
	
	// to toggle chat side bar
	$('#toggle-chat').click(function(){
		if ($('#chat-wrapper').is(':hidden')) {
			$('#chat-wrapper').toggle('slow');
			$('#toggle-chat-icon').attr('class', 'center-content fa fa-chevron-right');
		} else {
			$('#chat-wrapper').toggle('fast');
			$('#toggle-chat-icon').attr('class', 'center-content fa fa-chevron-left');
		}
	});
	
	$('#friends-aside ul li a').click(function(){
		if ($('#chat-wrapper').is(':hidden')) {
			$('#chat-wrapper').toggle('slow');
			$('#toggle-chat-icon').attr('class', 'center-content fa fa-chevron-right');
		}
	});
	
	// to add/send new message
	/*
	$('#enter-msg textarea').keypress(
    function(e){
        if (e.keyCode == 13) {
            e.preventDefault();
            var msg = $(this).val();
			$(this).val('');
			if(msg!='')
			$('<div class="msg_b">'+msg+'</div>').insertBefore('.msg_push');
			$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
        }
    });
	*/
	
});