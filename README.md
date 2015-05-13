Hide Referrer
====================

Plugin for [YOURLS](http://yourls.org). 

Description
-----------
This plugin lets you hide (all but the last) referrer (HTTP referer header) when redirecting. This can be useful for security and integrity reasons, for example to avoid sending sensitive querystrings to an external site. Note that on some browsers when using https, the *last* referrer  will always be sent, which will be the YOURLS short url. Using HTTPS on all redirects ensures a  hidden referrer on all browsers tested.

The plugin works either by adding a prefix to existing short urls, or on ALL redirects (default).

What will be hidden
-------------------

Browser | Hides referrer
--- | --- 
Chrome | All
Firefox http | All but last
Firefox https | All
IE http | All but last
IE https | All

(As of May 2015)

Installation
------------
1. In `/user/plugins`, create a new folder named hide-referrer.
2. Drop these files in that directory.
3. Customize the plugin by editing the two variables at the top of `plugin.php` as needed.
4. Go to the Plugins administration page ( *eg* `http://sho.rt/admin/plugins.php` ) and activate the plugin.
5. Have fun!

Disclaimer
----------
The referrer header is controlled by the web browser, so methods used in here can stop working at any time.

License
-------
Do whatever the hell you want with it.

Support
-------
If you find a problem, add an issue on GitHub, or better, submit a pull request.
