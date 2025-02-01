<?php

class Share_Login_Helper {

    /**
     * Generate a random string of a given length
     * @param int $length
     * @return string
     */
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }

    public static function get_base_url(){
        // Check if HTTP_HOST is set and sanitize it
        $http_host = isset($_SERVER['HTTP_HOST']) ? wp_unslash($_SERVER['HTTP_HOST']) : '';
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http',
            $http_host
        );
    }
    
    public static function get_url_to_base($url){
        if($url == ''){
            return '';
        }
        // Sanitize the input URL
        $url = esc_url($url);
        // Replace parse_url with wp_parse_url
        $parsed_url = wp_parse_url($url);
        return $parsed_url['scheme'] . '://' . $parsed_url['host'];
    }

	public static function localize_data() {
		$data = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('share-login-nonce'),
            'plugin_dashboard_url' => admin_url('admin.php?page=share-login'),
            'site_origin' => Share_Login_Helper::get_base_url(),
            'sync_origin' => Share_Login_Helper::get_url_to_base(SL_SYNC_SITE_URL),
            'main_site_url' => SL_MAIN_SITE_URL,
            'sync_site_url' => SL_SYNC_SITE_URL,
            'plugin_url' => SL_PLUGIN_URL,
		);
		return $data;
	}    
}

