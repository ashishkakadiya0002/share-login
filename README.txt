=== Share Login ===
Contributors: ashishkakadiya
Donate link: https://sharelogin.com/
Tags: shared login, auto login, multi-site login, cross-domain login
Requires at least: 5.0
Tested up to: 6.7.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically synchronize user logins between two WordPress websites - when users log into the main site, they'll be automatically logged into the sync site.

== Description ==

Share Login enables automatic login synchronization between two WordPress websites. When configured, this plugin allows users who log into your main website to be automatically logged into the secondary (sync) website without requiring a separate login.

**Key Features:**

* Configure one WordPress site as the main site and another as the sync site
* Automatic login on the sync site when users log into the main site
* Secure authentication token handling
* Easy to set up and configure
* Works across different domains

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

== Screenshots ==

1. Main site configuration screen
2. Sync site configuration screen
3. Successful login synchronization

== Changelog ==

= 1.0.0 =
* Initial release
* Main and sync site configuration
* Automatic login synchronization
* Security token handling

== Upgrade Notice ==

= 1.0.0 =
Initial release of Share Login plugin.

== Configuration ==

**Main Site Setup:**
1. Enter the sync site URL
2. Generate and save the authentication key

**Sync Site Setup:**
1. Enter the main site URL
2. Enter the authentication key from the main site
