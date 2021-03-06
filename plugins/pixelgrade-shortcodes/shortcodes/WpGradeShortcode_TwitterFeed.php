<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_TwitterFeed extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = true;
        $this->direct = false;
        $this->name = "TwitterFeed";
        $this->code = "twitterfeed";
        $this->icon = "icon-group";

        $this->params = array(
            'username' => array(
                'type' => 'text',
                'name' => 'Twitter Username',
                'admin_class' => 'span6'
            ),
            'count' => array(
                'type' => 'text',
                'name' => 'Number of Tweets',
                'admin_class' => 'span5 push1'
            ), 
			'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span6'
            ),
        );

        add_shortcode('twitterfeed', array( $this, 'add_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
        $this->frontend_assets["js"] = array(
            'columns' => array(
                'name' => 'frontend_twitterfeed',
                'path' => 'js/shortcodes/frontend_twitterfeed.js',
                'deps'=> array( 'jquery' )
            )
        );
        add_action('wp_footer', array($this, 'load_frontend_assets'));
    }

    public function add_shortcode($atts){
		
		extract( shortcode_atts( array(
            'username' => '',
            'count' => '',
            'class' => '',
        ), $atts ) );

        $this->load_frontend_scripts = true;
		
		$content = '';
        
        if ( isset($title) && $title != '') $content .= '<h3>' . $title . '</h3>';

        $count = isset( $count ) ? absint( $count ) : 5;
		
		if (!class_exists('StormTwitter')) {
			require_once(WPGRADE_SHORTCODES_PATH . '/vendor/twitter-api/StormTwitter.class.php');
		}

        global $wpGrade_Options;

        $config['key'] = $wpGrade_Options->get('twitter_consumer_key');
        $config['secret'] = $wpGrade_Options->get('twitter_consumer_secret');
        $config['token'] = $wpGrade_Options->get('twitter_oauth_access_token');
        $config['token_secret'] = $wpGrade_Options->get('twitter_oauth_access_token_secret');
        $config['screenname'] = $username;
        if ( isset($config['cache_expire']) && $config['cache_expire'] < 1) $config['cache_expire'] = 3600;
        $config['directory'] = WPGRADE_SHORTCODES_PATH . 'vendor/twitter-api/cache';

        $twitter = new StormTwitter($config);
        $results = $twitter->getTweets($count, $username);

        $link = 'https://twitter.com/'. $username;
		
		
        if ( $results ){
//        	$content .= '<div class="twitter-icon"><i class="icon-twitter"></i></div>';
            $content .= '<div class="twitter-shortcode-tweets_container">';
            $content .= '<ul class="twitter-shortcode-tweets slides '.$class.'">';
            foreach ($results as $key => $result) {
                $content .= '<li class="twitter-shortcode-tweet slide">
                    	<div class="twitter-shortcode-tweet-meta">
                        <span class="twitter-shortcode-screenname">' . ucwords($config['screenname']) . '</span>' .
                        '<span class="twitter-shortcode-username"><a href="'.$link.'">@' . $config['screenname'] . '</a></span>' .
                        '<span class="twitter-shortcode-tweet-date">' . $this->convert_twitter_date($result["created_at"]) . '</span></div>
                         <div class="twitter-shortcode-tweet-content">'.$this->get_parsed_tweet($result) .'</div>                       
                </li>';
            
            }
            $content .= '</ul>';
            $content .= '</div>';
        }
		
		return $content;
    }
	
	public function get_parsed_tweet ($tweet) {
		// check if any entites exist and if so, replace then with hyperlinked versions
		$tweet_text = $tweet['text'];
		if (!empty($tweet['entities']['urls']) || !empty($tweet['entities']['hashtags']) || !empty($tweet['entities']['user_mentions'])) {
				foreach ($tweet['entities']['urls'] as $url) {
						$find = $url['url'];
						$replace = '<a href="'.$find.'" target="_blank" rel="nofollow">'.$find.'</a>';
						$tweet_text = str_replace($find,$replace,$tweet_text);
				}

				foreach ($tweet['entities']['hashtags'] as $hashtag) {
						$find = '#'.$hashtag['text'];
						$replace = '<a href="http://twitter.com/#!/search/%23'.$hashtag['text'].'" target="_blank" rel="nofollow">'.$find.'</a>';
						$tweet_text = str_replace($find,$replace,$tweet_text);
				}

				foreach ($tweet['entities']['user_mentions'] as $user_mention) {
						$find = "@".$user_mention['screen_name'];
						$replace = '<a href="http://twitter.com/'.$user_mention['screen_name'].'" target="_blank" rel="nofollow">'.$find.'</a>';
						$tweet_text = str_ireplace($find,$replace,$tweet_text);
				}
		}
		
		return $tweet_text;
	}
	
	public function convert_twitter_date( $time ) {
		$date = strtotime( $time );
		//return util::human_time_diff($date);
		return gbs_relative_time($date);
	}
	
	public function gbs_relative_time( $timestamp ){
                     
		$difference = current_time( 'timestamp' ) - $timestamp;

		if ( $difference >= 60*60*24*365 ){        // if more than a year ago
			$int = intval( $difference / ( 60*60*24*365 ) );
			$r = sprintf( _n( '%d year ago', '%d years ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60*24*7*5 ){  // if more than five weeks ago
			$int = intval( $difference / ( 60*60*24*30 ) );
			$r = sprintf( _n( '%d month ago', '%d months ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60*24*7 ){        // if more than a week ago
			$int = intval( $difference / ( 60*60*24*7 ) );
			$r = sprintf( _n( '%d week ago', '%d weeks ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60*24){      // if more than a day ago
			$int = intval( $difference / ( 60*60*24 ) );
			$r = sprintf( _n( '%d day ago', '%d days ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60*60 ){         // if more than an hour ago
			$int = intval( $difference / ( 60*60 ) );
			$r = sprintf( _n( '%d hour ago', '%d hours ago', $int, wpGrade_txtd ), $int );
		} elseif ( $difference >= 60 ){            // if more than a minute ago
			$int = intval( $difference / ( 60 ) );
			$r = sprintf( _n( '%d minute ago', '%d minutes ago', $int, wpGrade_txtd ), $int );
		} else {                                // if less than a minute ago
			$r = __( 'moments ago', wpGrade_txtd );
		}

		return $r;
	}
}