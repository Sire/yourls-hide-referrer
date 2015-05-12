<?php
/*
Plugin Name: Hide Referrer
Plugin URI: https://github.com/Sire/yourls-hide-referrer
Description: Hides the referrer when redirecting
Version: 1.0
Author: simon@developerdog.com
Author URI: http://developerdog.com
*/

// you have two options, either add a prefix before all short urls. this will keep regular short urls, but hide referral on those prefixed.
// if you want to hide referrals on ALL short urls, set this variable to true
define( 'HIDE_REFERRER_ON_ALL_URLS', true );
define( 'HIDE_REFERRER_URL_PREFIX', '@' );


if ( HIDE_REFERRER_ON_ALL_URLS ) {
	// Pre redirect - hide referrer on ALL urls
	yourls_add_action( 'pre_redirect', 'hide_referer_pre_redirect' );
}
else {
	// Loader failed - hide referrer on urls with prefix
	yourls_add_action( 'loader_failed', 'hide_referer_loader_failed' );
}



function hide_referer_pre_redirect( $args ) {
	$url = $args[0];
	$code = $args[1];
	hide_referer($url);
	// Now die so the normal redirect is interrupted
	die();
}


function hide_referer_loader_failed( $args ) {
	if( preg_match( '!^'. HIDE_REFERRER_URL_PREFIX .'(.*)!', $args[0], $matches ) ) {
		$keyword = yourls_sanitize_keyword( $matches[1] );
		require_once( dirname( __FILE__ ) . '/../../../includes/load-yourls.php' );
		$url = yourls_get_keyword_longurl( $keyword );
		hide_referer($url);
		exit;
	}
	// If prefix is missing, do nothing and return to normal operations
}


//we change the location on the parent document from within an iframe
//this is the only sure way of hiding referer that works with all major browsers as of 2015-05-12.
function hide_referer( $url ) {
	echo "<iframe style=\"display:none\" src=\"javascript:parent.location.replace('".$url."'+(parent.location.hash||''))\">";

	//we don't seem to need urlencoding
	//$url = urlencode($url);
	//echo "<iframe style=\"display:none\" src=\"javascript:parent.location.replace(unescape('".$url."')+(parent.location.hash||''))\">";
	
	//this is a backup method if the iframe trick stops working in a particular browser.
	//we use a meta refresh instead, which will not hide the referer, but only show the LAST redirect url (the yourls url).
	//1 second delay so the iframe gets a chance first.
	echo "<meta http-equiv=\"refresh\" content=\"1; url=".$url."\" />";
}

