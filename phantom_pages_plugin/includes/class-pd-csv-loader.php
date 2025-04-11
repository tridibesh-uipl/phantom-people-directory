<?php
class PD_CSV_Loader {
    private static $profiles = null;
    private static $csv_file = '';

    public static function init() {
        self::$csv_file = PD_PLUGIN_DIR . 'profiles.csv';
    }

    public static function get_profiles() {
        if (self::$profiles === null) {
            $transient_key = 'pd_profiles_data';
            $cached = get_transient($transient_key);
            if ($cached !== false) {
                self::$profiles = $cached;
            } else {
                self::$profiles = [];
                if (file_exists(self::$csv_file)) {
                    if (($handle = fopen(self::$csv_file, "r")) !== false) {
                        $header = fgetcsv($handle, 1000, ',');
                        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                            $row = array_combine($header, $data);
                            $slug = sanitize_title($row['slug']);
                            self::$profiles[$slug] = $row;
                        }
                        fclose($handle);
                    }
                }
                set_transient($transient_key, self::$profiles, HOUR_IN_SECONDS);
            }
        }
        return self::$profiles;
    }

    public static function get_profile_by_slug($slug) {
        $profiles = self::get_profiles();
        return $profiles[$slug] ?? false;
    }
}