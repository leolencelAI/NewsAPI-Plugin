<?php
/**
* Plugin Name: newsapi-feed
* Plugin URI: https://venturecapitalist.io/
* Description: Newsapi-feed is a plugin to embed news from newsapi
* Version: 1.0
* Author: LENCEL Léo
* Author URI: https://github.com/leolencelAI
**/


#Security firewall
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'admin/admin-view.php';

function my_news_feed() {
	wp_enqueue_style('my_news_feed_style', plugins_url('static/css/newsapi-feed.css', __FILE__));
	
	$cache_key = 'my_news_feed_data';
    $cached_data = get_transient($cache_key);
	
	if ($cached_data !== false) {
		// Return cached data
		return $cached_data;
    }

    // Get the settings values
    $pageSize = get_option('my_news_feed_page_size', 10);
    $category = get_option('my_news_feed_category', 'business');
    $apiKey = get_option('my_news_feed_api_key', '');
    $cache = get_option('my_news_feed_cache_option', '1min');
	
    $url = 'https://newsapi.org/v2/top-headlines?country=us';
    $url .= '&category=' . $category;
    $url .= '&pageSize=' . $pageSize;
    $url .= '&apiKey=' . $apiKey;

    // Set the User-Agent header
    $args = array(
        'headers' => array(
            'User-Agent' => 'My News App v1.0'
        )
    );

    // Fetch the news feed data from the NewsAPI
    $response = wp_remote_get($url, $args);
    $data = json_decode(wp_remote_retrieve_body($response));

    // Display the news feed
    $output = '<div class="article">';
    foreach ($data->articles as $article) {
        $output .= '<div class="article_unique">';
        $output .= '<img src="' . $article->urlToImage . '" alt="" class="article_unique_img">';
        $output .= '<div class="article_unique_container"><a href="' . $article->url . '" class="article_unique_link">';
        $output .= '<h2 class="article_unique_title">' . $article->title . '</h2></a>';
        $output .= '<p class="article_unique_description">' . $article->description . '</p></div>';
        $output .= '</div>';
    }
    $output .= '</div>';
	
    switch ($cache) {
        case '1min':
          $expiration = MINUTE_IN_SECONDS;
          break;
        case '1day':
          $expiration = DAY_IN_SECONDS;
          break;
        default:
          $expiration = HOUR_IN_SECONDS;
    }
      
	// Cache the news data in WordPress for 1 min or cache time selected by user
    set_transient($cache_key, $output, $expiration);

    return $output;
}
add_shortcode( 'Newsapi-feed', 'my_news_feed');
?>
