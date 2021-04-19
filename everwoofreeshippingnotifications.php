<?php
/*
Plugin URI: https://www.team-ever.com
Plugin Name: Everwoo Free Shipping Notifications
Description: Use this plugin for Showing a ‘Add --- more for free shipping’ 
Version: 1.1.2
Author: Ever Team
License: Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
Text Domain: everwoofreeshippingnotifications
Domain Path:  /languages
Author URI: https://www.team-ever.com/
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class everwoofreeshippingnotifications
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Plugin Details
        $plugin               = new stdClass;
        $plugin->name         = 'everwoofreeshippingnotifications'; // Plugin Folder
        $plugin->displayName  = 'Everwoo Free Shipping Notifications'; // Plugin Name
        $plugin->version      = '1.1.2';
        $plugin->folder       = plugin_dir_path(__FILE__);
        $plugin->url          = plugin_dir_url(__FILE__);
    }
}
/**
 * Loads plugin textdomain
 */
function everwoofreeshippingnotifications_plugins_loaded() {
    load_plugin_textdomain('everwoofreeshippingnotifications', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'everwoofreeshippingnotifications_plugins_loaded', 0);
function everwoofreeshippingnotifications_add_admin_menu() {
    add_options_page('Everwoo Free Shipping Notifications', 'Everwoo Free Shipping Notifications', 'manage_options', 'ever_wp_everwoofreeshippingnotifications', 'everwoofreeshippingnotifications_options_page');
}
add_action('admin_menu', 'everwoofreeshippingnotifications_add_admin_menu');
/**
 * Add plugin action links.
 *
 * Add a link to the settings page on the plugins.php page.
 *
 * @since 1.0.0
 *
 * @param  array  $links List of existing plugin action links.
 * @return array         List of modified plugin action links.
 */
function everwoofreeshippingnotifications_action_links($links) {
    $icon = plugin_dir_url(__FILE__) . 'assets/img/logo.ico';
    $logo = '<img src="' . $icon . '" class="img img-fluid icon-team-ever" alt="WooCommerce plugin by Team Ever" title="WooCommerce plugin by Team Ever" style="width:20px;height:20px;">';
    $links = array_merge(array(
        '<a href="' . esc_url(admin_url('/admin.php?page=ever_wp_everwoofreeshippingnotifications')) . '">' . $logo . __('Settings', 'everwoofreeshippingnotifications') . '</a>'
    ), $links);
    return $links;
}
// Action links
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'everwoofreeshippingnotifications_action_links');
function everwoofreeshippingnotifications_settings_init() {
    register_setting('pluginPage', 'everwoofreeshippingnotifications_settings');

    if (!class_exists('WooCommerce')) {
        // WooCommerce not installed
    }

    add_settings_section(
        'everwoofreeshippingnotifications_pluginPage_section',
        __('WordPress & WooCommerce settings', 'everwoofreeshippingnotifications'),
        'everwoofreeshippingnotifications_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'everwoofreeshippingnotifications_message_before_amount',
        __('Message before amount', 'everwoofreeshippingnotifications'),
        'everwoofreeshippingnotifications_message_before_amount_render',
        'pluginPage',
        'everwoofreeshippingnotifications_pluginPage_section'
    );

    add_settings_field(
        'everwoofreeshippingnotifications_message_cart',
        __('Message after amount', 'everwoofreeshippingnotifications'),
        'everwoofreeshippingnotifications_message_cart_render',
        'pluginPage',
        'everwoofreeshippingnotifications_pluginPage_section'
    );
}

add_action('admin_init', 'everwoofreeshippingnotifications_settings_init');

/**
 * Render message before amount 
 */
function everwoofreeshippingnotifications_message_before_amount_render() {
    $options = get_option('everwoofreeshippingnotifications_settings');
    if (isset($options['everwoofreeshippingnotifications_message_before_amount'])
        && !empty($options['everwoofreeshippingnotifications_message_before_amount'])
    ) {
        $value = $options['everwoofreeshippingnotifications_message_before_amount'];
    } else {
        $value = '';
    }
    ?>
    <input type="text" name="everwoofreeshippingnotifications_settings[everwoofreeshippingnotifications_message_before_amount]" value="<?php echo $value; ?>">
    <?php
}
/**
 * Render message after amount shipping cart
 */
