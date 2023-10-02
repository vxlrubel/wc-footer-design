<?php
if( class_exists('WooCommerce')){
   $cart_page_id = get_option('woocommerce_cart_page_id');
   $cart_page_url = get_permalink($cart_page_id);
}else{
   $cart_page_url = '#';
}

$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
$profile_page_url = get_permalink( wc_get_page_id( 'myaccount') );

?>

<div class="app-side-menu">
   <?php
      $args = [
         'theme_location' => 'app_menu'
      ];
      wp_nav_menu();
   ?>
   <div class="close-menu">
      <span>Close Menu</span>
      <a href="#" class="side-menu-close"><i class="fa-solid fa-xmark"></i></a>
   </div>
</div>
<div class="app-menu">
   <div class="container">
      <ul class="footer-app">
         <li>
            <a href="#" class="app-toggle-menu">
                <i class="fa-solid fa-bars"></i>
                <span>Menu</span>
            </a>
         </li>
         <li>
            <a href="<?php echo esc_url( $shop_page_url );?>">
               <i class="fa-brands fa-shopify"></i>
                <span>Shop</span>
            </a>
         </li>
         <li>
            <a href="<?php echo esc_url(home_url('/'));?>" class="active-home">
                <i class="fa-solid fa-house"></i>
                <span>Home</span>
            </a>
         </li>
         <li>
            <a href="<?php echo esc_url($cart_page_url); ?>">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>cart</span>
            </a>
         </li>
         <li>
            <a href="<?php echo esc_url( $profile_page_url );?>">
               <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
         </li>
      </ul>
   </div>
</div>