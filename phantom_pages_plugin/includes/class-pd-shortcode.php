<?php
// Inside your plugin
add_shortcode('people_listing', function() {
    ob_start();
    $profiles = PD_CSV_Loader::get_profiles();
    ?>
    <div class="pd-listing-container" style="max-width:800px; margin:0 auto; padding:20px;">
        <h1>People Directory</h1>
        <?php if (!empty($profiles)) : ?>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($profiles as $profile) : ?>
                    <li style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                        <h2 style="margin: 0;">
                            <a href="<?php echo esc_url(home_url('/people/' . sanitize_title($profile['slug']) . '/')); ?>">
                                <?php echo esc_html($profile['name']); ?>
                            </a>
                        </h2>
                        <p><strong>GitHub:</strong> <?php echo esc_html($profile['github']); ?></p>
                        <p><a href="<?php echo esc_url(home_url('/people/' . sanitize_title($profile['slug']) . '/')); ?>">View Profile</a></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No profiles found.</p>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
});
