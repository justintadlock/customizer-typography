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

	// Add the paragraph typo. section.
	$wp_customize->add_section( 'p_typography', 
		array( 'panel' => 'typography', 'title' => esc_html__( 'Paragraphs', 'ctypo' ) )
	);

	// Add the body typo. settings.
	// @todo Better sanitize_callback functions.
	$wp_customize->add_setting( 'p_font_family', array( 'default' => '',       'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_font_weight', array( 'default' => '400',    'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_font_style',  array( 'default' => 'normal', 'sanitize_callback' => 'sanitize_key',        'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_font_size',   array( 'default' => '16',     'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );
	$wp_customize->add_setting( 'p_line_height', array( 'default' => '32',     'sanitize_callback' => 'absint',              'transport' => 'postMessage' ) );

	// Add the body typo. control.
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
					'size'        => 'p_font_size',
					'weight'      => 'p_font_weight',
					'style'       => 'p_font_style',
					'line_height' => 'p_line_height'
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

	$p_family = get_theme_mod( 'p_font_family', '' );
	$p_weight = get_theme_mod( 'p_font_weight', '' );
	$p_style  = get_theme_mod( 'p_font_style',  '' );
	$p_size   = get_theme_mod( 'p_font_size',   '' );
	$p_line_h = get_theme_mod( 'p_line_height', '' );

	if ( ! $p_family && ! $p_weight && ! $p_style && ! $p_size && ! $p_line_h )
		return;

	$style           = '';
	$allowed_weights = array( 100, 300, 400, 500, 700, 900 );
	$allowed_styles  = array( 'normal', 'italic', 'oblique' );

	if ( $p_family )
		$style .= sprintf( "font-family: '%s';", esc_attr( $p_family ) );

	if ( $p_weight )
		$style .= sprintf( 'font-weight: %s;', in_array( absint( $p_weight ), $allowed_weights ) ? $p_weight : 400 );

	if ( $p_style )
		$style .= sprintf( 'font-style: %s;', in_array( $p_style, $allowed_styles ) ? $p_style : 'normal' );

	if ( $p_size )
		$style .= sprintf( 'font-size: %spx;', absint( $p_size ) );

	if ( $p_line_h )
		$style .= sprintf( 'line-height: %spx;', absint( $p_line_h ) );

	// Output the styles.
	echo "\n" . '<style type="text/css" id="ctypo-css">body.ctypo p{ ' . trim( $style ) . ' }</style>' . "\n";

	// Body class filter.
	add_filter( 'body_class', 'ctypo_body_class' );
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
