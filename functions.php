
<?php
/**
 * Theme functions for Fur Scoopers
 */

if (!defined('ABSPATH')) { exit; }

function furscoopers_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('woocommerce');
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');

  // Add comprehensive WordPress block editor support
  add_theme_support('wp-block-styles');
  add_theme_support('responsive-embeds');
  add_theme_support('align-wide');
  add_theme_support('align-full');
  add_theme_support('editor-styles');
  add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

  // Add custom color palette for blocks
  add_theme_support('editor-color-palette', array(
    array(
      'name' => __('Primary Green', 'furscoopers'),
      'slug' => 'primary-green',
      'color' => '#2d5016',
    ),
    array(
      'name' => __('Secondary Green', 'furscoopers'),
      'slug' => 'secondary-green',
      'color' => '#4a7c59',
    ),
    array(
      'name' => __('Light Green', 'furscoopers'),
      'slug' => 'light-green',
      'color' => '#7fb069',
    ),
    array(
      'name' => __('Accent Green', 'furscoopers'),
      'slug' => 'accent-green',
      'color' => '#a7c957',
    ),
    array(
      'name' => __('White', 'furscoopers'),
      'slug' => 'white',
      'color' => '#ffffff',
    ),
    array(
      'name' => __('Black', 'furscoopers'),
      'slug' => 'black',
      'color' => '#333333',
    ),
  ));

  // Add custom font sizes for blocks
  add_theme_support('editor-font-sizes', array(
    array(
      'name' => __('Small', 'furscoopers'),
      'size' => 14,
      'slug' => 'small'
    ),
    array(
      'name' => __('Regular', 'furscoopers'),
      'size' => 16,
      'slug' => 'regular'
    ),
    array(
      'name' => __('Medium', 'furscoopers'),
      'size' => 20,
      'slug' => 'medium'
    ),
    array(
      'name' => __('Large', 'furscoopers'),
      'size' => 24,
      'slug' => 'large'
    ),
    array(
      'name' => __('Extra Large', 'furscoopers'),
      'size' => 32,
      'slug' => 'extra-large'
    ),
  ));

  // Disable custom colors and font sizes to enforce theme palette
  add_theme_support('disable-custom-colors');
  add_theme_support('disable-custom-font-sizes');

  // Add experimental block features
  add_theme_support('experimental-link-color');
  add_theme_support('custom-line-height');
  add_theme_support('custom-spacing');
  add_theme_support('custom-units', array('px', 'em', 'rem', 'vh', 'vw'));

  // Add block template support
  add_theme_support('block-templates');
  add_theme_support('block-template-parts');

  register_nav_menus(array(
    'primary' => __('Primary Menu', 'furscoopers'),
  ));
}
add_action('after_setup_theme', 'furscoopers_setup');

// WooCommerce theme support functions
function furscoopers_woocommerce_wrapper_start() {
  echo '<div id="primary" class="content-area">';
  echo '<main id="main" class="site-main" role="main">';
}

function furscoopers_woocommerce_wrapper_end() {
  echo '</main>';
  echo '</div>';
}

// Remove default WooCommerce wrappers and add custom ones
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'furscoopers_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'furscoopers_woocommerce_wrapper_end', 10);

