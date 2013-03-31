<?php
/**
 * Plugin Name: WooCommerce Ipaymu Payment Gateway
 * Plugin URI: http://masedi.net/wordpress/plugins/woocommerce-ipaymu-gateway.html
 * Description: WooCommerce Ipaymu Gateway is a fully-working Indonesia Payment Gateway (Ipaymu) for WooCommerce Wordpress store. Tested on WordPress 3.5.1 and WooCommerce 2.0.3.
 * Author: MasEDI
 * Author URI: http://masedi.net/
 * Version: 1.2
 * License: GPLv2 or later
 * Text Domain: wcipaymu
 * Domain Path: /languages/
 **/

/**
 * Prevent from direct access.
 **/
if (! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * WooCommerce fallback notice.
 **/
function ipaymu_woocommerce_fallback_notice() {
	$message = '<div class="error"><p>' . __('<strong><a href="https://my.ipaymu.com?rid=masedi">WooCommerce Ipaymu Gateway</a></strong> plugin depends on the last version of <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> to work!' , 'wcipaymu') . '</p></div>';
	echo $message;
}

/**
 * WooCommerce Ipaymu Gateway initialize
 * Init gateway functions when plugin loaded.
 **/
function ipaymu_gateway_init() {
	if (! class_exists('WC_Payment_Gateway')) {
		add_action('admin_notices', 'ipaymu_woocommerce_fallback_notice');
		return;
	}
	
	/**
	 * Load textdomain translations.
	 **/
	load_plugin_textdomain('wcipaymu', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	
	/**
	 * WC Ipaymu Gateway Class.
	 *
	 * Built the Ipaymu Gateway method.
	 **/
	class WC_Gateway_Ipaymu extends WC_Payment_Gateway {

		/**
		* Gateway's Constructor.
		*
		* @return void
		**/
		public function __construct() {
			global $woocommerce;

			// Define gateway setting variables.
			$this->id				= 'wcipaymu';
			$this->icon				= plugins_url('images/ipaymu_button_co.png', __FILE__);
			$this->has_fields		= false;
			$this->method_title		= __('Ipaymu Checkout', 'wcipaymu');
			$this->gateway_url		= 'https://my.ipaymu.com/payment.htm';
			$this->gateway_trx_url	= 'https://my.ipaymu.com/api/CekTransaksi.php';
			$this->bca_kurs_url		= 'http://www.bca.co.id/en/biaya-limit/kurs_counter_bca/kurs_counter_bca_landing.jsp';
			$this->notify_url		= str_replace('https:', 'http:', add_query_arg('wc-api', 'WC_Gateway_Ipaymu', home_url('/')));
			$this->ipaymu_fee		= 0.01; // Ipaymu transaction fee <!--do not change-->
			
			// Load the form fields.
			$this->init_form_fields();

			// Load the settings.
			$this->init_settings();

			// Define user setting variables.
			$this->enabled			= $this->get_option('enabled');
			$this->title			= $this->get_option('title');
			$this->description		= $this->get_option('description');
			$this->debug			= $this->get_option('debug');
			//$this->notification		= $this->get_option('notification');
			//$this->notify_email		= $this->get_option('notify_email');
			$this->ipaymu_username	= $this->get_option('ipaymu_username');
			$this->ipaymu_apikey	= $this->get_option('ipaymu_apikey');
			$this->paypal_enabled	= $this->get_option('paypal_enabled');
			$this->paypal_email		= $this->get_option('paypal_email');
			$this->invoice_prefix	= $this->get_option('invoice_prefix');
			$this->currency_rate	= $this->get_option('currency_rate');
			//$this->credit_link		= $this->get_option('credit_link');
			$this->credit_link		= 'yes';

			// Add actions.
			add_action('valid_ipaymu_gateway_request', array(&$this, 'successful_request'));
			add_action('woocommerce_receipt_wcipaymu', array(&$this, 'receipt_page'));
			add_action('woocommerce_after_checkout_form', array(&$this, 'masedi_credits_link'));
			
			// For backward compatibility with WC 1.6.x
			if (version_compare(WOOCOMMERCE_VERSION, '2.0', '<')) {
				// Save settings
				if (is_admin()) {
					add_action('woocommerce_update_options_payment_gateways_' . $this->id, array(&$this, 'process_admin_options'));
				}
				
				add_action('init', array(&$this, 'check_gateway_response'));
			
			} // WC 2.0.x
			else {
				// Save settings
				if (is_admin()) {
					add_action('woocommerce_update_options_payment_gateways_' . $this->id, array(&$this, 'process_admin_options'));
				}
				
				// Ipaymu listener API hooks since WC v2.0.x
				add_action('woocommerce_api_' . strtolower(get_class($this)), array($this, 'check_gateway_response'));
			}
			
			// Checking if api_key is not empty.
			$this->ipaymu_apikey == '' ? add_action('admin_notices', array(&$this, 'api_key_missing_message')) : '';

			// Checking if valid for use.
			//$this->enabled = ('yes' == $this->get_option('enabled']) && !empty($this->ipaymu_apikey) && $this->is_valid_for_use();
			if (!$this->is_valid_for_use() || empty($this->ipaymu_apikey)) $this->enabled = 'no';
			
			// Checking if SSL is enabled and notify the user.
			if (get_option('woocommerce_force_ssl_checkout') =='no' && $this->enabled) add_action('admin_notices', array(&$this, 'forcessl_missing_message'));

			// Active logs.
			if ($this->debug == 'yes') $this->log = $woocommerce->logger();
		}

		/**
		 * Checking if this gateway is enabled and available in the user's country.
		 *
		 * @access public
		 * @return bool
		 **/
		function is_valid_for_use() {
			// add another supported currency here
			$supported_currencies = array('IDR', 'USD');
			
			if (!in_array(get_woocommerce_currency(), $supported_currencies)) {
				return false;
			}
			return true;
		}

		/**
		* Admin Panel Options
		* - Options for bits like 'title' and availability on a country-by-country basis.
		*
		* @since 1.0.0
		**/
		public function admin_options() {
			?>
			<h3><?php _e('WooCommerce Ipaymu Gateway', 'wcipaymu'); ?></h3>
			<p><?php _e('WooCommerce Ipaymu Gateway works by sending the user to Ipaymu to enter their payment information.', 'wcipaymu'); ?></p>
			<table class="form-table">
			<?php
			if ($this->is_valid_for_use()) :
				// Generate the HTML For the settings form.
				$this->generate_settings_html();
			else :
			?>
				<div class="inline error"><p><strong><?php _e('Gateway Disabled', 'wcipaymu'); ?></strong>: 
				<?php echo sprintf(__('WooCommerce Ipaymu Gateway does not support your store currency. Current supported currencies: Indonesia Rupiah (IDR) and US Dollar (USD). <a href="%s">Click here to configure your currency!</a>', 'wcipaymu'), admin_url('admin.php?page=woocommerce_settings&tab=general')) ?>
				</p></div>
			<?php
			endif;
			?>
			</table><!--/.form-table-->
			<?php
		}

		/**
		 * Initialise Gateway Settings Form Fields.
		 *
		 * @access public
		 * @return void
		 **/
		function init_form_fields() {
		
			$this->form_fields = array(
				'enabled' => array(
					'title' => __('Enable/Disable', 'wcipaymu'),
					'type' => 'checkbox',
					'label' => __('Enable Ipaymu payment gateway.', 'wcipaymu'),
					'default' => 'yes'
				),
				'title' => array(
					'title' => __('Gateway Title', 'wcipaymu'),
					'type' => 'text',
					'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
					'default' => __('Ipaymu', 'wcipaymu'),
					'desc_tip' => true
				),
				'description' => array(
					'title' => __('Description', 'wcipaymu'),
					'type' => 'textarea',
					'description' => __('This controls the description which the user sees during checkout.', 'wcipaymu'),
					'default' => sprintf(__('Pay via Ipaymu. Alternatively you can pay with your PayPal account instead of Ipaymu, you can also pay with credit card if you don\'t have Ipaymu or PayPal account. Need an Ipaymu Account? <a href="%s">Register here!</a>', 'wcipaymu'), 'https://my.ipaymu.com?rid=masedi')
				),
				'ipaymu_username' => array(
					'title' => __('Ipaymu Username', 'wcipaymu'),
					'type' => 'text',
					'description' => __('Please enter your Ipaymu Login ID (username).', 'wcipaymu') . ' ' . sprintf(__('If you don\'t have Ipaymu account you can get one for free. <a href="%s" target="_blank">Register Ipaymu account here</a>!', 'wcipaymu'), 'https://my.ipaymu.com?rid=masedi'),
					'default' => ''
				),
				'ipaymu_apikey' => array(
					'title' => __('Ipaymu API Key', 'wcipaymu'),
					'type' => 'text',
					'description' => __('Please enter your Ipaymu API Key.', 'wcipaymu') . ' ' . sprintf(__('You can to get this information in: <a href="%s" target="_blank">Ipaymu Account</a>.', 'wcipaymu'), 'https://my.ipaymu.com/members/index.htm'),
					'default' => ''
				),
				'paypal_payment' => array(
					'title' => __('PayPal Payment', 'wcipaymu'),
					'type' => 'title',
					'description' => __('PayPal is official Ipaymu alternative payment.', 'wcipaymu')
				),
				'paypal_enabled' => array(
					'title' => __('Enable/Disable PayPal Module', 'wcipaymu'),
					'type' => 'checkbox',
					'description' => __('If you select to enable PayPal, you must also enable PayPal module in your Ipaymu account.', 'wcipaymu') . ' ' . sprintf(__('You can to get this information in: <a href="%s" target="_blank">Ipaymu Account</a>.', 'wcipaymu'), 'https://my.ipaymu.com/members/index.htm'),
					'default' => 'no'
				),
				'paypal_email' => array(
					'title' => __('PayPal Email', 'wcipaymu'),
					'type' => 'text',
					'description' => __('If you select to enable PayPal; Please enter your PayPal email address; this is needed if you enable PayPal Module.'),
					'default' => '',
					'desc_tip' => true,
					'placeholder'	=> 'you@youremail.com'
				),
				'invoice_prefix' => array(
					'title' => __('PayPal Invoice Prefix', 'wcipaymu'),
					'type' => 'text',
					'description' => __('If you select to enable PayPal; Please enter a prefix for your Paypal invoice numbers. If you use your PayPal account for multiple stores ensure this prefix is unqiue as PayPal will not allow orders with the same invoice number.', 'wcipaymu'),
					'default' => 'WC-',
					'desc_tip' => true
				),
				'currency_rate' => array(
					'title' => __('USD Currency Rate', 'wcipaymu'),
					'type' => 'text',
					'description' => __('If you select to enable PayPal; Please enter an Exchange Rate for 1 US Dollar (USD) in your default currency (ex: 9500). Due to Paypal has no support for Indonesia Rupiah (IDR) and Ipaymu can not automatically convert currency from IDR to USD for Paypal payment, you should set a default currency rate to avoid the wrong price. If not set, Ipaymu for Woocommerce will use live rate provided by KlikBCA.', 'wcipaymu'),
					'default' => '',
					'desc_tip' => true
				),
				'testing' => array(
					'title' => __('Gateway Testing', 'wcipaymu'),
					'type' => 'title',
					'description' => '',
				),
				'debug' => array(
					'title' => __('Debug Log', 'wcipaymu'),
					'type' => 'checkbox',
					'label' => __('Enable logging', 'wcipaymu'),
					'default' => 'no',
					'description' => __('Log Ipaymu events, such as API requests, inside <code>woocommerce/logs/ipaymu.txt</code>', 'wcipaymu'),
				),
				'credit' => array(
					'title' => __('Credit Link', 'wcipaymu'),
					'type' => 'title',
					'description' => '',
				),/*
				'credit_link' => array(
					'title' => __('Enable/Disable Credit Link', 'wcipaymu'),
					'type' => 'checkbox',
					'label' => __('Enable credit link', 'wcipaymu'),
					'default' => 'yes',
					'description' => __('', 'wcipaymu'),
				)*/
			);
		}

		/**
		 * Get Ipaymu Args for passing to Ipaymu Gateway
		 *
		 * @access public
		 * @param mixed $order
		 * @return array
		 **/
		function get_ipaymu_args($order) {
			global $woocommerce;
			
			$order_id = $order->id;
			$total_price = $order->get_total();

			if ($this->debug=='yes') $this->log->add('wcipaymu', 'Generating Ipaymu payment args for order #' . $order_id . '. Notify URL: ' . $this->notify_url);
			
			/* Price, Tax, Discount, and Shipping cost calculation  **/
			// Not sure if it is needed for Ipaymu, not yet checked
			$item_names = array();
			$item_numbers = array();
			$quantities = array();
			$amounts = array();

			// If prices include tax or have order discounts, send the whole order as a single item
			if (get_option('woocommerce_prices_include_tax')=='yes' || $order->get_order_discount() > 0) {
				// Discount
				$discount_amount_cart = $order->get_order_discount();

				// Don't pass items - ipaymu borks tax due to prices including tax. Ipaymu has no option for tax inclusive pricing sadly. Pass 1 item for the order items overall
				if (sizeof($order->get_items())>0) {
					foreach ($order->get_items() as $item) {
						if ($item['qty']) $item_names[] = $item['name'] . ' x ' . $item['qty'];
					}
				}

				$product_name = sprintf(__('Order %s' , 'wcipaymu'), $order->get_order_number()) . " - " . implode(', ', $item_names);
				$product_quantity = 1;
				$product_amount = number_format($order->get_total() - $order->get_shipping() - $order->get_shipping_tax() + $order->get_order_discount(), 2, '.', '');

				// Shipping Cost
				if (($order->get_shipping() + $order->get_shipping_tax()) > 0) {
					$shipping_name = __('Shipping via', 'wcipaymu') . ' ' . ucwords($order->shipping_method_title);
					$shipping_quantity = 1;
					$shipping_amount = number_format($order->get_shipping() + $order->get_shipping_tax() , 2, '.', '');
				}
			} else {
				// Tax
				$tax = $order->get_total_tax();

				// Cart Contents
				$item_loop = 0;
				
				if (sizeof($order->get_items())>0) {
					foreach ($order->get_items() as $item) {
						if ($item['qty']) {
							$item_loop++;
							$product = $order->get_product_from_item($item);
							$item_name 	= $item['name'];
							$item_meta = new WC_Order_Item_Meta($item['item_meta']);
							
							if ($meta = $item_meta->display(true, true)) {
								$item_name .= ' ('.$meta.')';
							}
							
							$item_names[] = $item_name;
							
							if ($product->get_sku()) {
								$item_numbers[] = $product->get_sku();
							}
							
							$quantities[] = $item['qty'];
							$amounts[] = $order->get_item_total($item, false);
						}
					}
				}

				$product_name = sprintf(__('Order %s' , 'wcipaymu'), $order->get_order_number()) . " - " . implode(', ', $item_names);

				// Shipping Cost item - ipaymu has no option for shipping inclusive, we want to send shipping for the order
				if ($order->get_shipping()>0) {
					$item_loop++;
					$shipping_name = __('Shipping via', 'wcipaymu') . ' ' . ucwords($order->shipping_method_title);
					$shipping_quantity = 1;
					$shipping_amount = number_format($order->get_shipping(), 2, '.', '');
				}
			} // Price, Tax, Discount, and Shipping cost calculation

			// Prepare Args (Parameters)
			$ipaymu_args = array(
				'key'		=> $this->ipaymu_apikey, // API Key Merchant (Penjual)
				'action'	=> 'payment',
				'product'	=> $product_name, // product name (id), $product_name, $order_id, $order->get_order_number() --> #$order_id
				'price'		=> $total_price, // Total price (Harga)
				'quantity'	=> 1,
				'comments'	=> sprintf(__('Process payment for Order ID %s' , 'wcipaymu'), $order->get_order_number()), // Optional           
				'ureturn'	=> add_query_arg('utm_nooverride', '1', $this->get_return_url($order)),
				//'unotify'	=> trailingslashit(home_url()) . '?ipaymuListener=notify&amp;order_id=' . $order_id . '&amp;order_key=' . $order->order_key,
				'unotify'	=> $this->notify_url . '&amp;order_id=' . $order_id . '&amp;order_key=' . $order->order_key,
				'ucancel'	=> esc_url($order->get_cancel_order_url()),
				'format'	=> 'json' // Format: xml / json. Default: xml 
			);

			/* If Ipaymu PayPal Module enabled (Jika menggunakan Opsi PayPal)  **/	
			if ($this->paypal_enabled == 'yes') {
				$currency_code = get_woocommerce_currency();
				
				// Recalculate item price if it is not in USD, since Paypal has no support rupiah
				if ($currency_code <> 'USD') {
					$usd_currency_rate = trim($this->currency_rate);
					
					// get cached currency rate
					$cached_usd_currency_rate = get_transient($this->id . '_currency_rate');
					
					if (! empty($usd_currency_rate) && (false !== $cached_usd_currency_rate)) {
						
						// auto update currency rate if both live and saved currency doesn't match
						if ($cached_usd_currency_rate !== $usd_currency_rate) {
						
							$live_usd_currency_rate = trim($this->get_kurs_bca($this->bca_kurs_url, 'USD'));
							
							// cache currency rate setting to avoid continuosely grabbing from bca (for performance, you can set cache for 24 hrs)
							set_transient($this->id . '_currency_rate', $live_usd_currency_rate, 86400);
							
							// update currency rate setting
							$wcipaymu_settings = get_option('woocommerce_' . $this->id . '_settings');
							$wcipaymu_settings['currency_rate'] = $live_usd_currency_rate;
							update_option('woocommerce_' . $this->id . '_settings', $wcipaymu_settings);
							
							$usd_currency_rate = $live_usd_currency_rate;
						}
						
						// convert the total price in IDR to USD using plugin setting
						$price_usd = $total_price / $usd_currency_rate;
					} else {
						// get cached currency rate
						$cached_usd_currency_rate = get_transient($this->id . '_currency_rate');
						
						if (false !== $cached_usd_currency_rate) {
							// update currency rate setting
							$wcipaymu_settings = get_option('woocommerce_' . $this->id . '_settings');
							$wcipaymu_settings['currency_rate'] = $cached_usd_currency_rate;
							update_option('woocommerce_' . $this->id . '_settings', $wcipaymu_settings);
							
							// convert the total price in IDR to USD using cached currency rate
							$price_usd = $total_price / $cached_usd_currency_rate;
						} else {
							// try to get currency rate from Kurs BCA
							$live_usd_currency_rate = trim($this->get_kurs_bca($this->bca_kurs_url, 'USD'));
							
							// cache currency rate setting to avoid continuosely grabbing them from bca (for performance, cache min 24 hrs)
							set_transient($this->id . '_currency_rate', $live_usd_currency_rate, 86400);
							
							// update currency rate setting
							$wcipaymu_settings = get_option('woocommerce_' . $this->id . '_settings');
							$wcipaymu_settings['currency_rate'] = $live_usd_currency_rate;
							update_option('woocommerce_' . $this->id . '_settings', $wcipaymu_settings);

							// convert the total price in IDR to USD using live currency rate
							$price_usd = $total_price / $live_usd_currency_rate;
						}
					}
				}
				
				$ipaymu_args = array_merge($ipaymu_args, array(
					'paypal_email'   => $this->paypal_email,
					'paypal_price'   => number_format($price_usd, 2), // Total harga dalam kurs USD
					'invoice_number' => $this->invoice_prefix . $order_id, // Optional
				));
			}

			$ipaymu_args = apply_filters('woocommerce_ipaymu_args', $ipaymu_args);

			return $ipaymu_args;
		}
	
		/**
		* Generate the form.
		*
		* @param mixed $order_id
		* @return string
		 **/
		function generate_ipaymu_form($order_id) {
			global $woocommerce;

			$order = new WC_Order($order_id);

			$args = $this->get_ipaymu_args($order);

			// logs
			if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Generating Ipaymu payment form for order #' . $order_id . ': ' . print_r($args, true));

			$response = $this->send_to_gateway($this->gateway_url, 'POST', $args);
			
			if ($response['status']) {
			
				$result = $this->parse_response($response);
				
				if ($result['status'] == true) {
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Ipaymu Gateway payment request response for order #' . $order_id . ': ' . print_r($result, true));

					if ($this->paypal_enabled == 'yes') {
						return "<a href='".$result["rawdata"]."'><img src='" . plugins_url('images/ipaymu_button_cc.png', __FILE__). "' alt='Bayar Sekarang' title='Bayar Sekarang' ></a>";
					} else {
						return "<a href='".$result["rawdata"]."'><img src='" . plugins_url('images/ipaymu_button_co.png', __FILE__). "' alt='Bayar Sekarang' title='Bayar Sekarang' ></a>";
					}
				} else {
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Ipaymu Gateway Error: Request response for order #' . $order_id . ': ' . print_r($result, true));
					return "<p>".$result['rawdata']."</p>";
				}
			
			} else {
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Error parsing Ipaymu gateway response.');
				return $this->ipaymu_order_error($order);
			}
		}

		/**
		 * Order error button.
		 *
		 * @access publick
		 * @param  object $order.
		 * @return string Error message and cancel button.
		 **/
		function ipaymu_order_error($order) {
			// Display message if there is problem.
			$html = '<p>' . __('Sorry, an error has occurred while processing your payment, please try again. Or contact us for further assistance.', 'wcipaymu') . '</p>';
			$html .='<a class="button cancel" href="' . esc_url($order->get_cancel_order_url()) . '">' . __('Click to try again', 'wcipaymu') . '</a>';
			return $html;
		}

		/**
		 * Process the payment and return the result.
		 *
		 * @access public
		 * @param int $order_id
		 * @return array
		 **/
		public function process_payment($order_id) {
			$order = new WC_Order($order_id);

			return array(
				'result' 	=> 'success',
				'redirect'	=> add_query_arg('order', $order->id, add_query_arg('key', $order->order_key, get_permalink(woocommerce_get_page_id('pay'))))
			);
		}

		/**
		 * Output for the order received page.
		 *
		 * @access public
		 * @return void
		 **/
		function receipt_page($order) {
			echo '<p>'.__('Thank you for your order, please click the button below to pay with Ipaymu.', 'wcipaymu').'</p>';
			echo $this->generate_ipaymu_form($order);
		}

		/**
		 * Parse payment gateway response.
		 *
		 * @access public
		 * @param $raw Object.
		 * @return array of response.
		 **/
		function parse_response($raw) {
			if ($raw['status']) {
				$result = json_decode($raw['rawdata'], true);
				if (isset($result['url'])) return array('status' => true, 'sessionID' => $result['sessionID'], 'rawdata' => $result['url']);
				else return array('status' => false, 'sessionID' => '', 'rawdata' => "Request Error ". $result['Status'] .": ". $result['Keterangan']);
			} else {
				return array('status' => false, 'sessionID' => '', 'rawdata' => $raw['rawdata']);
			}
		}
				
		/**
		 * Send To Gateway
		 *
		 * @access public
		 * @param  object $params Array Object with gateway items.
		 * @param  string  $url Gateway URL.
		 * @param  string  $method Request method: POST or GET.
		 * @return Array Response: status, rawdata.
		 **/
		function send_to_gateway($url, $method='POST', $params='', $ua = '', $cookie = false, $proxy = false, $proxyauth = false, $timeout = 30) {
			// set user agent
			if (empty($ua)) $ua = "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1";
	
			// set url target
			$url = str_replace('&amp;', '&', urldecode(trim($url)));
			
			// set POST params
			if ($method == 'POST') $postdata = http_build_query($params, '', '&');
			
			// set cookie file
			if ($cookie) $cookiefile = tempnam('/tmp', 'CURLCOOKIE');
			
			// Open CURL connection
			if (function_exists('curl_initz')) {
			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_USERAGENT, $ua);
				curl_setopt($ch, CURLOPT_URL, $url);
				
				if ($cookie) {
					curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
					curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
				}
		
		        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_AUTOREFERER, true);
				//curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // if follow location set to true

				// If set timeout enabled
				if ($timeout > 0) {
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
					curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
				}
						
				// If method http POST
				if ($method == 'POST') {
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				}
				
				// If set proxy enabled
				if ($proxy) {
					curl_setopt($ch, CURLOPT_PROXY, $proxy);
					
					if ($proxyauth) {
						curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
					}
				}				

				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Sending request to Ipaymu Gateway via CURL...');

				// execute request
				$response = @curl_exec($ch);

				if ($response === false) {
					// logs
					//if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Trouble payment request response from Ipaymu Gateway: ' . print_r(curl_error($ch), true));
					
					$result = array('status' => false, 'rawdata' => 'Curl Request Error: ' . curl_error($ch));
				} else {
					// logs
					//if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Received payment request response from Ipaymu Gateway via CURL: ' . print_r($response, true));
					
					$result = array('status' => true, 'rawdata' => $response);
				}
				
				curl_close($ch);

			} else {
				// Built wp_remote_post params instead.
				$send_params = array(
					'body' => $params,
					'sslverify' => false,
					'timeout' => $timeout,
					'method'  => $method,
					'user-agent' => $ua
				);
				
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Sending request to Ipaymu Gateway via wp_remote_post...');

				$response = wp_remote_post($url, $send_params);

				// Check to see if the request was valid.
				if (!is_wp_error($response) && $response['response']['code'] == 200) {

					$response_body = $response['body'];
					 
					if (!$response_body) {
						// logs
						if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Trouble payment request response from Ipaymu Gateway.');
						$result = array('status' => false, 'rawdata' => 'Request Error: Trouble response from Ipaymu.');
					} else {
						// logs
						if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Received payment request response from Ipaymu Gateway via wp_remote_post: ' . print_r($response_body, true));
						$result = array('status' => true, 'rawdata' => $response_body);
					}
				} else {
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Received invalid payment request response from Ipaymu Gateway.');
					$result = array('status' => false, 'rawdata' => 'Received invalid payment request response from Ipaymu Gateway.');
				}
			}
			
			return $result;
		}

		/**
		 * Check Ipaymu API validation. (Not sure if it is needed for Ipaymu)
		 *
		 * @access public
		 * @return void
		 **/
		function check_gateway_response_is_valid($data) {
			global $woocommerce;

			// logs
			if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Validating Ipaymu Gateway payment response: ' . print_r($data, true));
				
			if (isset($data['sid'])) {
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Success: Received valid payment response from Ipaymu Gateway.');

				return true;
			} else {
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Error: Received invalid payment response from Ipaymu Gateway.');

				return false;
			}
		}

		/**
		 * Check for Ipaymu API Response. (Not sure if it is needed for Ipaymu)
		 *
		 * @access public
		 * @return void
		 **/
		function check_gateway_response() {
			if (is_admin()) {
				return;
			}
			
			// logs
			//if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Capturing server request: ' . print_r($_REQUEST, true));

			// update for compatibility with version 2.0
			//if (isset($_GET['ipaymuListener']) && $_GET['ipaymuListener'] == 'notify') {
			
				@ob_clean();
				
				// Get order key from unotify url parameters and append to posted data from Ipaymu response (due to Ipaymu still have no method to send custom params)
				$_POST['order_id'] = $_GET['order_id'];
				$_POST['order_key'] = $_GET['order_key'];
				
				$_POST = stripslashes_deep($_POST);
				
				// Test only, kita perlu melakukan verifikasi response dari ipaymu stlh user berhasil melakukan payment
				$data = $this->check_gateway_response_is_valid($_POST);
				
				if ($data) {
					header('HTTP/1.1 200 OK');
					do_action('valid_ipaymu_gateway_request', $_POST);
					
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Receiving payment response from Ipaymu Gateway: ' . print_r($_POST, true));
				} else {
					header('HTTP/1.1 404 Not Found');
					wp_die("Gateway Error: Ipaymu API Request Failure.");
					
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Gateway Error: Ipaymu API Request Failure.');
				}
			//}
		}

		/**
		 * Successful Payment!
		 *
		 * @access public
		 * @param array $posted result response from gateway
		 * @return void
		 **/
		function successful_request($posted) {
			global $woocommerce;
			
			// Custom holds post ID
			//$order_status = array('cancelled', 'completed', 'failed', 'on-hold', 'pending', 'processing', 'refunded');
			
			// Received response from Ipaymu Gateway sent to unotify
			//$return_params = array('trx_id', 'sid', 'product', 'quantity', 'merchant', 'buyer', 'total', 'action', 'comments', 'referer');
			
			// Received response from Ipaymu Gateway sent to unotify if using PayPal
			//$return_params = array('sid', 'product', 'quantity', 'merchant', 'total', 'paypal_trx_id', 'paypal_invoice_number', 'paypal_currency', 'paypal_trx_total', 'paypal_trx_fee', 'paypal_buyer_email', 'paypal_buyer_status', 'paypal_buyer_name', 'action', 'referer');
		
			if (isset($posted['paypal_trx_id'])) { // if payment made using Paypal instead of Ipaymu
				$order_id = (int) str_replace($this->invoice_prefix, '', $posted['paypal_invoice_number']); // get order id from paypal invoice number
				//$order_id = $posted['order_id'];
				$order_key = $posted['order_key']; // get from unotify url
				$trx_id = $posted['paypal_trx_id'];
				$trx_total = $posted['paypal_trx_total'];
				$trx_fee = $posted['paypal_trx_fee'];
				$trx_buyer = $posted['paypal_buyer_name'];
			} else {
				// get order id from product name, format: Order #ID_NO - Product Name
				preg_match('/^(?:Order\s)#(.*?)[\s\-\s](.*?)/', $posted['product'], $matches);
				//$order_id = $posted['order_id'];
				$order_id = (int) trim($matches[1]);
				$order_key = $posted['order_key']; // get from unotify url
				$trx_id = $posted['trx_id'];
				$trx_total = $posted['total'];
				$trx_fee = 0;
				$trx_buyer = $posted['buyer'];
			}
				
			$order = new WC_Order($order_id);
				
			if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Validating Payment status from order #' . $order->id . 'which order key is ' . $order_key);
				
			// Checks whether returned order_key not equal with current order_key
			if ($order->order_key !== $order_key) {
				if ($this->debug=='yes') $this->log->add('wcipaymu', 'Payment Error: Order Key (' . $order_key . ') does not match invoice number.');
				exit;
			}
	
			if ($trx_id <> '') {
				// test, give the gateway server a delay time before checking the payment status
				sleep(3);
					
				// checking Ipaymu payment status
				$payment = $this->check_payment_status($trx_id);
				if (!$payment) {
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Got error when checking payment status from Ipaymu Gateway. ' . print_r($payment, true));
				} else {
					// logs
					if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Updating payment status for order #' . $order->id);
					
					// update order status
					switch ($payment['Status']) :
						
						case "1":
							// Check order not already completed.
							if ($order->status == 'completed') {
								if ($this->debug=='yes') $this->log->add('wcipaymu', 'Aborting... Order #' . $order_id . ' is already completed.');
								exit;
							}
								
							// Validate Amount
							if ($order->get_total() != $posted['total']) {
								if ($this->debug == 'yes') 
									$this->log->add('wcipaymu', 'Payment validation error: Amounts do not match. Total payment (gross ' . $trx_total . ') and (fee ' . $trx_fee . '). Order total ' . $order->get_total() . '.');
								
								// Put this order on-hold for manual checking
								$order->update_status('on-hold', sprintf(__('Payment validation error: Ipaymu amounts do not match (gross %s) and (fee %s). Order total %s', 'wcipaymu'), $trx_total, $trx_fee, $order->get_total()));
								exit;
							}
								
							// Store Ipaymu Payment Details
							if (isset($posted['paypal_trx_id']) && ! empty($posted['paypal_buyer_email'])) {
								update_post_meta($order_id, 'Payment type', 'PayPal via Ipaymu');
								update_post_meta($order_id, 'Buyer PayPal address', $posted['paypal_buyer_email']);
							} else {
								update_post_meta($order_id, 'Payment type', 'Ipaymu');
							}
							if (! empty($trx_id))
								update_post_meta($order_id, 'Payment Trx ID', $trx_id);
								
							if (! empty($trx_buyer))
								update_post_meta($order_id, 'Buyer first name', $trx_buyer);
								
							if (! empty($posted['comments']))
								update_post_meta($order_id, 'Payment comments', $posted['comments']);

							// Payment completed
							$order->add_order_note(__('Payment completed using Ipaymu', 'wcipaymu'));
							$order->payment_complete();
								
							// Send email notify to buyer
							$mailer = $woocommerce->mailer();
							$mailer->wrap_message(
								__('Order received and processed', 'wcipaymu'),
								sprintf(__('Payment for order %s has been received via Ipaymu on: %s and we\'re now processing your order.', 'wcipaymu'), $order->get_order_number(), $payment['Waktu'])
							);
							$mailer->send(get_option('woocommerce_new_order_email_recipient'), sprintf(__('Your order %s has been received.', 'wcipaymu'), $order->get_order_number()), $message);

							// logs
							if (isset($posted['paypal_buyer_email']) && ! empty ($posted['paypal_buyer_email'])) {
								if ($this->debug=='yes') $this->log->add('wcipaymu', 'Payment Status: Completed using Paypal through Ipaymu.');
							} else {
								if ($this->debug=='yes') $this->log->add('wcipaymu', 'Payment Status: Completed using Ipaymu.');
							}
						break;
							
						case "2":
							// Batal (cancelled)
						break;
							
						case "3":
							// Refunded
								
							// Only handle full refunds, not partial
							$order_total = $order->get_total();
							$ipaymu_fee = $order_total * $this->ipaymu_fee; // ipaymu fee is 1% of total paid amount and not refundable, so we need to add it to the refunded balance
								
							if ($order_total == ($payment['Nominal'] + $ipaymu_fee)) {
								// Mark order as refunded
								$order->update_status('refunded', sprintf(__('Payment %s via Ipaymu.', 'wcipaymu'), strtolower($payment['Keterangan'])));
									
								// Send email notify to buyer
								$mailer = $woocommerce->mailer();
								$mailer->wrap_message(
									__('Order refunded/reversed', 'wcipaymu'),
									sprintf(__('Order %s has been marked as refunded via Ipaymu on: %s', 'wcipaymu'), $order->get_order_number(), $payment['Waktu'])
								);
								$mailer->send(get_option('woocommerce_new_order_email_recipient'), sprintf(__('Payment for order %s refunded/reversed', 'wcipaymu'), $order->get_order_number()), $message);

								// logs
								if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Payment Status: Refunded. Total refunded: ' . $payment['Nominal'] . ' + Ipaymu transaction fee :' . $ipaymu_fee);
							}
						break;
							
						case "-1004":
							// Error: ID Transaksi salah
							// logs
							if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Payment Status: Invalid transaction ID.');
						break;
							
						case "-1005":
							// Error: ID Transaksi tidak ditemukan
							// logs
							if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Payment Status: Transaction ID not found.');
						break;
							
						default:
							// No action
						break;
					endswitch; // End switch
				}
			} else {
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Payment Status: Transaction not found.');
			}
		}
		
		/**
		 * Checking for Ipaymu Payment Status.
		 *
		 * @access public
		 * @params $trx_id transaction id from gateway payment response
		 * @return void
		 **/
		function check_payment_status($trx_id) {
			$args = array(
				'key' => $this->ipaymu_apikey,
				'id' => $trx_id,
				'format' => 'json'
			);
			
			// logs
			if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Checking Ipaymu payment status for transaction ID ' . print_r($trx_id, true));

			$response = $this->send_to_gateway($this->gateway_trx_url, 'POST', $args);
			
			if ($response['status']) {
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Received valid response for Ipaymu payment status check : ' . print_r($response, true));
				return json_decode($response['rawdata'], true);
			} else {
				// logs
				if ($this->debug == 'yes') $this->log->add('wcipaymu', 'Received unexpected error response for Ipaymu payment status check : ' . print_r($response, true));
				return false;
			}
		}
		
		/**
		 * Send debugging email
		 *
		 * @access public
		 * @return void
		**/
		function send_email_notification($message) {
			// Send the email
			wp_mail($this->notify_email, __('Ipaymu Debug', 'wcipaymu'), $message);
		}

		/**
		 * Adds error message when not configured the api_key.
		 *
		 * @access public
		 * @return string
		 **/
		function api_key_missing_message() {
			$message = '<div class="error"><p>' . sprintf(__('<strong>WooCommerce Ipaymu Gateway</strong> is almost ready. Please enter <a href="%s">your Ipaymu API Key</a> for it to work.' , 'wcipaymu'), admin_url('admin.php?page=woocommerce_settings&amp;tab=payment_gateways')) . '</p></div>';
			echo $message;
		}

		/**
		 * Adds error message when not configured the Force SSL.
		 *
		 * @access public
		 * @return string
		 **/
		function forcessl_missing_message() {
			$message = '<div class="error"><p>' .sprintf(__('<strong>WooCommerce Ipaymu Gateway</strong> is enabled and the <em><a href="%s">force SSL option</a></em> is disabled; your checkout is not secure! Please enable SSL and ensure your server has a valid SSL certificate.', 'wcipaymu'), admin_url('admin.php?page=woocommerce_settings')) . '</p></div>';
			echo $message;
		}
		
		/**
		 * Add credit links to Ipaymu Payment Gateway
		 * Thanks for supporting the development of this plugin by placing the credit links on yout shopping cart 
		 **/
		function masedi_credits_link() {
			//$wcipaymu_settings = get_option('woocommerce_' . $this->id . '_settings');
			if ($this->credit_link == 'yes') {
				$credits = '<div class="aligncenter">' . get_bloginfo('name') . ' uses <strong><a href="http://shop.masedi.net/shop/woocommerce-extension-ipaymu-payment-gateway/" target="_blank" title="Download Ipaymu Payment Gateway for WooCommerce">Ipaymu for WooCommerce plugin</a></strong> developed by <a href="http://masedi.net/" target="_blank" title="Online Store Developer">MasEDI.Net</a></div>';			
				echo $credits;
			}
		}
		
		/**
		 * Retrieve currency rate from KursBCA
		 *
		 * @param $kurs_url string url of currency converter
		 * @param $currency string of currency code
		 * @access public
		 * @return string
		 **/
		function get_kurs_bca($kurs_url, $currency) {
			$bca_rates = array();

			$response = $this->send_to_gateway($kurs_url, 'GET'); // get result Object array status, rawdata
			
			if ($response['status']) {
				$html = $response['rawdata'];

				// match table from bca kurs html web page
				$table = preg_match_all('#<table[^>]+>(.+?)</table>#ims', $html, $matches, PREG_SET_ORDER);

				// look for table containing Kurs
				$looked_table = $matches[1][0];

				// parse the table raw
				$t_row = preg_match_all('#<tr>(.+?)</tr>#ims', $matches[1][0], $tr_matches, PREG_SET_ORDER);

				if ($t_row) {
					foreach ($tr_matches as $i => $tr_match) {
						// parse the table raw data
						$t_data = preg_match_all('#<td[^>]+>(.+?)</td>#ims', $tr_match[1], $td_matches, PREG_SET_ORDER);

						if ($t_data) {
							$cur = trim($td_matches[0][1]);
							$sell_rate = trim($td_matches[1][1]);
							$buy_rate = trim($td_matches[2][1]);
							// make result in array for JSON output
							$bca_rates[$cur] = array('Sell' => (float) $sell_rate, 'Buy' => (float) $buy_rate);
						}
					}
				}
				
				// return value USD
				if (is_numeric($bca_rates[$currency]['Buy']))
					return $bca_rates[$currency]['Buy'];
				else return false;
			} else {
				return false;
			}
		}
	} // End of WC_Ipaymu_Gateway class.
	
	/**
	 * Add the gateway to WooCommerce.
	 *
	 * @access public
	 * @param array $methods
	 * @return array
	 **/
	function add_ipaymu_gateway($methods) {
		$methods[] = 'WC_Gateway_Ipaymu';
		return $methods;
	}
	add_filter('woocommerce_payment_gateways', 'add_ipaymu_gateway');
	
	/**
	 * Add New Currencies and symbols for Indonesia Rupiah for Ipaymu Gateway
	 * If not work, put the code below on function.php file under your Wordpress theme 
	 **/
	if (! function_exists('wc_idr_currency')) {
		function wc_idr_currency($currencies) {
			$currencies['IDR'] = __('Indonesia Rupiah', 'wcipaymu');	
			return $currencies;
		}
		add_filter('woocommerce_currencies', 'wc_idr_currency');
	}

	if (! function_exists('wc_idr_currency_symbol')) {
		function wc_idr_currency_symbol($currency_symbol, $currency) {
			switch($currency) {
				case 'IDR': $currency_symbol = 'Rp.'; break;
			}
			return $currency_symbol;
		}
		add_filter('woocommerce_currency_symbol', 'wc_idr_currency_symbol', 10, 2);
	}
	
	// additional currencies for Gravity Forms, basically should not here, but very it is useful for store that using gravity form as addons
	if (class_exists("RGForms") && ! function_exists("gf_idr_currency")) {
		function gf_idr_currency($currencies) {
			$currencies['IDR'] = array(
				'name' => __('Indonesia Rupiah', 'gravityforms'), 
				'symbol_left' => 'Rp.', 
				'symbol_right' => '', 
				'symbol_padding' => ' ', 
				'thousand_separator' => '.', 
				'decimal_separator' => ',', 
				'decimals' => 2);
				
			return $currencies; 
		}
		add_filter('gform_currencies', 'gf_idr_currency');
	}
	
} // End function ipaymu_gateway_init.
add_action('plugins_loaded', 'ipaymu_gateway_init', 0);

?>
