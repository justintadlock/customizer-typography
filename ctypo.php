<?php
/**
 * Plugin Name: Customizer Typography
 * Plugin URI:  https://github.com/justintadlock/customizer-typography
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 * Description: Proof-of-concept and testing tool for building typography controls in the customizer.
 * Version:	1.0.0-dev
 * License:     GNU General Public License v2.0 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

# Register our customizer panels, sections, settings, and controls.
add_action( 'customize_register', 'ctypo_customize_register', 15 );

# Load scripts and styles.
add_action( 'customize_controls_enqueue_scripts', 'ctypo_customize_controls_register_scripts' );
add_action( 'customize_preview_init',             'ctypo_customize_preview_enqueue_scripts'   );

# Add custom styles to `<head>`.
add_action( 'wp_head', 'ctypo_print_styles' );

/**
 * Register customizer panels, sections, settings, and controls.
 *
 * @since  1.0.0
 * @access public
 * @param  object  $wp_customize
 * @return void
 */
function ctypo_customize_register( $wp_customize ) {

	// Load customizer typography control class.
	require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'customize/control-typography.php' );

	// Register typography control JS template.
	$wp_customize->register_control_type( 'Customizer_Typo_Control_Typography' );

	/* === Testing === */

	// Add the typography panel.
	$wp_customize->add_panel( 'typography', array( 'priority' => 5, 'title' => esc_html__( 'Typography', 'ctypo' ) ) );

	// Add the `<p>` typography section.
	$wp_customize->add_section( 'p_typography', 
		array( 'panel' => 'typography', 'title' => esc_html__( 'Paragraphs', 'ctypo' ) )
	);

	// Add the headings typography section.
	$wp_customize->add_section( 'headings_typography', 
		array( 'panel' => 'typography', 'title' => esc_html__( 'Headings', 'ctypo' ) )
	);

	// Add the `<p>` typography settings.
	// @todo Better sanitize_callback functions.
	$wp_customize->add_setting( 'p_font_family', array( 'default' => 'Arial',  'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_font_weight', array( 'default' => '400',    'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_font_style',  array( 'default' => 'normal', 'sanitize_callback' => 'sanitize_key',        'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_font_size',   array( 'default' => '16',     'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_line_height', array( 'default' => '32',     'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );

	// Add the `<h1>` typography settings.
	// @todo Better sanitize_callback functions.
	$wp_customize->add_setting( 'h1_font_family', array( 'default' => 'Georgia', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'h1_font_weight', array( 'default' => '400',     'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'h1_font_style',  array( 'default' => 'normal',  'sanitize_callback' => 'sanitize_key',        'transport' => 'postMessage' ) );
	//$wp_customize->add_setting( 'h1_font_size',   array( 'default' => '28',      'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	//$wp_customize->add_setting( 'h1_line_height', array( 'default' => '42',      'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );

	// Add the `<h2>` typography settings.
	// @todo Better sanitize_callback functions.
	$wp_customize->add_setting( 'h2_font_family', array( 'default' => 'Georgia', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'h2_font_weight', array( 'default' => '400',     'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'h2_font_style',  array( 'default' => 'normal',  'sanitize_callback' => 'sanitize_key',        'transport' => 'postMessage' ) );
	//$wp_customize->add_setting( 'h2_font_size',   array( 'default' => '24',      'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	//$wp_customize->add_setting( 'h2_line_height', array( 'default' => '38',      'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );

	// Add the `<p>` typography control.
	$wp_customize->add_control(
		new Customizer_Typo_Control_Typography(
			$wp_customize,
			'p_typography',
			array(
				'label'       => esc_html__( 'Paragraph Typography', 'ctypo' ),
				'description' => __( 'Select how you want your paragraphs to appear.', 'ctypo' ),
				'section'     => 'p_typography',

				// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
				'settings'    => array(
					'family'      => 'p_font_family',
					'weight'      => 'p_font_weight',
					'style'       => 'p_font_style',
					'size'        => 'p_font_size',
					'line_height' => 'p_line_height'
				),

				// Pass custom labels. Use the setting key (above) for the specific label.
				'l10n'        => array(),
			)
		)
	);

	// Add the `<h1>` typography control.
	$wp_customize->add_control(
		new Customizer_Typo_Control_Typography(
			$wp_customize,
			'h1_typography',
			array(
				'label'       => esc_html__( 'Heading 1', 'ctypo' ),
				'description' => __( 'Select how heading 1 should appear.', 'ctypo' ),
				'section'     => 'headings_typography',

				// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
				'settings'    => array(
					'family'      => 'h1_font_family',
					'weight'      => 'h1_font_weight',
					'style'       => 'h1_font_style',
				//	'size'        => 'h1_font_size',
				//	'line_height' => 'h1_line_height'
				),

				// Pass custom labels. Use the setting key (above) for the specific label.
				'l10n'        => array(),
			)
		)
	);

	// Add the `<h2>` typography control.
	$wp_customize->add_control(
		new Customizer_Typo_Control_Typography(
			$wp_customize,
			'h2_typography',
			array(
				'label'       => esc_html__( 'Heading 2', 'ctypo' ),
				'description' => __( 'Select how heading 2 should appear.', 'ctypo' ),
				'section'     => 'headings_typography',

				// Tie a setting (defined via `$wp_customize->add_setting()`) to the control.
				'settings'    => array(
					'family'      => 'h2_font_family',
					'weight'      => 'h2_font_weight',
					'style'       => 'h2_font_style',
				//	'size'        => 'h2_font_size',
				//	'line_height' => 'h2_line_height'
				),

				// Pass custom labels. Use the setting key (above) for the specific label.
				'l10n'        => array(),
			)
		)
	);

	/* === End Testing === */
}

/**
 * Register control scripts/styles.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ctypo_customize_controls_register_scripts() {

	$uri = trailingslashit( plugin_dir_url( __FILE__ ) );

	wp_register_script( 'ctypo-customize-controls', esc_url( $uri . 'js/customize-controls.js' ), array( 'customize-controls' ) );

	wp_register_style( 'ctypo-customize-controls', esc_url( $uri . 'css/customize-controls.css' ) );
}

/**
 * Load preview scripts/styles.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ctypo_customize_preview_enqueue_scripts() {

	$uri = trailingslashit( plugin_dir_url( __FILE__ ) );

	wp_enqueue_script( 'ctypo-customize-preview', esc_url( $uri . 'js/customize-preview.js' ), array( 'jquery' ) );
}

/**
 * Add custom body class to give some more weight to our styles.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ctypo_print_styles() {

	$style = $_p_style = $_h1_style = $_h2_style = '';

	$allowed_weights = array( 100, 300, 400, 500, 700, 900 );
	$allowed_styles  = array( 'normal', 'italic', 'oblique' );

	/* === <p> === */

	$p_family = get_theme_mod( 'p_font_family', '' );
	$p_weight = get_theme_mod( 'p_font_weight', '' );
	$p_style  = get_theme_mod( 'p_font_style',  '' );
	$p_size   = get_theme_mod( 'p_font_size',   '' );
	$p_line_h = get_theme_mod( 'p_line_height', '' );

	if ( $p_family )
		$_p_style .= sprintf( "font-family: '%s';", esc_attr( $p_family ) );

	if ( $p_weight )
		$_p_style .= sprintf( 'font-weight: %s;', in_array( absint( $p_weight ), $allowed_weights ) ? $p_weight : 400 );

	if ( $p_style )
		$_p_style .= sprintf( 'font-style: %s;', in_array( $p_style, $allowed_styles ) ? $p_style : 'normal' );

	if ( $p_size )
		$_p_style .= sprintf( 'font-size: %spx;', absint( $p_size ) );

	if ( $p_line_h )
		$_p_style .= sprintf( 'line-height: %spx;', absint( $p_line_h ) );

	if ( $_p_style )
		$_p_style = sprintf( 'body.ctypo p { %s }', $_p_style );

	/* === <h1> === */

	$h1_family = get_theme_mod( 'h1_font_family', '' );
	$h1_weight = get_theme_mod( 'h1_font_weight', '' );
	$h1_style  = get_theme_mod( 'h1_font_style',  '' );
	$h1_size   = get_theme_mod( 'h1_font_size',   '' );
	$h1_line_h = get_theme_mod( 'h1_line_height', '' );

	if ( $h1_family )
		$_h1_style .= sprintf( "font-family: '%s';", esc_attr( $h1_family ) );

	if ( $h1_weight )
		$_h1_style .= sprintf( 'font-weight: %s;', in_array( absint( $h1_weight ), $allowed_weights ) ? $h1_weight : 400 );

	if ( $h1_style )
		$_h1_style .= sprintf( 'font-style: %s;', in_array( $h1_style, $allowed_styles ) ? $h1_style : 'normal' );

	if ( $h1_size )
		$_h1_style .= sprintf( 'font-size: %spx;', absint( $h1_size ) );

	if ( $h1_line_h )
		$_h1_style .= sprintf( 'line-height: %spx;', absint( $h1_line_h ) );

	if ( $_h1_style )
		$_h1_style = sprintf( 'body.ctypo h1 { %s }', $_h1_style );

	/* === <h2> === */

	$h2_family = get_theme_mod( 'h2_font_family', '' );
	$h2_weight = get_theme_mod( 'h2_font_weight', '' );
	$h2_style  = get_theme_mod( 'h2_font_style',  '' );
	$h2_size   = get_theme_mod( 'h2_font_size',   '' );
	$h2_line_h = get_theme_mod( 'h2_line_height', '' );

	if ( $h2_family )
		$_h2_style .= sprintf( "font-family: '%s';", esc_attr( $h2_family ) );

	if ( $h2_weight )
		$_h2_style .= sprintf( 'font-weight: %s;', in_array( absint( $h2_weight ), $allowed_weights ) ? $h2_weight : 400 );

	if ( $h2_style )
		$_h2_style .= sprintf( 'font-style: %s;', in_array( $h2_style, $allowed_styles ) ? $h2_style : 'normal' );

	if ( $h2_size )
		$_h2_style .= sprintf( 'font-size: %spx;', absint( $h2_size ) );

	if ( $h2_line_h )
		$_h2_style .= sprintf( 'line-height: %spx;', absint( $h2_line_h ) );

	if ( $_h2_style )
		$_h2_style = sprintf( 'body.ctypo h2 { %s }', $_h2_style );

	/* === Output === */

	// Join the styles.
	$style = join( '', array( $_p_style, $_h1_style, $_h2_style ) );

	// Output the styles.
	if ( $style ) {
		echo "\n" . '<style type="text/css" id="ctypo-css">' . $style . '</style>' . "\n";

		// Body class filter.
		add_filter( 'body_class', 'ctypo_body_class' );
	}
}

/**
 * Add custom body class to give some more weight to our styles.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $classes
 * @return array
 */
function ctypo_body_class( $classes ) {
	return array_merge( $classes, array( 'ctypo' ) );
}
