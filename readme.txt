=== Wp Wiki Userprofile ===
Contributors: gchokeen
Donate link: http://code-cocktail.in/donate-me/
Tags: widget, wiki
Requires at least: 2.8
Tested up to: 3.4.1
Stable tag: 1.1
License: GPLv2


This plugin is used to grab Wikipedia user contribution to wordpress blog.

== Description ==

This plugin is used to grab Wikipedia user contribution to wordpress blog. This plugin is intracted with Media Wiki API
using CURL request. 

= Plugin Features =

* Widget Support
* Shortcode support

= Shortcode Usage =
*`[wikiuser]`

*`[wikiuser  param="editcount"]`

*`[wikiuser username="xxx" param="editcount"]`



== Installation ==

This plugin Making request to Media Wiki API using CUL. So we must enable CURL in our server first.

e.g.

1. Upload the entire `wp-wiki-userprofile` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress




== Frequently Asked Questions ==

= How to enable CURL =

checkout this [link](http://stackoverflow.com/questions/1347146/how-to-enable-curl-in-php). I belive this will answer your question.
 

= Can i get multiple user information ? =

Yes, We can do this. add | seperated username in the plugin settings page.e.g user1|user2  

== Screenshots ==

1. screenshot-1.png 

== Changelog ==

= 1.1 =
* Shortcode support added.
* Feedback links is are added.
  

= 1.0 =
* Initial release.

== Upgrade Notice ==

The current version of plugin requires WordPress 2.8 or higher. If you use older version of WordPress, you need to upgrade WordPress first.