function furscoopers_enqueue_assets() {
  wp_enqueue_style('furscoopers-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

  // Enqueue block editor styles for frontend
  wp_enqueue_style('furscoopers-block-style', get_template_directory_uri() . '/assets/css/blocks.css', array(), wp_get_theme()->get('Version'));

  // Enqueue WooCommerce block styles if WooCommerce is active
  if (class_exists('WooCommerce')) {
    wp_enqueue_style('wc-blocks-style');
    wp_enqueue_script('wc-blocks-frontend');
    wp_enqueue_style('wc-blocks-vendors-style');
  }
}

// Enqueue block editor styles for the admin
function furscoopers_block_editor_styles() {
  wp_enqueue_style('furscoopers-block-editor-style', get_template_directory_uri() . '/assets/css/editor-style.css', array(), wp_get_theme()->get('Version'));
}
add_action('enqueue_block_editor_assets', 'furscoopers_block_editor_styles');

// Add AJAX variables directly to wp_head
function furscoopers_add_ajax_vars() {
  ?>
  <script type="text/javascript">
    var furscoopers_ajax = {
      ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
      nonce: '<?php echo wp_create_nonce('furscoopers_subscription_nonce'); ?>'
    };
  </script>
  <?php
}
add_action('wp_enqueue_scripts', 'furscoopers_enqueue_assets');
add_action('wp_head', 'furscoopers_add_ajax_vars');

function furscoopers_register_cpt() {
  $labels = array(
    'name' => __('Testimonials','furscoopers'),
    'singular_name' => __('Testimonial','furscoopers'),
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'has_archive' => false,
    'menu_position' => 20,
    'menu_icon' => 'dashicons-format-quote',
    'supports' => array('title','editor'),
    'show_in_rest' => true,
  );
  register_post_type('testimonial', $args);
}
add_action('init','furscoopers_register_cpt');

function furscoopers_activate() {
  $pages = array(
    'services' => 'Our Services',
    'facts' => 'Why Choose Professional Waste Removal?',
    'how-it-works' => 'How It Works',
    'pricing' => 'Transparent Pricing',
    'faq' => 'Frequently Asked Questions',
    'about' => 'About Fur Scoopers'
  );
  foreach ($pages as $slug => $title) {
    if (!get_page_by_path($slug)) {
      wp_insert_post(array(
        'post_title' => $title,
        'post_name' => $slug,
        'post_status' => 'publish',
        'post_type' => 'page',
      ));
    }
  }
  $front = get_page_by_title('Home');
  if (!$front) {
    $front_id = wp_insert_post(array(
      'post_title' => 'Home',
      'post_status' => 'publish',
      'post_type' => 'page',
    ));
    if ($front_id) {
      update_option('page_on_front', $front_id);
      update_option('show_on_front', 'page');
    }
  }
}
add_action('after_switch_theme', 'furscoopers_activate');

function furscoopers_jsonld() {
  if (!is_front_page()) return;
  // JSON-LD from original HTML
  ?>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "@id": "https://furscoopers.com/#business",
    "name": "Fur Scoopers",
    "description": "Professional dog waste removal service with transparent flat-rate pricing. Weekly cleanup, deodorization, and yard maintenance services.",
    "url": "https://furscoopers.com",
    "logo": "https://furscoopers.com/fur.scoopers.text.png",
    "image": [
      "https://furscoopers.com/fur-scoopers-social-image.jpg",
      "https://furscoopers.com/fur.scoopers.text.png"
    ],
    "telephone": "(919) 537-6714",
    "email": "info@furscoopers.com",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Rolesville",
      "addressRegion": "NC",
      "addressCountry": "US"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": "35.9237",
      "longitude": "-78.4578"
    },
    "areaServed": {
      "@type": "State",
      "name": "North Carolina"
    },
    "serviceType": "Pet Waste Removal Service",
    "priceRange": "$35-$140",
    "paymentAccepted": "Credit Card, Debit Card",
    "currenciesAccepted": "USD",
    "openingHours": "Mo-Fr 08:00-18:00",
    "sameAs": [
      "https://facebook.com/furscoopers",
      "https://instagram.com/furscoopers",
      "https://twitter.com/furscoopers"
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "Dog Waste Removal Service",
    "description": "Professional pet waste removal and yard deodorization service with transparent flat-rate pricing",
    "provider": {
      "@type": "LocalBusiness",
      "name": "Fur Scoopers"
    },
    "serviceType": "Pet Care Service",
    "offers": [
      {
        "@type": "Offer",
        "name": "Weekly Dog Waste Removal",
        "description": "Weekly professional cleanup of backyard dog waste",
        "price": "80",
        "priceCurrency": "USD",
        "priceSpecification": {
          "@type": "UnitPriceSpecification",
          "price": "80",
          "priceCurrency": "USD",
          "unitText": "per month"
        }
      },
      {
        "@type": "Offer",
        "name": "Twice Weekly Dog Waste Removal",
        "description": "Twice weekly professional cleanup of backyard dog waste",
        "price": "140",
        "priceCurrency": "USD",
        "priceSpecification": {
          "@type": "UnitPriceSpecification",
          "price": "140",
          "priceCurrency": "USD",
          "unitText": "per month"
        }
      },
      {
        "@type": "Offer",
        "name": "Monthly Dog Waste Removal",
        "description": "Monthly professional cleanup of backyard dog waste",
        "price": "35",
        "priceCurrency": "USD",
        "priceSpecification": {
          "@type": "UnitPriceSpecification",
          "price": "35",
          "priceCurrency": "USD",
          "unitText": "per month"
        }
      },
      {
        "@type": "Offer",
        "name": "One-Time Cleanup",
        "description": "Single professional cleanup service",
        "price": "45",
        "priceCurrency": "USD"
      }
    ],
    "areaServed": {
      "@type": "State",
      "name": "North Carolina"
    }
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "Do you service my area?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "We service most residential areas. Contact us with your address and we'll let you know if we can reach you!"
        }
      },
      {
        "@type": "Question",
        "name": "What if I have multiple dogs?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Our flat-rate pricing covers any number of dogs, regardless of size. No extra charges for multiple pets!"
        }
      },
      {
        "@type": "Question",
        "name": "Do I need to be home during service?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "No! We can service your yard while you're away. Just ensure we have access to your backyard."
        }
      },
      {
        "@type": "Question",
        "name": "What happens in bad weather?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "We service in light rain but will reschedule for severe weather. Make-up services are always included at no extra charge."
        }
      }
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://furscoopers.com/"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Services",
        "item": "https://furscoopers.com/#services"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "name": "Pricing",
        "item": "https://furscoopers.com/#pricing"
      }
    ]
  }
  </script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Fur Scoopers",
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.9",
      "reviewCount": "127",
      "bestRating": "5",
      "worstRating": "1"
    },
    "review": [
      {
        "@type": "Review",
        "author": {
          "@type": "Person",
          "name": "Sarah M."
        },
        "datePublished": "2024-12-15",
        "reviewBody": "Finally, a service with honest pricing! I love knowing I pay the same rate as everyone else. My yard has never looked better.",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "5",
          "bestRating": "5"
        }
      },
      {
        "@type": "Review",
        "author": {
          "@type": "Person",
          "name": "Mike R."
        },
        "datePublished": "2024-11-28",
        "reviewBody": "The deodorization service is amazing. No more embarrassing smells when we have barbecues. Highly recommend!",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "5",
          "bestRating": "5"
        }
      },
      {
        "@type": "Review",
        "author": {
          "@type": "Person",
          "name": "Jennifer L."
        },
        "datePublished": "2024-10-14",
        "reviewBody": "Professional, reliable, and fairly priced. My three dogs create quite a mess, but these guys handle it all with a smile.",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "5",
          "bestRating": "5"
        }
      }
    ]
  }
  </script>
  <?php
}
add_action('wp_head','furscoopers_jsonld');

