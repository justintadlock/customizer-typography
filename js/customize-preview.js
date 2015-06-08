jQuery( document ).ready( function() {

	/* === <p> === */

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

	/* === <h1> === */

	wp.customize(
		'h1_font_family',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h1' ).css( 'font-family', to );
				} 
			);
		}
	);

	wp.customize(
		'h1_font_weight',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h1' ).css( 'font-weight', to );
				} 
			);
		}
	);

	wp.customize(
		'h1_font_style',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h1' ).css( 'font-style', to );
				} 
			);
		}
	);

	wp.customize(
		'h1_font_size',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h1' ).css( 'font-size', to + 'px' );
				} 
			);
		}
	);

	wp.customize(
		'h1_line_height',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h1' ).css( 'line-height', to + 'px' );
				} 
			);
		}
	);

	/* === <h2> === */

	wp.customize(
		'h2_font_family',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h2' ).css( 'font-family', to );
				} 
			);
		}
	);

	wp.customize(
		'h2_font_weight',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h2' ).css( 'font-weight', to );
				} 
			);
		}
	);

	wp.customize(
		'h2_font_style',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h2' ).css( 'font-style', to );
				} 
			);
		}
	);

	wp.customize(
		'h2_font_size',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h2' ).css( 'font-size', to + 'px' );
				} 
			);
		}
	);

	wp.customize(
		'h2_line_height',
		function( value ) {
			value.bind( 
				function( to ) {
					jQuery( 'body.ctypo h2' ).css( 'line-height', to + 'px' );
				} 
			);
		}
	);

} ); // jQuery( document ).ready