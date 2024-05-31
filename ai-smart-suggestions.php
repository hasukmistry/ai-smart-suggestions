<?php
/**
 * Plugin Name: AI Smart Suggestions
 * Plugin URI: https://github.com/hasukmistry/ai-smart-suggestions
 * Description: A plugin to add AI suggestions to your WordPress site content.
 * Version: 1.0
 * Requires at least: 6.2
 * Requires PHP: 8.0
 * Author: Hasmukh K Mistry
 * Author URI: https://hasmukhmistry137.medium.com/
 * License: GPL-2.0+
 * License URI:
 * Update URI:
 * Text Domain: ai-smart-suggestions
 * Domain Path:
 */

declare(strict_types=1);

use AISmartSuggestions\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the plugin path
define( 'AI_SS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Define the plugin url
define( 'AI_SS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! class_exists( Plugin::class ) && is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	/** @noinspection PhpIncludeInspection */
	require_once __DIR__ . '/vendor/autoload.php';
}

class_exists( Plugin::class ) && Plugin::instance()->init();
