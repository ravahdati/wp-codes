
<?php
/**
 * @snippet          Hightlight New Products in WooCommerce
 * @author           Rasool Vahdati
 * @compatible       WooCommerce 7
 */

// Define a function to modify WooCommerce product titles based on the last visit
function highlight_new_products($title, $id)
{
    // Check if not in the loop, a singular page, or not a WooCommerce product; if true, return the original title
    if (!in_the_loop() || is_singular() || get_post_type($id) != 'product') return $title;

    // Check if no 'lastvisit' cookie is set or if it is empty; if true, set the cookie with the current timestamp
    if (!isset($_COOKIE['lastvisit']) || $_COOKIE['lastvisit'] == '') {
        $current = current_time('timestamp', 1);
        setcookie('lastvisit', $current, time() + 60 * 60 * 24 * 7, COOKIEPATH, COOKIE_DOMAIN);
    }

    // Retrieve the 'lastvisit' cookie value
    $lastvisit = $_COOKIE['lastvisit'];

    // Get the publish date of the WooCommerce product (in Unix timestamp format)
    $publish_date = get_post_time('U', true, $id);

    // If the product was published after the last visit, append a new span to the title
    if ($publish_date > $lastvisit) $title .= '<span class="new-product">New</span>';

    // Return the modified or original title
    return $title;
}

add_filter('the_title', 'highlight_new_products', 10, 2);
