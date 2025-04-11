# Phantom People Directory

This plugin generates phantom people profile pages using a CSV and enriches each with GitHub API data.

## Features
- CSV-powered virtual pages at `/people/{slug}/`
- GitHub API integration (bio, repos, followers)
- Custom sitemap at `/people-sitemap.xml`
- Pages are indexable and 404 properly
- **Display a list of people using `[people_directory]` shortcode**

## How it works
- Rewrites and query vars handle routing
- Pages are rendered dynamically via `template_redirect`
- GitHub data is cached using `set_transient`

## Setup
1. Place `profiles.csv` in the plugin root.
2. Activate the plugin.
3. Visit `/people/{slug}` to test.
4. Sitemap available at `/people-sitemap.xml`
5. Use the `[people_directory]` shortcode on any page/post to show the list of profiles.
