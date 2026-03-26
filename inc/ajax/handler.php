<?php

/**
 * Executes all the AJAX methods of the theme.
 *
 * @link       https://wowfactormedia.ca/
 * @since      1.0.0
 *
 * @package    MassLoad
 * @subpackage MassLoad/Inc/AJAX
 * @category   MassLoad/Inc/AJAX/Core_Ajax
 * @license    http://opensource.org/licenses/gpl-license.php  GNU Public License
 */


namespace Core\AJAX;

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Executes all the AJAX methods of the theme.
 *
 * @subpackage MassLoad/Inc/AJAX
 * @category   MassLoad/Inc/AJAX/Core_Ajax
 * @author     Wow Factor Media
 */
class Core_Ajax {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        add_action( 'init', array( $this, 'init_ajax' ) );
	}

    /**
	 * Enqueues the Admins Ajax
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function init_ajax() {
		add_action(
			'wp_ajax_core_ajax',
			array(
				$this,
				'core_ajax',
			)
		);
		add_action(
			'wp_ajax_nopriv_core_ajax',
			array(
				$this,
				'core_ajax',
			)
		);
	}

    /**
	 * This method initialize admin ajax.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function core_ajax() {
		header( 'Content-Type: application/json' );
        $ajax = new \Core\AJAX\Core_Ajax_Handler();

        $handler = filter_input(
            INPUT_POST,
            'handler',
            FILTER_SANITIZE_STRING
        );

        if ( 'post_object_filter' === $handler ) {
            $ajax->post_object_filter();
        }

		die();
	}

}