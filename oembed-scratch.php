<?php
/*
Plugin Name: Enable Scratch oEmbed
Description: Register an embed handler for Scratch project links.
		It converts a URL like https://scratch.mit.edu/projects/3231341/ into an embedded scratch project (an iframe).
		Read more about Scratch here: https://scratch.mit.edu/about/
Author: windyjonas
Author URI: http://jonasnordstrom.se
Version: 1.0
License: GPL2
Text Domain: Text Domain
Domain Path: Domain Path
*/

/*
	Copyright (C) 2015  @windyjonas  jonas.nordstrom@gmail.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * The plugin class the creates oEmbed code for scratch URLs
 */
class Oembed_Scratch {

	/**
	 * Init the class, create an instance
	 */
	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	/**
	 * Constuctor
	 */
	public function __construct() {
		$this->register_hooks();
	}

	/**
	 * Register filters and actions
	 */
	public function register_hooks() {
		wp_embed_register_handler( 'scratch', '#https://scratch.mit.edu/projects/([\d]+)/?#i', array( $this, 'wp_embed_handler_scratch' ) );
	}

	/**
	 * The actualhandler that converts i URL to an iframe-embed
	 * @param  [type] $matches [description]
	 * @param  [type] $attr    [description]
	 * @param  [type] $url     [description]
	 * @param  [type] $rawattr [description]
	 * @return [type]          [description]
	 */
	public function wp_embed_handler_scratch( $matches, $attr, $url, $rawattr ) {
		$embed = sprintf(
			'<iframe allowtransparency="true" width="485" height="402" src="//scratch.mit.edu/projects/embed/%1$s/?autostart=false" frameborder="0" allowfullscreen></iframe>',
			esc_attr( $matches[1] )
		);

		return apply_filters( 'embed_scratch', $embed, $matches, $attr, $url, $rawattr );
	}

}
add_action( 'plugins_loaded', array( 'Oembed_Scratch', 'init' ) );
