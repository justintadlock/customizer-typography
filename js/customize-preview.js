jQuery( document ).ready( function() {

	wp.customize(
		'p_font_family',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo p' ).css( 'font-family', to );
				} 
			);
		}
	);

	wp.customize(
		'p_font_weight',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo p' ).css( 'font-weight', to );
				} 
			);
		}
	);

	wp.customize(
		'p_font_style',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo p' ).css( 'font-style', to );
				} 
			);
		}
	);

	wp.customize(
		'p_font_size',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo p' ).css( 'font-size', to + 'px' );
				} 
			);
		}
	);

	wp.customize(
		'p_line_height',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo p' ).css( 'line-height', to + 'px' );
				} 
			);
		}
	);

} ); // jQuery( document ).ready