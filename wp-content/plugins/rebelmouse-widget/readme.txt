=== RebelMouse: Your Social Front Page ===
Contributors: Francisco Lavin
Tags:Facebook, Twitter, Social Networks, Social, RebelMouse, embed, sidebar, shortcode, pinterest, instagram.
Requires at least: 3.0
Tested up to: 4.0
Stable tag: trunk
License: GPLv2

Make your front page more social by adding RebelMouse

== Description ==

Add your [RebelMouse](http://www.rebelmouse.com/) to your blog! RebelMouse is your social front page; connect all of your social networks(twitter, facebook, instagram, pinterest, etc..) or hashtags to create a beautiful, dynamic site in seconds. RebelMouse shows the world what you care about and automatically updates as you share. You'll need to sign up (free) at [RebelMouse.com](http://www.rebelmouse.com/) to use the plugin. 

This plugin makes it super simple to have the front page of your WordPress site powered by RebelMouse, or to include your RebelMouse front page as a widget on your WordPress side bar. For why and how to do this, you can also check out our [blogger guide](https://www.rebelmouse.com/rebelmouse/Bloggers/). You can optionally upgrade at any time to remove certain RebelMouse modules and for advanced options.

Adding RebelMouse to your blog is quick and easy (you can find information about how to do so in the Installation section). You can email us with any questions or feedback at wordpress{at}rebelmouse.com.

== Installation ==

= With Widget =
This Wordpress widget is easy to install:

1. Extract the contents of the zip file into your wp-content/plugins directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the Appearance -> widget screen, drag the widget to a sidebar, and fill out the necessary fields and options.

Alternatively, if you did step 1 and 2 you can insert a version without a widget too (see below):

= With shortcode =

Use [shortcodes](http://support.wordpress.com/shortcodes/) to embed your rebelmouse stream in any post or page. 

Usage:

`[rebelmouse sitename="rebelmouse"]`

`[rebelmouse sitename="rebelmouse" h="1500" ]`

`[rebelmouse sitename="rebelmouse" more_button=1 ]`

`[rebelmouse sitename="mysitename/subpage" h="1500" ]`

Arguments provides by the shortcode:

* 'site_name' Your rebelmouse site name, also could include one particular subpage, ie. 'mysitename/myawesometab'
* 'height' height of the iframe, empty by default set auto-adjusting.
* 'show_rebelnav' 1 to display subpages, 0 to hide.
* 'more_button' 1 to display a bottom button to load more posts, 0 will load automatically new posts, (default 0).

= With custom code =

Usage:
`<?php rebelmouse_embed( $args ); ?>`

Params:
$args could be:

* 'site_name' Your rebelmouse site name, also could include one particular subpage, ie. 'mysitename/myawesometab'
* 'height' height of the iframe, empty by default set auto-adjusting.
* 'show_rebelnav' 1 to display subpages, 0 to hide.
* 'more_button' 1 to display a bottom button to load more posts, 0 will load automatically new posts, (0 is default value).

Example:
`<?php rebelmouse_embed( 'site_name=rebelmouse&show_rebelnav=1' ); ?>`
`<?php rebelmouse_embed( 'site_name=rebelmouse/blog&height=3000' ); ?>`

== Frequently Asked Questions == 
 
= What is RebelMouse? =

[RebelMouse](http://www.rebelmouse.com/) is your social front page. Connect all of your social networks to create a beautiful, dynamic site in seconds. RebelMouse shows the world what you care about and automatically updates as you share. [Learn more](http://www.rebelmouse.com/rebelmouse/what_is_rebelmouse_what_is_our-12063327.html)

= How do I start using RebelMouse? =

Just sign up at [RebelMouse.com](http://www.rebelmouse.com/). This widget will then allow you to embed that site into your WordPress blog. 

= What else can I do with my RebelMouse? =

On RebelMouse.com, you can move stories around, edit their content and media, and choose where your stories come from. [Learn more](http://www.rebelmouse.com/rebelmouse/what_now_how_to_use_your_rebel-965889.html).

= Help, I'm having a problem! =

Email us at wordpress{at}rebelmouse.com and we'll be happy to help!

== Screenshots ==

1. Options page
2. Example
3. Rebelmouse setting page. here you can set quickly rebelmouse as your homepage.

== Changelog ==

= 1.5.9.1 =
* minor update, removed RebelMouse modules(features users, and join us promo) for embed.

= 1.5.9 =
* add icons, and tested under WP 4.0

= 1.5.8 =
* clean some notice logs.

= 1.5.7 =
* added the option more_button for shortcodes.

= 1.5.6 =
* tested under WP3.9

= 1.5.6.3 =
* minor update, cleaning some notice logs.

= 1.5.6.2 =
* fix for conflict with other ajax request (thx dimonx3)

= 1.5.6.1 =
* fix question for premium sites.

= 1.5.6 =
* updated for 3.8

= 1.5.5.2 =
* tested up to 3.7.1

= 1.5.5 =
* cleaning some logs, other fixes.

= 1.5.4 =
* support for multiple embeds

= 1.5.2 =
* minor fix
* added embed type sidebar

= 1.4 =

* add support for Rebel Nav(subpages)

= 1.3 =

* little fixes in shortcode

= 1.2 =
* support thre new rebelmouse embed.

= 1.1.7.3 =
* height by default auto-adjusting

= 1.1.7.2 =
* columns auto-adjusting

= 1.1.7.1 =
* set width as 100%, to support new embed from rebelmouse.

= 1.1.7 =
* add shortcuts to set rebelmouse as Homepage or add new page full width.

= 1.1.6.2 =
* little fix of css

= 1.1.6 =
* add scroll option

= 1.1.5 =
* add shortcode [rebelmouse]
* add FAQ secction

= 1.1 =
*initial version

== Upgrade Notice ==

== Arbitrary section ==
