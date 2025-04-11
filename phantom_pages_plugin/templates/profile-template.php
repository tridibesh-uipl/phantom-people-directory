<?php
if (!defined('ABSPATH')) exit;
$slug = get_query_var('person_slug');
$profile = PD_CSV_Loader::get_profile_by_slug($slug);
if (!$profile) {
    status_header(404);
    include get_404_template();
    exit;
}
$github_data = PD_GitHub_API::get_user_data($profile['github']);
get_header();
?>
<div class="pd-profile-container" style="max-width:800px; margin:0 auto; padding:20px;">
    <h1><?php echo esc_html($profile['name']); ?></h1>
    <?php if ($github_data): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-top:20px;">
            <?php if (!empty($github_data['avatar_url'])): ?>
                <img src="<?php echo esc_url($github_data['avatar_url']); ?>" style="max-width:150px;">
            <?php endif; ?>
            <p><strong>Bio:</strong> <?php echo esc_html($github_data['bio'] ?? 'N/A'); ?></p>
            <p><strong>Public Repos:</strong> <?php echo esc_html($github_data['public_repos']); ?></p>
            <p><strong>Followers:</strong> <?php echo esc_html($github_data['followers']); ?></p>
            <p><a href="<?php echo esc_url($github_data['html_url']); ?>" target="_blank">View GitHub</a></p>
        </div>
    <?php else: ?>
        <p>GitHub data not available.</p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>