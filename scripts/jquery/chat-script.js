$(document).ready(function(){
	
	// to toggle chat side bar
	$('#toggle-chat').click(function(){
		$('#chat-wrapper').toggle('slide');
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