function everwoofreeshippingnotifications_message_cart_render() {
    $options = get_option('everwoofreeshippingnotifications_settings');
    if (
        isset($options['everwoofreeshippingnotifications_message_cart'])
        && !empty($options['everwoofreeshippingnotifications_message_cart'])
    ) {
        $value = $options['everwoofreeshippingnotifications_message_cart'];
    } else {
        $value = '';
    }
?>
    <input type="text" name="everwoofreeshippingnotifications_settings[everwoofreeshippingnotifications_message_cart]" value="<?php echo $value; ?>">
<?php
}
function everwoofreeshippingnotifications_settings_section_callback() {
    if (!class_exists('WooCommerce')) {
        echo __('WooCommerce settings wont work until you install this plugin', 'everwoofreeshippingnotifications');
    } else {
        echo __('Please set form settings to allow or dissallow Everwoo Free Shipping Notifications on your WordPress site', 'everwoofreeshippingnotifications');
    }
}
function everwoofreeshippingnotifications_options_page() {
    // Useful : use var_dump($options) for seeing array of settings values
    $options = get_option('everwoofreeshippingnotifications_settings');
    ?>
    <div class="jumbotron">
        <a href="https://www.team-ever.com/contact" target="_blank"><img src="https://www.team-ever.com/wp-content/uploads/2016/08/Logo-full.png" style="float:left;"></a>
        <h1><?php _e('everwoofreeshippingnotifications settings', 'everwoofreeshippingnotifications'); ?></h1>
        <p><?php _e('Please set form settings to allow or dissallow everwoofreeshippingnotifications on your WordPress site', 'everwoofreeshippingnotifications'); ?></p>
        <p><a href="https://www.team-ever.com/contact" target="_blank"><?php __('Feel free contact us for support or updates', 'everwoofreeshippingnotifications'); ?></a></p>
       
        <ul class="everul">
            <li><?php echo dirname(__FILE__); ?>/everwoofreeshippingnotifications/</li>
        </ul>
    </div>
    <style type="text/css">
        .everul li {
            list-style-type: circle;
            list-style-position: inside;
        }
    </style>
    <form action='options.php' method='post' id="ewpwPlugin">
        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>
    </form>

    <?php
    if (class_exists('WooCommerce')) {
        if (isset($_POST['setAmountForFreeShippin']) && check_admin_referer('setAmountForFreeShippin_clicked')) {
            eversetAmountForFreeShippin();
        }
    ?>
    <?php
    }
}
function everSetAmountForFreeShippin() {
	if ( ! is_cart() && ! is_checkout() ) { 
		return;
	}

	$packages = WC()->cart->get_shipping_packages();
	$package = reset( $packages );
	$zone = wc_get_shipping_zone( $package );

	$cart_total = WC()->cart->get_displayed_subtotal();
	if ( WC()->cart->display_prices_including_tax() ) {
		$cart_total = round( $cart_total - ( WC()->cart->get_discount_total() + WC()->cart->get_discount_tax() ), wc_get_price_decimals() );
	} else {
		$cart_total = round( $cart_total - WC()->cart->get_discount_total(), wc_get_price_decimals() );
	}
	foreach ( $zone->get_shipping_methods( true ) as $k => $method ) {
		$min_amount = $method->get_option( 'min_amount' );
		if ( $method->id == 'free_shipping' && ! empty( $min_amount ) && $cart_total < $min_amount ) {
			$remaining = $min_amount - $cart_total;
            $options = get_option( 'everwoofreeshippingnotifications_settings' );
			wc_add_notice( $message= ($options['everwoofreeshippingnotifications_message_before_amount'].'&nbsp; '.wc_price( $remaining ).' &nbsp;'.$options['everwoofreeshippingnotifications_message_cart']), 'success' ) ;
		}
	}
}
add_action( 'woocommerce_before_cart', 'everSetAmountForFreeShippin', 10 );
