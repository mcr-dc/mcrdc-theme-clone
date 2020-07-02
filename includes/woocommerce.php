<?php
/**
 * WooCommerce Compatibility File
 *
 * @link    https://woocommerce.com/
 *
 * @package _s
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function _s_woocommerce_setup()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', '_s_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function _s_woocommerce_scripts()
{
    wp_enqueue_style('_s-woocommerce-style', _s_asset('styles/woocommerce.css'));

    if (is_product() || is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_style('_s-woocommerce-checkout', _s_asset('styles/products.css'));
    }

    if (is_singular('product')) {
        wp_enqueue_style('_s-woocommerce-review', _s_asset('styles/review.css'));
    }

    if (is_cart()) {
        wp_enqueue_style('_s-woocommerce-cart', _s_asset('styles/cart.css'));
    }

    if (is_checkout()) {
        wp_enqueue_style('_s-woocommerce-checkout', _s_asset('styles/checkout.css'));
    }

    if (is_account_page() || is_order_received_page()) {
        wp_enqueue_style('_s-woocommerce-account', _s_asset('styles/account.css'));
    }

    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

    wp_add_inline_style('_s-woocommerce-style', $inline_font);
}

add_action('wp_enqueue_scripts', '_s_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 *
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function _s_woocommerce_active_body_class($classes)
{
    $classes[] = 'woocommerce-active';

    return $classes;
}

add_filter('body_class', '_s_woocommerce_active_body_class');

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function _s_woocommerce_products_per_page()
{
    return 12;
}

add_filter('loop_shop_per_page', '_s_woocommerce_products_per_page');

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function _s_woocommerce_thumbnail_columns()
{
    return 4;
}

add_filter('woocommerce_product_thumbnails_columns', '_s_woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function _s_woocommerce_loop_columns()
{
    return 3;
}

add_filter('loop_shop_columns', '_s_woocommerce_loop_columns');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 *
 * @return array $args related products args.
 */
function _s_woocommerce_related_products_args($args)
{
    $defaults = [
        'posts_per_page' => 3,
        'columns'        => 3,
    ];

    $args = wp_parse_args($defaults, $args);

    return $args;
}

add_filter('woocommerce_output_related_products_args', '_s_woocommerce_related_products_args');

if ( ! function_exists('_s_woocommerce_product_columns_wrapper')) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function _s_woocommerce_product_columns_wrapper()
    {
        $columns = _s_woocommerce_loop_columns();
        echo '<div class="columns-' . absint($columns) . '">';
    }
}
add_action('woocommerce_before_shop_loop', '_s_woocommerce_product_columns_wrapper', 40);

