=== Tasty Pins ===
Contributors: danielbachhuber
Tags: pinterest, seo
Requires at least: 4.4
Tested up to: 5.3
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Tasty Pins allows you to optimize your blog’s images for Pinterest, SEO, and screenreaders.

== Description ==

Tasty Pins allows you to optimize your blog’s images for Pinterest, SEO, and screenreaders.

== Installation ==

The Tasty Pins plugin can be installed much like any other WordPress plugin.

1. Upload the plugin ZIP archive file via "Plugins" -> "Add New" in the WordPress admin, or extract the files and upload them via FTP.
2. Activate the Tasty Pins plugin through the "Plugins" list in the WordPress admin.

With Tasty Pins, there aren't any confusing settings to configure or customizations you need to worry about. You can now edit images to your heart's content!

== Changelog ==

= 1.0.2 (January 9th, 2019) =
* Fixes duplicate upload issue with the Image Block.

= 1.0.1 (December 18th, 2019) =
* Compatibility tweak for WooCommerce.

= 1.0.0 (December 13th, 2019) =
* Adds support for editing the Pinterest Title for an image.
* Updates the EDD Updater to v1.6.19.

= 0.9.2 (November 25th, 2019) =
* Fixes WordPress 5.3 compatibility issue where Pinterest Text wouldn't persist when image is inserted from Media Library.

= 0.9.1 (November 14th, 2019) =
* Adds WordPress 5.3 compatibility in a couple more places.

= 0.9.0 (November 14th, 2019) =
* Compatibility with WordPress 5.3.
* Allows Pinterest detail editing in the block editor when image is inserted from URL.

= 0.8.1 (May 13th, 2019) =
* Adds a welcome page that appears after plugin activation.
* Fixes missing space in `<img>` markup for hidden images when Pinterest text isn't set.
* Fixes issue where `data-pin-url` was added even when the post type isn't publicly queryable.
* Fixes WP 5.2 issue with editing Pinterest details on an inline image.

= 0.8.0 (April 18th, 2019) =
* Adds Pinterest default text feature, to set default Pinterest text on all images that don't have one.
* Adds a batch converter for Social Warfare Pinterest images and default text.
* Appends PHP and plugin version to EDD update requests, for internal reporting.

= 0.7.1 (January 30th, 2019) =
* Fixes JavaScript `media undefined` error in specific scenarios.
* Ensures JavaScript strings are included in the `tasty-pins.pot` localization file.

= 0.7.0 (November 27th, 2018) =
* Full integration with Gutenberg Image Block.
* Moves hidden images back to the top of post content.
* Fixes hidden images to only append Pinterest attributes when they're set.

= 0.6.0 (August 23rd, 2018) =
* Introduces `tasty_pins_hidden_image_thumbnail_size` filter for modifying the hidden image thumbnail size.
* Adds `tasty-pins-hidden-image-container` class on hidden images wrapper, and `tasty-pins-hidden-image` class on hidden image HTML.

= 0.5.0 (July 10th, 2018) =
* Introduces option to force pinning of the first hidden image for all images in a post.
* Fixes issue where Pinterest Hidden Image would have a JavaScript error when no `thumbnail` image size existed.

= 0.4.0 (March 28th, 2018) =
* Introduces support for selecting multiple hidden images.
* Fixes issue where apostrophes in Pinterest Text were accidentally backslashed.

= 0.3.0 (February 7th, 2018) =
* Always loads `pinit.js` in the site header.
* Whitelists `data-pin-description` and `data-pin-nopin` attributes to prevent stripping when `wp_kses()` is used to sanitize input.
* Disables hidden Pinterest images for post types that don't have an editor, because the image is injected in the post content.
* Updates EDD Upgrader to `1.6.15` from `1.6.12`.

= 0.2.1 (January 15th, 2018) =
* Fixes JavaScript error that appeared anywhere `wp.media` was undefined.

= 0.2.0 (January 8th, 2018) =
* Permits users to 'Disable Pinning' when inserting an image into post.
* Renders full hidden image in `data-pin-media` attribute for better performance.
* Introduces `tasty_pins_hidden_image_html` filter for modifying hidden image HTML.
* Addresses PHP error associated with `filter_wp_prepare_attachment_for_js()` method definition.

= 0.1.0 (November 27th, 2017) =
* Initial release.
