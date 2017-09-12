<?php

/**
 * View Defined Constants - Admin class
 *
 * @package View Defined Constants
 * @subpackage View Defined Constants Admin
 */
class VWDFCN_Admin {


	// Properties
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Single class instance
	 */
	private static $instance;



	// Initialization
	// ---------------------------------------------------------------------------------------------------



	/**
	 * Retrieve previous instance or create new one
	 */
	public static function instance() {

		// Check instance
		if (!isset(self::$instance))
			self::$instance = new self;

		// Done
		return self::$instance;
	}



	/**
	 * Constructor
	 */
	private function __construct() {
		add_action('admin_menu', array(&$this, 'menu'));
	}



	// Admin page
	// ---------------------------------------------------------------------------------------------------



	/**
	 * WP Tools Menu
	 */
	public function menu() {
		add_submenu_page('tools.php', 'Defined Constants', 'Defined Constants', 'manage_options', 'vwdfcn-defined-constants', array(&$this, 'page'));
	}



	/**
	 * Plugin page
	 */
	public function page() {

		// Collect system constants
		$constants = @get_defined_constants();
		if (empty($constants) || !is_array($constants))
			$constants = array();

		// Display ?>
		<div class="wrap">

			<h1>Defined Constants</h1>

			<?php if (empty($constants)) : ?>

				<p>No constants found.</p>

			<?php else : ?>

				<script type="text/javascript">

					jQuery(document).ready(function($) {

						if (!String.prototype.trim) {
							(function() {
								// Make sure we trim BOM and NBSP
								var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
								String.prototype.trim = function() {
									return this.replace(rtrim, '');
								};
							})();
						}

						$('#vwdfcn-search-input').on('change keydown paste input', function() {

							var s = ('' + $(this).val()).trim().toLowerCase();

							if (s === s_old)
								return;

							s_old = s;

							if ('' === s) {
								p = p_all.slice(0);
								$('#vwdfcn-search-count').text(p.length);
								$('.vwdfcn-constant').show();
								return;
							}

							var i, v, f = 0;
							for (i in c) {
								v = c[i];
								if (0 === v.indexOf(s)) {
									f++;
									if (0 == p[i]) {
										p[i] = 1;
										$('#vwdfcn-constant-' + i).show();
									}
								} else if (1 == p[i]) {
									p[i] = 0;
									$('#vwdfcn-constant-' + i).hide();
								}
							}

							$('#vwdfcn-search-count').text(f);
						});

						var s_old = '';
						var c = <?php echo @json_encode(array_map('strtolower', array_keys($constants))); ?>;

						var k, p = [], p_all = [];
						for (k in c) {
							p[k] = 1;
							p_all[k] = 1;
						}
					});

				</script>

				<form onsubmit="return false;" class="wp-clearfix">

					<p style="float: left;">Constants found: <strong id="vwdfcn-search-count"><?php echo count($constants); ?></strong></p>

					<p class="search-box">
						<label class="screen-reader-text" for="vwdfcn-search-input">Search Constants:</label>
						<input type="search" id="vwdfcn-search-input" name="s" value="" placeholder="Search Constants" />
					</p>

				</form>

				<table class="wp-list-table widefat striped posts"><?php $i = -1; foreach ($constants as $name => $value) : $i++; ?>
					<tr id="vwdfcn-constant-<?php echo $i; ?>" class="vwdfcn-constant">
						<td style="width: 20%;"><?php echo esc_html($name); ?></td>
						<td><?php echo esc_html($value); ?></td>
					</tr>
				<?php endforeach; ?></table>

			<?php endif; ?>

		</div><?php
	}



}