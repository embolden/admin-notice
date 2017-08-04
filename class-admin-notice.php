<?php
/**
 * Prevent this file from being accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A helper class to display WordPress admin notices.
 *
 * This helper class was born out of a need to pass a customized message to an
 * admin notice without created a separate callback and duplicating the basics.
 * It was adapted from an answer by the StackOverflow user TheDeadMedic.
 *
 * @author Matt Keehner
 * @link https://wordpress.stackexchange.com/a/224501/33812
 * @package WordPress
 * @subpackage Admin Notices
 * @version 1.0.0
 */
class Admin_Notice {

	/**
	 * The text of the message to display.
	 *
	 * @var string
	 */
	private $message;

	/**
	 * The WordPress class to attach to the notice.
	 *
	 * @var string
	 */
	private $notice_type;

	/**
	 * If the notice can be dismissed by the end-user.
	 *
	 * @var bool
	 */
	private $dismissible;

	/**
	 * Create an instance of the Admin_Notice class.
	 *
	 * @param string $message
	 * @param string $notice_type
	 * @param boolean $dismissible
	 */
	function __construct( $message, $notice_type = 'notice-error', $dismissible = true ) {
		/**
		 * A list of the classes that the WordPress admin theme supports.
		 *
		 * notice-error will display a white background with a red left border
		 * notice-info will display a white background with a blue left border
		 * notice-success will display a white background with a green left border
		 * notice-warning will display a white background with a yellow left border
		 *
		 * @var array $valid_notice_types
		 */
		$valid_notice_types = [
			'notice-error',
			'notice-info',
			'notice-success',
			'notice-warning',
		];

		/**
		 * Allow the array of valid notice types to be over-ridden.
		 *
		 * @param array $valid_notice_types
		 */
		$valid_notice_types = apply_filters( 'admin_notice_valid_notice_types', $valid_notice_types );

		/**
		 * Provide a default style if an invalid notice type is applied.
		 */
		if( ! in_array( $notice_type, $valid_notice_types ) ) {
			$notice_type = 'notice-error';
		}

		/**
		 * Make admin notices dismissible by default if an invalid value is provided.
		 */
		if( ! is_bool( $dismissible ) ) {
			$dismissible = true;
		}

		$this->message     = $message;
		$this->notice_type = $notice_type;
		$this->dismissible = $dismissible;

		/**
		 * Attach the render function to the unconditional admin notic action.
		 *
 		 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
		 */
		add_action( 'all_admin_notices', array( $this, 'render' ) );
	}

	/**
	 * Print the notice markup.
	 *
	 * @return void
	 */
	function render() {
		printf( '<div class="notice %1$s %2$s"><p>%3$s</p></div>',
			esc_attr( $this->notice_type ),
			esc_attr( ($this->dismissible ? 'is-dismissible' : '') ),
			esc_html( $this->message )
		);
	}
}
