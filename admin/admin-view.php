<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// Add settings page for the plugin
add_action('admin_menu', 'my_news_feed_settings_page');
function my_news_feed_settings_page() {
    add_menu_page(
        'My News Feed Settings',
        'My News Feed',
        'manage_options',
        'my-news-feed-settings',
        'my_news_feed_settings_callback',
        'dashicons-rss',
        100
    );
}

// Callback function to display the settings page
function my_news_feed_settings_callback() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['submit'])) {
        // Delete cached data
        delete_transient('my_news_feed_data');

        // Save the form data
        $pageSize = sanitize_text_field($_POST['page_size']);
        $category = sanitize_text_field($_POST['category']);
        $apiKey = sanitize_text_field($_POST['api_key']);
        $cacheOption = sanitize_text_field($_POST['cache_option']);
        update_option('my_news_feed_page_size', $pageSize);
        update_option('my_news_feed_category', $category);
        update_option('my_news_feed_api_key', $apiKey);
        update_option('my_news_feed_cache_option', $cacheOption);
        echo '<div class="updated"><p><strong>Settings saved.</strong></p></div>';
    }

    $pageSize = get_option('my_news_feed_page_size', 10);
    $category = get_option('my_news_feed_category', 'business');
    $apiKey = get_option('my_news_feed_api_key', '');
    $cacheOption = get_option('my_news_feed_cache_option', '1min');

    // Display the settings form
    ?>
    <div class="wrap">
        <h1>My News Feed Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="page_size">Page Size</label></th>
                    <td><input name="page_size" type="number" min="1" max="100" step="1" value="<?php echo $pageSize; ?>"></td>
                    <td><p>Maximum value is 100</p></td>
                    <td><p>Default is 10</p></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="category">Category</label></th>
                    <td><input name="category" type="text" value="<?php echo $category; ?>"></td>
                    <td><p>Valid categories: business-entertainment-general-health-science-sports-technology</p></td>
                    <td><p>Default is business</p></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="api_key">API Key</label></th>
                    <td><input name="api_key" type="text" value="<?php echo $apiKey; ?>"></td>
                    <td><p>Cache option is used to avoid fetching API each time a user load the page</p></td>
                    <td><p>Default is 1 Hour</p></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="cache_option">Cache Option</label></th>
                    <td>
                        <select name="cache_option">
                            <option value="1min" <?php selected($cacheOption, '1min'); ?>>1 Minute</option>
                            <option value="1hour" <?php selected($cacheOption, '1hour'); ?>>1 Hour</option>
                            <option value="1day" <?php selected($cacheOption, '1day'); ?>>1 Day</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
            <hr>
            <h3>Shortcode Usage:</h3>
            <p>Add the following shortcode to any page or post to display the news feed:</p>
            <h1><span style="background-color: yellow;">[Newsapi-feed]</span></h1>
        </form>
    </div>
    <?php
}
?>