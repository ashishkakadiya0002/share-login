=== Share Login ===
Contributors: ashishkakadiya0002
Tags: shared login, single sign-on, multi-site login, cross-domain login, sso
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0   
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically synchronize user logins between WordPress websites, enabling seamless single sign-on functionality.

== Description ==

Share Login enables automatic login synchronization between two WordPress websites. When configured, this plugin allows users who log into your main website to be automatically logged into the secondary (sync) website without requiring a separate login.

**Key Features:**

* Configure one WordPress site as the main site and another as the sync site
* Automatic login on the sync site when users log into the main site
* Secure authentication token handling
* Easy to set up and configure
* Works across different domains
* Compatible with WooCommerce and other popular plugins

**Use Cases:**

* Multiple WordPress websites that share the same user base
* Member sites that require access to multiple platforms
* Educational institutions with multiple web properties
* Business websites with separate customer portals

== Installation ==

1. Upload the `share-login` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Share Login to configure your main and sync sites
4. On the main site, enter the sync site's URL and authentication key
5. On the sync site, enter the main site's URL and the same authentication key
6. Test the configuration by logging into the main site

== Frequently Asked Questions ==

= How does the automatic login work? =

When a user logs into the main site, the plugin generates a secure token that is passed to the sync site. The sync site validates this token and automatically logs in the corresponding user.

= Is this secure? =

Yes, the plugin uses secure authentication tokens and WordPress nonces to ensure the login synchronization process is safe and secure.

= Can I use this with more than two sites? =

Currently, the plugin supports one main site and one sync site configuration. Future versions may include support for multiple sync sites.

= What are the system requirements? =

* WordPress 5.0 or higher
* PHP 7.4 or higher
* HTTPS enabled on both sites (recommended for security)
* Cross-origin resource sharing (CORS) enabled

== Screenshots ==

1. Share Login Setup
2. Main site configuration step 1
3. Main site configuration step 2
4. Main site configuration step 3
5. Main site Dashbord
6. Sync site configuration step 1
7. Sync site configuration step 2
8. Sync site configuration step 3
9. Sync site Dashbord

== Changelog ==

= 1.0.0 =
* Initial release
* Main and sync site configuration
* Automatic login synchronization
* Security token handling

= 1.1.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of Share Login plugin.

= 1.1.0 =
Initial release of Share Login plugin.

== Configuration ==

**Main Site Setup:**
1. Enter the sync site URL
2. Generate and save the authentication key

**Sync Site Setup:**
1. Enter the main site URL
2. Enter the authentication key from the main site

== Third-Party Libraries ==

This plugin includes the following third-party libraries, bundled locally within the plugin:

1. Cross Storage
* Version: 1.0.0
* License: MIT
* Source: https://github.com/zendesk/cross-storage
* Local Path: public/js/cross-storage/

2. Semantic UI
* Version: 2.5.0
* License: MIT
* Source: https://github.com/Semantic-Org/Semantic-UI
* Local Path: admin/semantic/

