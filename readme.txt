=== Seriously Simple Speakers ===
Contributors: PodcastMotor, psykro, hlashbrooke, zahardoc
Tags: seriously simple podcasting, speakers, guests, hosts, podcast, podcasting, ssp, free, add-ons, extensions, addons
Requires at least: 4.4
Tested up to: 6.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add speakers to your Seriously Simple Podcasting episodes.

== Description ==

> This plugin is an add-on for [Seriously Simple Podcasting](https://www.seriouslysimplepodcasting.com/) and requires at least **v1.14** of Seriously Simple Podcasting in order to work.

Does your podcast have a number of different speakers? Or maybe a different guest each week? Perhaps you have unique hosts for each episode? If any of those options describe your podcast then this is the add-on for you!

Seriously Simple Speakers allows you to add one or more speakers to each of your episodes - the speakers are setup as a new taxonomy (not users), making them easily searchable as well as giving them their own archive pages out of the box.

**Primary Features**

- Allows you to add any number of speakers to your podcast episodes
- Adds a new `speaker` taxonomy to all podcast post types
- Displays speakers in the episode details with links to speaker archives
- Add speakers *without* adding a new user for each speaker

**How to contribute**

If you want to contribute to Seriously Simple Speakers, you can [fork the GitHub repository](https://github.com/hlashbrooke/Seriously-Simple-Speakers) - all pull requests will be reviewed and merged if they fit into the goals for the plugin.

== Installation ==

Installing "Seriously Simple Speakers" can be done either by searching for "Seriously Simple Speakers" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org
1. Upload the ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. The Speakers taxonomy page in the admin menu
2. Speakers are managed just like any other taxonomy
3. Speakers are added to episodes in the same way as any other taxonomy
4. Speakers are displayed in the episode details area by default (see the FAQs for how to disable this display)

== Frequently Asked Questions ==

= What version of Seriously Simple Podcasting does this plugin require? =

In order to use this plugin you need to have at least v1.14 of [Seriously Simple Podcasting](https://www.seriouslysimplepodcasting.com/). If you do not have Seriously Simple Podcasting active or you are using a version older than v1.14 then this plugin will do nothing.

= How can I retrieve a list of all the speakers for an episode? =

If you want to get a list of speakers for an episode to use in your templates then this function will return an array of the episode speakers, along with their ID, display name and archive URL: `SSP_Speakers()->get_speakers( $episode_id );`. If you do not specify the `$episode_id` then the ID of the current post will be used.

= I want my 'speakers' to have a different label (e.g. 'guests') on my site - how do I do that? =

This plugin has filters that allow you do this easily by adding the following snippet to your themes functions.php file (or a functionality plugin): https://gist.github.com/hlashbrooke/5fec98f84426534f02a7dc656f8f1d5e. In this example I have renamed the 'Speakers' to 'Guests' in both the plural and singular instances - you can make those labels anything you want by editing the labels in the code.

= How do I hide the speakers list from the episode details? =

If you would like to add speakers to your episodes, but not have them displayed in the standard episode details location then simply add this code to your theme's functions.php file (or a functionality plugin): `add_filter( 'ssp_speakers_display', '__return_false' );`

== Changelog ==

= 1.1.0 =
* 2023-04-27
* [UPDATE] Possibility to change the speakers taxonomy slug
* [UPDATE] Updated supported WordPress version
* [UPDATE] Code refactoring
* [FIX] Compatibility with SSP downloaded from the repository
* [FIX] Fixed too early taxonomy registration


= 1.0.2 =
* 2019-06-13
* [FIX] Fixes a bug related to the Seriously Simple Podcasting 1.20.2 release

= 1.0.1 =
* 2018-12-07
* Changed plugin owner to Castos
* [NEW] Make speaker taxonomy compatible with WP REST API/Gutenberg (props [fienen](https://github.com/fienen))

= 1.0 =
* 2016-06-28
* Initial release

== Upgrade Notice ==

= 1.0 =
* 2016-06-28
* Initial release
