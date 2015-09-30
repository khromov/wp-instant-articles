=== WordPress Instant Articles ===
Tags: dns-prefetch, prerender, prefetch, seo, speed, optimization, performance, optimize, subresource, html5, link prefetch
Requires at least: 4.0
Tested up to: 4.3.1
Stable tag: 1.4
License: GPL2
Contributors: khromov, titanas

WordPress Instant Articles dramatically improves user experience and site speed with page pre-render, DNS prefetch, Link Prefetch, HTML5 subresource

== Description ==

Instant Articles for WordPress will let you configure DNS prefetching URLs and will automatically prerender the last 2 posts on the front page, plus next and previous posts when viewing a single post. You also have the option to pre-render sticky posts.

It is not recommended to use more than 4-5 URLs for DNS prefetching.

Enabling page prerendering will likely increase server and client (browsers) load.

Enabling subresources will let you specify URL's to hint the web browser for high priority files, likes .JS or .CSS, for fetching these even before they appear in the HTML document.

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

= What is page pre-rendering? =

Page pre-render loads and pre-renders all the assets of the page in a hidden tab. When user clicks on the link to open the page the browser just shows the page. No networking waiting. No resource download. 

Learn more about page prerendering here:
https://www.chromium.org/developers/design-documents/prerender

= What is HTML5 subrecource? =

Using rel='subresource' the browser gets hints about high priority files it needs to load as soon as possible. Critial CSS or JavaScript files are a good example. This feature enables early loading of resources within the current page.  Because the resource is intended for use within the current page, it must be loaded at high priority in order to be useful.

Learn more about HTML5 subresource here:
https://www.chromium.org/spdy/link-headers-and-server-hint/link-rel-subresource

= What is Link Prefetch? =

Using rel='prefetch' the broswer gets hints about files that the user might use soon. The browser downloads the files during idle time and stores them in the cache. This feature enables proactive loading of resources the user will need in future pages. CSS or JavaScript files for reviews, gallery and video player plugins are good examples.

== Screenshots ==

1. Administration screen

== Changelog ==

= 1.4 =
* Introduce Link prefetch support
* wpinstant_prerendered_urls filter now includes previously prerendered items instead of adding to that list.
* Add new filter for adding custom URLs to subresources list: wpinstant_subresources
* Add new filter to disable processing of default prerender rules: wpinstant_prerendered_urls_override_defaults

= 1.3.1 =
* Add new filter for adding custom URLs to prerender: wpinstant_prerendered_urls
* Fix typo in wpinstant_subresources filter.

= 1.3 =
* Supercharge your site by specifying which subresources to load. More info: https://www.chromium.org/spdy/link-headers-and-server-hint/link-rel-subresource

= 1.2 =
* Sticky post preloading
* General cleanup in preparation for the next major version!

= 1.1 =
* Fixed dashboard icon being too big: https://wordpress.org/support/topic/dashboard-logo-icon-issue

= 1.0 =
* Initial release
