=== WordPress Instant Articles ===
Tags: dns-prefetch, prerender, prefetch, seo, speed, optimization, performance, optimize
Requires at least: 4.0
Tested up to: 4.2.2
Stable tag: 1.2
License: GPL2
Contributors: khromov, titanas

WordPress Instant Articles dramatically improves user experience and site speed. Posts load instantly with page pre-render, DNS prefetch and HTML5 subresources.

== Description ==

Instant Articles for WordPress will let you configure DNS prefetching URLs and will automatically prerender the last 2 posts on the front page, plus next and previous posts when viewing a single post.

It is not recommended to use more than 4-5 URLs for DNS prefetching.

Enabling page prerendering will likely increase server and client (browsers) load.

Enabling subresources will let you specify URL:s to prepare the web browser for fetching these even before they appear in the HTML document.

Visit the Instant Articles homepage for more info: http://wpinstant.io/

**Usage**

*Basic usage*

Install plugin, go to the WP Admin > Instant Articles screen and enable the features you want.

== Requirements ==

* PHP version 5.2.4 or greater

== Translations ==
* None

== Installation ==

1. Upload the the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure it via the new admin menu

== Frequently Asked Questions ==

= What is HTML5 DNS prefetch? =

DNS prefetching is an attempt to resolve domain names before a user tries to follow a link, improving perceived page load time and user experience.

Learn more about DNS prefetching here:
https://www.chromium.org/developers/design-documents/dns-prefetching

= What is prerendering? =

Learn more about page prerendering here:
https://www.chromium.org/developers/design-documents/prerender

== Screenshots ==

1. Administration screen

== Changelog ==

= 1.3 =
* Supercharge your site by specifying which subresources to load. More info: https://www.chromium.org/spdy/link-headers-and-server-hint/link-rel-subresource

= 1.2 =
* Sticky post preloading
* General cleanup in preparation for the next major version!

= 1.1 =
* Fixed dashboard icon being too big: https://wordpress.org/support/topic/dashboard-logo-icon-issue

= 1.0 =
* Initial release