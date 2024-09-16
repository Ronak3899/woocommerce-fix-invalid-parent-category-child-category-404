<?php
// Hook into template redirect to modify WooCommerce category URL handling
add_action('template_redirect', 'custom_woocommerce_category_404');

/**
 * Custom function to trigger a 404 error if the WooCommerce category URL structure is invalid.
 * This checks if the parent category in the URL is correct for the given child category.
 */
function custom_woocommerce_category_404() {
    if (is_product_category()) {
        // Get the current queried category object
        $category = get_queried_object();

        // If the category doesn't exist, trigger a 404 error
        if (!$category || !term_exists($category->slug, 'product_cat')) {
            handle_404();
        }

        // Check if the current category has a parent category and if the URL structure is correct
        if (is_tax('product_cat') && get_query_var('product_cat')) {
            $current_cat_slug = get_query_var('product_cat');
            $current_cat = get_term_by('slug', $current_cat_slug, 'product_cat');

            // If the current category has a parent, compare it with the URL structure
            if ($current_cat && $current_cat->parent != 0) {
                $parent_cat = get_term($current_cat->parent, 'product_cat');

                // Extract the parent category slug from the URL
                $requested_parent_slug = get_parent_category_from_url();

                // If the parent slug in the URL doesn't match the actual parent, trigger a 404 error
                if ($requested_parent_slug && $requested_parent_slug !== $parent_cat->slug) {
                    handle_404();
                }
            }
        }
    }
}

/**
 * Helper function to extract the parent category from the URL, ignoring pagination.
 * This works by splitting the URL path and retrieving the second-to-last part before 'page'.
 */
function get_parent_category_from_url() {
    global $wp;
    $url_path = $wp->request; // Get the current request URL path
    $parts = explode('/', $url_path);

    // Remove pagination part (e.g., 'page/2') if it exists
    $pagination_index = array_search('page', $parts);
    if ($pagination_index !== false) {
        $parts = array_slice($parts, 0, $pagination_index);
    }

    // Return the second last part of the URL (which should be the parent category slug)
    return (count($parts) > 2) ? $parts[count($parts) - 2] : null;
}

/**
 * Helper function to handle triggering a 404 error.
 * This includes setting the 404 header, including the 404 template, and exiting.
 */
function handle_404() {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
    include(get_query_template('404'));
    exit;
}
?>