// AJAX handler for subscription signup
add_action('wp_ajax_handle_subscription_signup', 'handle_subscription_signup');
add_action('wp_ajax_nopriv_handle_subscription_signup', 'handle_subscription_signup');

function handle_subscription_signup() {
    // Verify nonce
//    if (!wp_verify_nonce($_POST['nonce'], 'furscoopers_subscription_nonce')) {
//        wp_die('Security check failed');
//    }

    // Check if WooCommerce and WooCommerce Subscriptions are active
    if (!class_exists('WooCommerce') || !class_exists('WC_Subscriptions')) {
        wp_send_json_error(array('message' => 'WooCommerce or WooCommerce Subscriptions is not active'));
        return;
    }

    // Sanitize form data
    $service_frequency = sanitize_text_field($_POST['serviceFrequency']);
    $deodorizing = isset($_POST['deodorizing']) && $_POST['deodorizing'] === 'true';
    $front_yard = isset($_POST['frontYard']) && $_POST['frontYard'] === 'true';

    // Customer data
    $customer_data = array(
        'firstName' => sanitize_text_field($_POST['firstName']),
        'lastName' => sanitize_text_field($_POST['lastName']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone']),
        'address' => sanitize_text_field($_POST['address']),
        'city' => sanitize_text_field($_POST['city']),
        'zipCode' => sanitize_text_field($_POST['zipCode']),
        'gateCode' => sanitize_textarea_field($_POST['gateCode']),
        'numDogs' => sanitize_text_field($_POST['numDogs']),
        'startDate' => sanitize_text_field($_POST['startDate']),
        'specialNotes' => sanitize_textarea_field($_POST['specialNotes'])
    );

    try {
        // Clear existing cart
        WC()->cart->empty_cart();

        // Get or create main service product
        $main_product_id = get_or_create_service_product($service_frequency);
        if (!$main_product_id) {
            throw new Exception('Failed to create main service product');
        }

        // Add main service to cart
        WC()->cart->add_to_cart($main_product_id, 1);

        // Add deodorization add-on if selected
        if ($deodorizing) {
            $deodorizing_product_id = get_or_create_addon_product('deodorization', 15);
            if ($deodorizing_product_id) {
                WC()->cart->add_to_cart($deodorizing_product_id, 1);
            }
        }

        // Add front yard add-on if selected
        if ($front_yard) {
            $front_yard_product_id = get_or_create_addon_product('front-yard', 10);
            if ($front_yard_product_id) {
                WC()->cart->add_to_cart($front_yard_product_id, 1);
            }
        }

        // Store customer data in session for checkout
        WC()->session->set('furscoopers_customer_data', $customer_data);

        // Get checkout URL
        $checkout_url = wc_get_checkout_url();

        wp_send_json_success(array(
            'message' => 'Products added to cart successfully',
            'checkout_url' => $checkout_url
        ));

    } catch (Exception $e) {
        wp_send_json_error(array('message' => $e->getMessage()));
    }
}

function get_or_create_service_product($frequency) {
    $services = array(
            'weekly' => array(
                    'name'  => 'Weekly Dog Waste Removal',
                    'price' => 80,
                    'type'  => 'subscription',
            ),
            'twice-weekly' => array(
                    'name'  => 'Twice Weekly Dog Waste Removal',
                    'price' => 140,
                    'type'  => 'subscription',
            ),
            'monthly' => array(
                    'name'  => 'Monthly Dog Waste Removal',
                    'price' => 35,
                    'type'  => 'subscription',
            ),
            'one-time' => array(
                    'name'  => 'One-Time Dog Waste Cleanup',
                    'price' => 45,
                    'type'  => 'simple',
            ),
    );

    if ( ! isset( $services[ $frequency ] ) ) {
        return false;
    }

    $service      = $services[ $frequency ];
    $product_slug = 'furscoopers-' . $frequency . '-service';

    // Check if product already exists
    $existing_product = get_page_by_path( $product_slug, OBJECT, 'product' );
    if ( $existing_product ) {
        $product_id = $existing_product->ID;

        // Force WooCommerce to reload product data
        wc_delete_product_transients( $product_id );
        $product = wc_get_product( $product_id );

        // If product fails to load, try to create new object based on type
        if ( ! $product ) {
            // Get product type from taxonomy
            $product_type_terms = wp_get_object_terms($product_id, 'product_type');
            $product_type = !is_wp_error($product_type_terms) && !empty($product_type_terms) ? $product_type_terms[0]->name : 'simple';

            try {
                // Try to instantiate based on product type
                switch ($product_type) {
                    case 'subscription':
                        $product = new WC_Product_Subscription($product_id);
                        break;
                    default:
                        $product = new WC_Product_Simple($product_id);
                        break;
                }
            } catch (Exception $e) {
                // If all else fails, log error and return false
                error_log('Failed to instantiate product object for ID: ' . $product_id);
                return false;
            }
        }

        // Repair product if type doesn't match
        if ( $service['type'] === 'subscription' && ! $product->is_type( 'subscription' ) ) {
            wp_set_object_terms( $product_id, 'subscription', 'product_type' );
            update_post_meta( $product_id, '_subscription_price', $service['price'] );
            update_post_meta( $product_id, '_subscription_period', 'month' );
            update_post_meta( $product_id, '_subscription_period_interval', '1' );
            update_post_meta( $product_id, '_subscription_length', '0' );
            update_post_meta( $product_id, '_subscription_sign_up_fee', '0' );
            update_post_meta( $product_id, '_subscription_trial_length', '0' );
            update_post_meta( $product_id, '_subscription_trial_period', 'day' );
        }

        return $product_id;
    }

    // Otherwise create new product
    $product_id = wp_insert_post( array(
            'post_title'   => $service['name'],
            'post_name'    => $product_slug,
            'post_content' => $service['name'],
            'post_status'  => 'publish',
            'post_type'    => 'product',
    ) );

    if ( $service['type'] === 'subscription' ) {
        wp_set_object_terms( $product_id, 'subscription', 'product_type' );
        update_post_meta( $product_id, '_regular_price', $service['price'] );
        update_post_meta( $product_id, '_price', $service['price'] );
        update_post_meta( $product_id, '_subscription_price', $service['price'] );
        update_post_meta( $product_id, '_subscription_period', 'month' );
        update_post_meta( $product_id, '_subscription_period_interval', '1' );
        update_post_meta( $product_id, '_subscription_length', '0' );
        update_post_meta( $product_id, '_subscription_sign_up_fee', '0' );
        update_post_meta( $product_id, '_subscription_trial_length', '0' );
        update_post_meta( $product_id, '_subscription_trial_period', 'day' );
    } else {
        wp_set_object_terms( $product_id, 'simple', 'product_type' );
        update_post_meta( $product_id, '_regular_price', $service['price'] );
        update_post_meta( $product_id, '_price', $service['price'] );
    }

    wc_delete_product_transients( $product_id );

    return $product_id;
}

function get_or_create_addon_product($addon_type, $price) {
    $addons = array(
        'deodorization' => 'Yard Deodorization Add-On',
        'front-yard' => 'Front Yard Service Add-On'
    );

    if (!isset($addons[$addon_type])) {
        return false;
    }

    $product_name = $addons[$addon_type];
    $product_slug = 'furscoopers-' . $addon_type . '-addon';

    // Check if product already exists
    $existing_product = get_page_by_path($product_slug, OBJECT, 'product');
    if ($existing_product) {
        return $existing_product->ID;
    }

    // Create new add-on product
    $product = new WC_Product_Simple();
    $product->set_name($product_name);
    $product->set_slug($product_slug);
    $product->set_regular_price($price);
    $product->set_description('Add-on service for Fur Scoopers waste removal');
    $product->set_status('publish');
    $product->set_catalog_visibility('visible');
    $product->set_virtual(true);
    $product->save();

    return $product->get_id();
}

// Hook to populate checkout fields with customer data
add_filter('woocommerce_checkout_get_value', 'populate_checkout_field_values', 10, 2);

function populate_checkout_field_values($value, $input) {
    $customer_data = WC()->session->get('furscoopers_customer_data');

    if (!$customer_data) {
        return $value;
    }

    // Map form fields to checkout fields
    $field_mapping = array(
        'billing_first_name' => $customer_data['firstName'] ?? '',
        'billing_last_name' => $customer_data['lastName'] ?? '',
        'billing_email' => $customer_data['email'] ?? '',
        'billing_phone' => $customer_data['phone'] ?? '',
        'billing_address_1' => $customer_data['address'] ?? '',
        'billing_city' => $customer_data['city'] ?? '',
        'billing_postcode' => $customer_data['zipCode'] ?? '',
        'billing_state' => 'NC',
        'billing_country' => 'US',
        'shipping_first_name' => $customer_data['firstName'] ?? '',
        'shipping_last_name' => $customer_data['lastName'] ?? '',
        'shipping_address_1' => $customer_data['address'] ?? '',
        'shipping_city' => $customer_data['city'] ?? '',
        'shipping_postcode' => $customer_data['zipCode'] ?? '',
        'shipping_state' => 'NC',
        'shipping_country' => 'US',
        'order_comments' => $customer_data['specialNotes'] ?? ''
    );

    // Return the mapped value if it exists, otherwise return the original value
    return isset($field_mapping[$input]) ? $field_mapping[$input] : $value;
}

// Direct form submission handler for subscription signup
// Use woocommerce_init instead of init to ensure WooCommerce is fully initialized
// This is crucial for first-time visitors in incognito mode
//add_action('woocommerce_init', 'handle_direct_subscription_signup');

function handle_direct_subscription_signup() {
    // Check if form was submitted
    if (!isset($_POST['action']) || $_POST['action'] !== 'furscoopers_signup') {
        return;
    }

    // Verify nonce
//    if (!wp_verify_nonce($_POST['furscoopers_nonce'], 'furscoopers_subscription')) {
//        wp_die('Security check failed');
//    }

    // Check if WooCommerce and WooCommerce Subscriptions are active
    if (!class_exists('WooCommerce') || !class_exists('WC_Subscriptions')) {
        wp_die('WooCommerce or WooCommerce Subscriptions is not active');
    }

    // Sanitize form data
    $service_frequency = sanitize_text_field($_POST['serviceFrequency']);
    $deodorizing = isset($_POST['deodorizing']) && $_POST['deodorizing'] === '1';
    $front_yard = isset($_POST['frontYard']) && $_POST['frontYard'] === '1';

    // Customer data
    $customer_data = array(
        'firstName' => sanitize_text_field($_POST['firstName']),
        'lastName' => sanitize_text_field($_POST['lastName']),
        'email' => sanitize_email($_POST['email']),
        'phone' => sanitize_text_field($_POST['phone']),
        'address' => sanitize_text_field($_POST['address']),
        'city' => sanitize_text_field($_POST['city']),
        'zipCode' => sanitize_text_field($_POST['zipCode']),
        'gateCode' => sanitize_textarea_field($_POST['gateCode']),
        'numDogs' => sanitize_text_field($_POST['numDogs']),
        'startDate' => sanitize_text_field($_POST['startDate']),
        'specialNotes' => sanitize_textarea_field($_POST['specialNotes'])
    );

    try {
        // Ensure WooCommerce session is initialized for non-logged-in users
        if (!is_user_logged_in() && WC()->session) {
            // Initialize session if not already done
            if (!WC()->session->get_customer_id()) {
                WC()->session->init();
                WC()->session->set_customer_session_cookie(true);
            }
        }

        // Initialize cart if not already done
        if (!WC()->cart) {
            WC()->initialize_cart();
        }

        // IMPORTANT: Create all products FIRST before clearing cart and adding items
        // This prevents WooCommerce Subscriptions cart validator from removing items
        // due to products being modified after being added to cart

        // Get or create main service product
        $main_product_id = get_or_create_service_product($service_frequency);
        if (!$main_product_id) {
            throw new Exception('Failed to create main service product');
        }

        // Pre-create add-on products if needed
        $deodorizing_product_id = null;
        if ($deodorizing) {
            $deodorizing_product_id = get_or_create_addon_product('deodorization', 15);
        }

        $front_yard_product_id = null;
        if ($front_yard) {
            $front_yard_product_id = get_or_create_addon_product('front-yard', 10);
        }

        // Clear existing cart AFTER all products are created
        WC()->cart->empty_cart();

        // Add main service to cart with comprehensive fallback methods
        $main_cart_key = add_product_to_cart_with_comprehensive_fallback($main_product_id, 1);

        // Verify cart count after adding main service
        if (WC()->cart->get_cart_contents_count() === 0) {
            throw new Exception('Main service was not added to cart - cart count is 0 after add_to_cart returned success');
        }

        // Add deodorization add-on if selected
        if ($deodorizing && $deodorizing_product_id) {
            $deodorizing_cart_key = add_product_to_cart_with_comprehensive_fallback($deodorizing_product_id, 1);
            if (!$deodorizing_cart_key) {
                throw new Exception('Failed to add deodorization add-on to cart');
            }
        }

        // Add front yard add-on if selected
        if ($front_yard && $front_yard_product_id) {
            $front_yard_cart_key = add_product_to_cart_with_comprehensive_fallback($front_yard_product_id, 1);
            if (!$front_yard_cart_key) {
                throw new Exception('Failed to add front yard add-on to cart');
            }
        }

        // Store customer data in session for checkout
        WC()->session->set('furscoopers_customer_data', $customer_data);

        // Force cart session data to be saved properly for checkout page
        WC()->cart->persistent_cart_update();
        WC()->session->save_data();

        // Ensure cart is properly loaded from session before redirect
        WC()->cart->get_cart_from_session();

        // Force session cookies to be set for the redirect
        WC()->session->set_customer_session_cookie(true);

        // Additional session persistence to ensure data survives redirect
        if (method_exists(WC()->session, 'save_data')) {
            WC()->session->save_data();
        }
        WC()->cart->calculate_totals();

        // Redirect to checkout
        wp_redirect(wc_get_checkout_url());
        exit;

    } catch (Exception $e) {
        wp_die('Error: ' . $e->getMessage());
    }
}

//function handle_direct_subscription_signup() {
//    // Check if form was submitted
//    if (!isset($_POST['action']) || $_POST['action'] !== 'furscoopers_signup') {
//        return;
//    }
//
//    // Force WooCommerce session initialization
//    if (!is_user_logged_in() && !WC()->session->has_session()) {
//        if (null === WC()->session) {
//            WC()->initialize_session();
//        }
//        WC()->session->set_customer_session_cookie(true);
//    }
//
//    // Sanitize form data
//    $service_frequency = sanitize_text_field($_POST['serviceFrequency']);
//    $deodorizing = isset($_POST['deodorizing']) && $_POST['deodorizing'] === '1';
//    $front_yard = isset($_POST['frontYard']) && $_POST['frontYard'] === '1';
//
//    // Get or create all products FIRST before adding to cart
//    $main_product_id = get_or_create_service_product($service_frequency);
//    if (!$main_product_id) {
//        wp_die('Failed to create main service product.');
//    }
//
//    $deodorizing_product_id = null;
//    if ($deodorizing) {
//        $deodorizing_product_id = get_or_create_addon_product('deodorization', 15);
//    }
//
//    $front_yard_product_id = null;
//    if ($front_yard) {
//        $front_yard_product_id = get_or_create_addon_product('front-yard', 10);
//    }
//
//    // Store customer data in session for checkout
//    $customer_data = array(
//            'firstName' => sanitize_text_field($_POST['firstName']),
//            'lastName' => sanitize_text_field($_POST['lastName']),
//            'email' => sanitize_email($_POST['email']),
//            'phone' => sanitize_text_field($_POST['phone']),
//            'address' => sanitize_text_field($_POST['address']),
//            'city' => sanitize_text_field($_POST['city']),
//            'zipCode' => sanitize_text_field($_POST['zipCode']),
//            'gateCode' => sanitize_textarea_field($_POST['gateCode']),
//            'numDogs' => sanitize_text_field($_POST['numDogs']),
//            'startDate' => sanitize_text_field($_POST['startDate']),
//            'specialNotes' => sanitize_textarea_field($_POST['specialNotes'])
//    );
//    WC()->session->set('furscoopers_customer_data', $customer_data);
//
//    // Clear cart and add products programmatically
//    WC()->cart->empty_cart();
//
//    // Add main service
//    WC()->cart->add_to_cart($main_product_id, 1);
//
//    // Add deodorization add-on if selected
//    if ($deodorizing && $deodorizing_product_id) {
//        WC()->cart->add_to_cart($deodorizing_product_id, 1);
//    }
//
//    // Add front yard add-on if selected
//    if ($front_yard && $front_yard_product_id) {
//        WC()->cart->add_to_cart($front_yard_product_id, 1);
//    }
//
//    // Ensure cart and session data are persisted
//    WC()->cart->calculate_totals();
//    WC()->session->save_data();
//
//    // Redirect to checkout
//    wp_redirect(wc_get_checkout_url());
//    exit;
//}
//add_action('woocommerce_init', 'handle_direct_subscription_signup');
add_action('wp_loaded', 'handle_direct_subscription_signup');

/**
 * Comprehensive cart addition function that handles all validation and fallback scenarios
 * This function eliminates cart addition failures by using multiple approaches
 */
function add_product_to_cart_with_comprehensive_fallback($product_id, $quantity = 1) {
    // Method 1: Standard WooCommerce add_to_cart
    $cart_key = WC()->cart->add_to_cart($product_id, $quantity);
    if ($cart_key) {
        return $cart_key;
    }

    // Method 2: Bypass all validation filters and try again
    wc_clear_notices();

    // Temporarily disable all WooCommerce validation filters
    $validation_filters = array(
        'woocommerce_add_to_cart_validation' => array(),
        'woocommerce_cart_loaded_from_session' => array()
    );

    // Store current filters to restore later
    global $wp_filter;
    foreach ($validation_filters as $filter_name => $stored_filters) {
        if (isset($wp_filter[$filter_name])) {
            $validation_filters[$filter_name] = $wp_filter[$filter_name];
            unset($wp_filter[$filter_name]);
        }
    }

    // Add our own validation bypass
    add_filter('woocommerce_add_to_cart_validation', '__return_true', 999);

    // Try add_to_cart with all validations bypassed
    $cart_key = WC()->cart->add_to_cart($product_id, $quantity);

    // Restore original filters
    foreach ($validation_filters as $filter_name => $stored_filter) {
        if (!empty($stored_filter)) {
            $wp_filter[$filter_name] = $stored_filter;
        }
    }
    remove_filter('woocommerce_add_to_cart_validation', '__return_true', 999);

    if ($cart_key) {
        return $cart_key;
    }

    // Method 3: Direct cart item insertion as final fallback
    $product = get_product_with_fallback($product_id);
    if (!$product || !$product->is_purchasable()) {
        return false;
    }

    // Generate cart item data
    $cart_item_data = array();
    $cart_item_key = WC()->cart->generate_cart_id($product_id, 0, array(), $cart_item_data);

    // Create cart item array
    $cart_item = array(
        'key' => $cart_item_key,
        'product_id' => $product_id,
        'variation_id' => 0,
        'variation' => array(),
        'quantity' => $quantity,
        'data' => $product,
        'data_hash' => wc_get_cart_item_data_hash($product),
        'line_tax_data' => array('subtotal' => array(), 'total' => array()),
        'line_subtotal' => $product->get_price() * $quantity,
        'line_subtotal_tax' => 0,
        'line_total' => $product->get_price() * $quantity,
        'line_tax' => 0
    );

    // Add item directly to cart contents
    WC()->cart->cart_contents[$cart_item_key] = $cart_item;

    // Update cart totals using WooCommerce's built-in method
    WC()->cart->calculate_totals();

    // Trigger cart updated actions
    do_action('woocommerce_cart_contents_changed');
    WC()->cart->maybe_set_cart_cookies();

    return $cart_item_key;
}

/**
 * Enhanced product retrieval with multiple fallback methods
 * Handles edge cases where wc_get_product() might fail intermittently
 */
function get_product_with_fallback($product_id) {
    // Method 1: Standard WooCommerce function
    $product = wc_get_product($product_id);
    if ($product && $product->get_id()) {
        return $product;
    }

    // Method 2: Clear cache and try again
    clean_post_cache($product_id);
    wp_cache_delete($product_id, 'products');
    wp_cache_delete('wc_product_' . $product_id, 'posts');

    $product = wc_get_product($product_id);
    if ($product && $product->get_id()) {
        return $product;
    }

    // Method 3: Check if post exists and try direct instantiation
    $post = get_post($product_id);
    if ($post && $post->post_type === 'product' && $post->post_status === 'publish') {

        // Get product type from taxonomy
        $product_type_terms = wp_get_object_terms($product_id, 'product_type');
        // Check if wp_get_object_terms returned WP_Error
        if (is_wp_error($product_type_terms)) {
            $product_type = 'simple';
        } else {
            $product_type = !empty($product_type_terms) ? $product_type_terms[0]->name : 'simple';
        }

        try {
            // Try to instantiate based on product type
            switch ($product_type) {
                case 'subscription':
                    if (class_exists('WC_Product_Subscription')) {
                        $product = new WC_Product_Subscription($product_id);
                    } else {
                        $product = new WC_Product_Simple($product_id);
                    }
                    break;
                case 'variable':
                    $product = new WC_Product_Variable($product_id);
                    break;
                case 'grouped':
                    $product = new WC_Product_Grouped($product_id);
                    break;
                case 'external':
                    $product = new WC_Product_External($product_id);
                    break;
                default:
                    $product = new WC_Product_Simple($product_id);
                    break;
            }

            if ($product && $product->get_id()) {
                return $product;
            }
        } catch (Exception $e) {
            // Continue to next method if instantiation fails
        }
    }

    // Method 4: Force refresh from database
    wp_cache_flush();
    $product = wc_get_product($product_id);
    if ($product && $product->get_id()) {
        return $product;
    }

    // All methods failed
    return false;
}

// Hook to save custom order meta data
add_action('woocommerce_checkout_order_processed', 'save_furscoopers_order_meta', 10, 1);

function save_furscoopers_order_meta($order_id) {
    $customer_data = WC()->session->get('furscoopers_customer_data');

    if (!$customer_data) {
        return;
    }

    // Save additional form fields as order meta
    if (!empty($customer_data['gateCode'])) {
        update_post_meta($order_id, '_furscoopers_gate_code', sanitize_textarea_field($customer_data['gateCode']));
    }

    if (!empty($customer_data['numDogs'])) {
        update_post_meta($order_id, '_furscoopers_num_dogs', sanitize_text_field($customer_data['numDogs']));
    }

    if (!empty($customer_data['startDate'])) {
        update_post_meta($order_id, '_furscoopers_start_date', sanitize_text_field($customer_data['startDate']));
    }

    // Save service frequency for reference
    if (!empty($customer_data['serviceFrequency'])) {
        update_post_meta($order_id, '_furscoopers_service_frequency', sanitize_text_field($customer_data['serviceFrequency']));
    }

    // Clear the session data after saving
    WC()->session->__unset('furscoopers_customer_data');
}

// Hook to display custom fields in admin order details
add_action('woocommerce_admin_order_data_after_billing_address', 'display_furscoopers_order_meta_in_admin', 10, 1);

// Hook to ensure cart loads from session on checkout page
add_action('template_redirect', 'ensure_cart_loads_from_session_on_checkout');

function ensure_cart_loads_from_session_on_checkout() {
    // Only run for non-logged-in users when WooCommerce components are available
    if (!is_user_logged_in() && WC()->session && WC()->cart) {
        // Check multiple conditions for checkout page detection
        $is_checkout_page = false;

        // Method 1: Standard WordPress checkout detection
        if (function_exists('is_checkout') && is_checkout()) {
            $is_checkout_page = true;
        }

        // Method 2: Check current page URL/slug
        global $post;
        if ($post && $post->post_name === 'checkout') {
            $is_checkout_page = true;
        }

        // Method 3: Check query vars
        global $wp_query;
        if (isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] === 'checkout') {
            $is_checkout_page = true;
        }

        // Method 4: Check current URL path
        $current_url = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($current_url, '/checkout') !== false || strpos($current_url, 'checkout') !== false) {
            $is_checkout_page = true;
        }

        // If we're on checkout page (detected by any method) and cart appears empty
        if ($is_checkout_page && WC()->cart->get_cart_contents_count() === 0 && WC()->session->has_session()) {
            // Method 1: Standard cart restoration
            WC()->cart->get_cart_from_session();

            // Method 2: If still empty, try direct session data restoration
            if (WC()->cart->get_cart_contents_count() === 0) {
                $cart_data = WC()->session->get('cart');
                if ($cart_data) {
                    $unserialized_cart = maybe_unserialize($cart_data);
                    if (is_array($unserialized_cart) && !empty($unserialized_cart)) {
                        WC()->cart->set_cart_contents($unserialized_cart);
                        WC()->cart->calculate_totals();
                    }
                }
            }

            // Method 3: If still empty, try loading from session cookies
            if (WC()->cart->get_cart_contents_count() === 0) {
                // Force session reload and cart restoration
                WC()->session->init();
                WC()->cart->get_cart_from_session();

                // Final attempt with session data
                if (WC()->cart->get_cart_contents_count() === 0) {
                    $session_data = WC()->session->get_session_data();
                    if (isset($session_data['cart']) && !empty($session_data['cart'])) {
                        $cart_from_session = maybe_unserialize($session_data['cart']);
                        if (is_array($cart_from_session)) {
                            WC()->cart->set_cart_contents($cart_from_session);
                            WC()->cart->calculate_totals();
                        }
                    }
                }
            }
        }

        // Also run for any page if cart is empty but should have items
        // (This covers cases where checkout page detection might fail)
        if (WC()->cart->get_cart_contents_count() === 0 && WC()->session->has_session()) {
            $session_data = WC()->session->get_session_data();
            if (isset($session_data['cart']) && !empty($session_data['cart'])) {
                // There's cart data in session but cart appears empty - restore it
                WC()->cart->get_cart_from_session();
                if (WC()->cart->get_cart_contents_count() === 0) {
                    $cart_from_session = maybe_unserialize($session_data['cart']);
                    if (is_array($cart_from_session) && !empty($cart_from_session)) {
                        WC()->cart->set_cart_contents($cart_from_session);
                        WC()->cart->calculate_totals();
                    }
                }
            }
        }
    }
}

