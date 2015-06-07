( function( api ) {

	api.controlConstructor['typography'] = api.Control.extend( {
		ready: function() {
			var control = this;

			control.container.on( 'change', '.typography-font-family select',
				function() {
					control.settings['family'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.typography-font-weight select',
				function() {
					control.settings['weight'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.typography-font-style select',
				function() {
					control.settings['style'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.typography-font-size input',
				function() {
					control.settings['size'].set( jQuery( this ).val() );
				}
			);

			control.container.on( 'change', '.typography-line-height input',
				function() {
					control.settings['line_height'].set( jQuery( this ).val() );
				}
			);
		}
	} );

} )( wp.customize );