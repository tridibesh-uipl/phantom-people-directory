<?php
class PD_Sitemap {
    public static function init() {
        add_action('init', [__CLASS__, 'add_sitemap_rewrite']);
        add_filter('query_vars', [__CLASS__, 'add_sitemap_query_var']);
        add_action('template_redirect', [__CLASS__, 'render_sitemap']);
    }

    public static function add_sitemap_rewrite() {
        add_rewrite_rule('^sitemap-people\.xml$', 'index.php?pd_sitemap=1', 'top');
    }

    public static function add_sitemap_query_var($vars) {
        $vars[] = 'pd_sitemap';
        return $vars;
    }

    public static function render_sitemap() {
        if (get_query_var('pd_sitemap')) {
            header('Content-Type: application/xml; charset=utf-8');
            echo self::generate_sitemap();
            exit;
        }
    }

    public static function generate_sitemap() {
        $profiles = PD_CSV_Loader::get_profiles();
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($profiles as $profile) {
            $url = home_url('/people/' . sanitize_title($profile['slug']) . '/');
            $sitemap .= '<url><loc>' . esc_url($url) . '</loc><lastmod>' . date('Y-m-d') . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
        }
        $sitemap .= '</urlset>';
        return $sitemap;
    }
}