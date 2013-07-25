jQuery(document).ready(function($) { 
	
	$('#header .menu, .superfish').superfish({
		delay:       100,								// 0.1 second delay on mouseout 
		animation:   {opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: false,								// disable drop shadows 
		autoArrows:  false,                             // disable generation of arrow mark-up 
		onBeforeShow: function() {
			var ulWidth = $(this).width();
			var liWidth = $(this).parent().width();
			if ( ulWidth > liWidth ) {
				var diff = ( ulWidth - liWidth ) / 2;
			}
			$(this).attr( 'style', 'margin-left: -' + diff + 'px;' ); 
			$(this).show(); 
			console.log( 'ul: '+ulWidth);
			console.log( 'li: '+liWidth);
			console.log( 'diff: '+diff);
			
			$('.menu li .sub-menu').css('overflow', 'visible');
			//$('.menu li .sub-menu:after').show('fast');
		},
	});
	
});