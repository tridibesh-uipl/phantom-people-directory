<?php
class PD_Routing {
    public static function init() {
        add_action('init', [__CLASS__, 'add_rewrite_rules']);
        add_filter('query_vars', [__CLASS__, 'add_query_vars']);
        add_action('template_include', [__CLASS__, 'template_loader']);
    }

    public static function add_rewrite_rules() {
        add_rewrite_rule('^people/([^/]+)/?$', 'index.php?person_slug=$matches[1]', 'top');
    }

    public static function add_query_vars($vars) {
        $vars[] = 'person_slug';
        return $vars;
    }

    public static function template_loader($template) {
        $slug = get_query_var('person_slug');
        if ($slug) {
            $profile = PD_CSV_Loader::get_profile_by_slug($slug);
            if ($profile) {
                $new_template = PD_PLUGIN_DIR . 'templates/profile-template.php';
                return file_exists($new_template) ? $new_template : $template;
            } else {
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                return get_404_template();
            }
        }
        return $template;
    }
}