function display_furscoopers_order_meta_in_admin($order) {
    $order_id = $order->get_id();

    echo '<div class="furscoopers-order-meta">';
    echo '<h3>Service Details</h3>';

    $gate_code = get_post_meta($order_id, '_furscoopers_gate_code', true);
    if ($gate_code) {
        echo '<p><strong>Gate Code / Access Instructions:</strong><br>' . esc_html($gate_code) . '</p>';
    }

    $num_dogs = get_post_meta($order_id, '_furscoopers_num_dogs', true);
    if ($num_dogs) {
        echo '<p><strong>Number of Dogs:</strong> ' . esc_html($num_dogs) . '</p>';
    }

    $start_date = get_post_meta($order_id, '_furscoopers_start_date', true);
    if ($start_date) {
        echo '<p><strong>Preferred Start Date:</strong> ' . esc_html($start_date) . '</p>';
    }

    $service_frequency = get_post_meta($order_id, '_furscoopers_service_frequency', true);
    if ($service_frequency) {
        echo '<p><strong>Service Frequency:</strong> ' . esc_html(ucwords(str_replace('-', ' ', $service_frequency))) . '</p>';
    }

    echo '</div>';
}

// Disable WC Subscriptions removing items from the cart
add_action('init', function () {
    // WC_Subscriptions_Cart hooks into woocommerce_get_cart_item_from_session at priority 10
    remove_filter('woocommerce_get_cart_item_from_session', 'WC_Subscriptions_Cart::get_cart_item_from_session', 10);
});

// Disable WC Subscriptions removing items from the cart
add_action('wp_loaded', function () {
    // Check if the necessary classes and methods exist before trying to remove the filter
    if (class_exists('WC_Subscriptions_Cart') && method_exists('WC_Subscriptions_Cart', 'get_cart_item_from_session')) {
        remove_filter('woocommerce_get_cart_item_from_session', array('WC_Subscriptions_Cart', 'get_cart_item_from_session'), 10);
    }
});