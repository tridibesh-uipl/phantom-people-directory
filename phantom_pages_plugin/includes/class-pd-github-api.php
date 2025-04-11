<?php
class PD_GitHub_API {
    public static function init() {}

    public static function get_user_data($github_username) {
        $transient_key = 'pd_github_' . sanitize_title($github_username);
        $data = get_transient($transient_key);
        if ($data !== false) return $data;

        $url = "https://api.github.com/users/" . urlencode($github_username);
        $args = ['headers' => ['User-Agent' => 'WordPress-PeopleDirectory-Plugin'], 'timeout' => 15];
        $response = wp_remote_get($url, $args);
        if (is_wp_error($response)) return false;
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        if (isset($data['message']) && $data['message'] === 'Not Found') return false;
        set_transient($transient_key, $data, HOUR_IN_SECONDS);
        return $data;
    }
}