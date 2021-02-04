<?php
function cs_woocommerce_enabled()
{
	if ( class_exists( 'woocommerce' ) ){ return true; }
	return false;
}

//check if the plugin is enabled, otherwise stop the script
if(!cs_woocommerce_enabled()) { return false; }

//woocommerce support theme
add_theme_support( 'woocommerce' );

define('WOOCOMMERCE_USE_CSS', false);

add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
function child_manage_woocommerce_styles() {
    //remove generator meta tag
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
 
    //first check that woo exists to prevent fatal errors
    if ( function_exists( 'is_woocommerce' ) ) {
        //dequeue scripts and styles
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
        }
    }
 
}

//remove woo defaults
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
* Define image sizes
*/
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'cs_woocommerce_image_dimensions', 1 );

function cs_woocommerce_image_dimensions() {
	$catalog = array(
	'width' => '200',	// px
	'height'	=> '200',	// px
	'crop'	=> 1 // true
	);
	 
	$single = array(
	'width' => '400',	// px
	'height'	=> '400',	// px
	'crop'	=> 1 // true
	);
	 
	$thumbnail = array(
	'width' => '150',	// px
	'height'	=> '150',	// px
	'crop'	=> 1 // false
	);
	 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
	update_option( 'shop_single_image_size', $single ); // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
}

//Shop Show items number starts
function cs_woocommerce_result_count() {
	global $woocommerce, $wp_query;
	?>
    <div class="filter-sec">
		<div class="select-sec">
    <?php
	if ( ! woocommerce_products_will_display() )
	return;
	?>
        <span>
            <?php
            $paged    = max( 1, $wp_query->get( 'paged' ) );
            $per_page = $wp_query->get( 'posts_per_page' );
            $total    = $wp_query->found_posts;
            $first    = ( $per_page * $paged ) - $per_page + 1;
            $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
        
            if ( 1 == $total ) {
                _e( 'Showing the single result', 'woocommerce' );
            } elseif ( $total <= $per_page || -1 == $per_page ) {
                printf( __( 'Showing all %d results', 'woocommerce' ), $total );
            } else {
                printf( _x( 'Showing %1$d–%2$d of %3$d results', '%1$d = first, %2$d = last, %3$d = total', 'woocommerce' ), $first, $last, $total );
            }
            ?>
        </span>
        <?php woocommerce_get_template( 'loop/orderby.php' ); ?>
        </div>
    </div>
	<?php
	
}
add_action( 'woocommerce_before_shop_loop', 'cs_woocommerce_result_count' );
//Shop Show items number end

//Shop loop items changings starts
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'shop_loop_item_hover_desc' );
function shop_loop_item_hover_desc()
{
	global $post;
	$no_img = "";
	$img_sizes = get_option( 'shop_catalog_image_size' );
	$img_width = $img_sizes['width'];
	$img_height = $img_sizes['height'];
	if(wp_get_attachment_image( get_post_thumbnail_id() ) == ""){
		$no_img = 'class="no-image"';
	}
?>
	<figure <?php echo $no_img; ?>>
        <figcaption>
            <?php
			woocommerce_get_template( 'loop/rating.php' );
			?>
            </a><div class="clear"></div>
            <?php
			woocommerce_get_template( 'loop/add-to-cart.php' );
			?>
        </figcaption>
        
<?php
	woocommerce_get_template( 'loop/sale-flash.php' );
	echo wp_get_attachment_image( get_post_thumbnail_id(), array($img_width,$img_height) );
?>
	</figure>
    <div class="text">
    	<h6><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h6>
<?php
}

add_action( 'woocommerce_after_shop_loop_item_title', 'cs_after_loop_title_code' );
function cs_after_loop_title_code()
{
	woocommerce_get_template( 'loop/price.php' );
	
?>
</div>
<?php
}
//Shop loop items changings ends

//Shop single page starts
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

add_action( 'woocommerce_before_single_product_summary', 'cs_single_prod_start' );
function cs_single_prod_start(){
	global $post;
	?>
	<h1 class="cs-page-title cs-heading-color"><?php the_title(); ?></h1>
    <?php
}

add_action( 'woocommerce_before_single_product_summary', 'cs_shop_single_prod_cat', 20 );
function cs_shop_single_prod_cat(){
	global $post;
	$cat_list = get_the_term_list ( $post->ID, 'product_cat', '', ', ', '' );
	if ( $cat_list){
		?>
        <div class="category-sec">
        <?php
        global $product;

        if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
            return;
        ?>
        
        <?php if ( $rating_html = $product->get_rating_html() ) : ?>
            <?php echo $rating_html; ?>
        <?php endif; ?>
        
        <?php
		echo '<p>'.$cat_list.'</p>';
		?>
        </div>
        <?php
	}
}

add_action( 'woocommerce_single_product_summary', 'cs_shop_single_prod_sale_flash', 30 );
function cs_shop_single_prod_sale_flash(){
    woocommerce_get_template( 'single-product/sale-flash.php' );
}

add_action( 'woocommerce_after_single_product_summary', 'cs_shop_single_prod_excerpt', 5 );
function cs_shop_single_prod_excerpt(){
	?>
    <div class="cs-prod-desc">
    <?php
    woocommerce_get_template( 'single-product/short-description.php' );
	?>
    </div>
    <?php
}
//Shop single page ends
?>