if ( ! function_exists('_s_woocommerce_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close.
     *
     * @return  void
     */
    function _s_woocommerce_product_columns_wrapper_close()
    {
        echo '</div>';
    }
}
add_action('woocommerce_after_shop_loop', '_s_woocommerce_product_columns_wrapper_close', 40);

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if ( ! function_exists('_s_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function _s_woocommerce_wrapper_before()
    {
        ?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
    }
}
add_action('woocommerce_before_main_content', '_s_woocommerce_wrapper_before');

if ( ! function_exists('_s_woocommerce_wrapper_after')) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function _s_woocommerce_wrapper_after()
    {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php
    }
}
add_action('woocommerce_after_main_content', '_s_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 * <?php
 * if ( function_exists( '_s_woocommerce_header_cart' ) ) {
 * _s_woocommerce_header_cart();
 * }
 * ?>
 */

if ( ! function_exists('_s_woocommerce_cart_link_fragment')) {
    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param array $fragments Fragments to refresh via AJAX.
     *
     * @return array Fragments to refresh via AJAX.
     */
    function _s_woocommerce_cart_link_fragment($fragments)
    {
        ob_start();
        _s_woocommerce_cart_link();
        $fragments[ 'a.cart-contents' ] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', '_s_woocommerce_cart_link_fragment');

if ( ! function_exists('_s_woocommerce_cart_link')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function _s_woocommerce_cart_link()
    {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', '_s'); ?>">
            <?php
            $item_count_text = sprintf(
            /* translators: number of items in the mini cart. */
                _n('%d item', '%d items', WC()->cart->get_cart_contents_count(), '_s'),
                WC()->cart->get_cart_contents_count()
            );
            ?>
            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
        </a>
        <?php
    }
}

if ( ! function_exists('_s_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function _s_woocommerce_header_cart()
    {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <ul id="site-header-cart" class="site-header-cart">
            <li class="<?php echo esc_attr($class); ?>">
                <?php _s_woocommerce_cart_link(); ?>
            </li>
            <li>
                <?php
                $instance = [
                    'title' => '',
                ];

                the_widget('WC_Widget_Cart', $instance);
                ?>
            </li>
        </ul>
        <?php
    }
}

add_action('woocommerce_shop_loop_item_title', '_s_loop_product_content_header_open', 5);

function _s_loop_product_content_header_open()
{
    echo '<div class="woocommerce-card__header">';
}

add_action('woocommerce_after_shop_loop_item', '_s_loop_product_content_header_close', 60);

function _s_loop_product_content_header_close()
{
    echo '</div>';
}

add_action('woocommerce_before_single_product_summary', '_s_product_content_wrapper_start', 5);
add_action('woocommerce_single_product_summary', '_s_product_content_wrapper_end', 60);


/**
 * Single Product Page - Add a section wrapper start.
 */
function _s_product_content_wrapper_start()
{
    echo '<div class="product-details-wrapper">';
}

/**
 * Single Product Page - Add a section wrapper end.
 */
function _s_product_content_wrapper_end()
{
    echo '</div><!--/product-details-wrapper end-->';
}

/**
 * Within Product Loop - remove title hook and create a new one with the category displayed above it.
 */
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

add_action('woocommerce_shop_loop_item_title', '_s_loop_product_title', 10);

function _s_loop_product_title()
{

    global $post;

    $woocommerce_display_category = true;
    ?>
    <?php if (true === $woocommerce_display_category) { ?>
    <?php echo '<p class="product__categories">' . wc_get_product_category_list(get_the_id(), ', ', '', '') . '</p>'; ?>
<?php } ?>
    <?php
    echo '<div class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '" title="' . get_the_title() . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">' . get_the_title() . '</a></div>';
}


add_action('_s_before_site', '_s_header_cart_drawer', 5);
if ( ! function_exists('_s_header_cart_drawer')) {
    /**
     * Display Header Cart Drawer
     *
     * @return void
     * @uses   shoptimizer_is_woocommerce_activated() check if WooCommerce is activated
     * @since  1.0.0
     */
    function _s_header_cart_drawer()
    {
        if (function_exists('is_woocommerce')) {
            if (is_cart()) {
                $class = 'current-menu-item';
            } else {
                $class = '';
            }
            ?>
            <div class="shoptimizer-mini-cart-wrap">

                <div id="ajax-loading">
                    <div class="shoptimizer-loader">
                        <div class="spinner">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </div>

                <div class="close-drawer"></div>

                <?php the_widget('WC_Widget_Cart', 'title='); ?>
            </div>
            <?php

            $shoptimizer_cart_drawer_js = '';
            $shoptimizer_cart_drawer_js .= "
				( function ( $ ) {

					// Open the drawer if a product is added to the cart
					$( '.product_type_simple.add_to_cart_button' ).on( 'click', function( e ) {
						e.preventDefault();
						$( 'body' ).toggleClass( 'drawer-open' );
					} );

					// Toggle cart drawer.
					$( '.site-header-cart .cart-click' ).on( 'click', function( e ) {
						e.stopPropagation();
						e.preventDefault();
						$( 'body' ).toggleClass( 'drawer-open' );
					} );

					// Close the drawer when clicking outside it
					$( document ).mouseup( function( e ) {
						var container = $( '.shoptimizer-mini-cart-wrap' );

						if ( ! container.is( e.target ) && 0 === container.has( e.target ).length ) {
							$( 'body' ).removeClass( 'drawer-open' );
						}
					} );

					// Close drawer - click the x icon
					$( '.close-drawer' ).on( 'click', function() {
						$( 'body' ).removeClass( 'drawer-open' );
					} );

				}( jQuery ) );
				";

            wp_add_inline_script('_s-main', $shoptimizer_cart_drawer_js);
        }
    }
}

add_action('wp_ajax_shoptimizer_pdp_ajax_atc', '_s_pdp_ajax_atc');
add_action('wp_ajax_nopriv_shoptimizer_pdp_ajax_atc', '_s_pdp_ajax_atc');
if ( ! function_exists('_s_pdp_ajax_atc')) {
    /**
     * PDP/Single product ajax add to cart.
     */
    function _s_pdp_ajax_atc()
    {
        $sku        = '';
        $product_id = '';

        if (isset($_POST[ 'variation_id' ])) {
            $sku = $_POST[ 'variation_id' ];
        }
        if (isset($_POST[ 'add-to-cart' ])) {
            $product_id = $_POST[ 'add-to-cart' ];
        }

        if ( ! isset($sku)) {
            $sku = $product_id;
        }
        ob_start();
        wc_print_notices();
        $notices = ob_get_clean();
        ob_start();
        woocommerce_mini_cart();
        $shoptimizer_mini_cart = ob_get_clean();
        $shoptimizer_atc_data  = [
            'notices'   => $notices,
            'fragments' => apply_filters(
                'woocommerce_add_to_cart_fragments',
                [
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $shoptimizer_mini_cart . '</div>',
                ]
            ),
            'cart_hash' => apply_filters('woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5(json_encode(WC()->cart->get_cart_for_session())) : '', WC()->cart->get_cart_for_session()),
        ];
        wp_send_json($shoptimizer_atc_data);
        die();
    }
}


add_action('wp_enqueue_scripts', '_s_pdp_ajax_atc_enqueue');
if ( ! function_exists('_s_pdp_ajax_atc_enqueue')) {
    /**
     * Enqueue assets for PDP/Single product ajax add to cart.
     */
    function _s_pdp_ajax_atc_enqueue()
    {
        if (is_product()) {
            wp_enqueue_script(
                'shoptimizer-ajax-script',
                get_template_directory_uri() . '/frontend/dist/scripts/product.js',
                ['jquery']
            );
            wp_localize_script(
                'shoptimizer-ajax-script',
                '_s_ajax_obj',
                [
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce'   => wp_create_nonce('ajax-nonce'),
                ]
            );
        }
    }
}