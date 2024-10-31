<?php
/**
 *
 * @link              https://sprucetech.com
 * @since             1.0.0
 * @package           No_Translation_Block
 *
 * @wordpress-plugin
 * Plugin Name:       No-Translation Block
 * Plugin URI:        https://sprucetech.com
 * Description:       Adds a paragraph block to Gutenberg called No Translation that used together with a Translation plugin will allow for blocks of text from being removed from Automatic translations
 * Version:           1.0.0
 * Author:            Joanner Pena
 * Author URI:        https://sprucetech.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       no-translation-block
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * No Translation Block
 *
 * This class handles the registration of a Gutenberg block that allows for content
 * to be marked as 'no translation', working alongside translation plugins to exclude
 * specific blocks of text from automatic translations.
 *
 * @since 1.0.0
 * @package No_Translation_Block
 */
class No_Translation_Block
{

    /**
     * Constructor for the No_Translation_Block class.
     *
     * Sets up the necessary actions and filters to register the Gutenberg block
     * and its assets for both the editor and the front end.
     */
    public function __construct()
    {
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_editor_assets'));
        add_action('init', array($this, 'register_block'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_front_end_styles'));
    }

    /**
     * Enqueues editor-specific assets.
     *
     * This function is responsible for enqueuing the block's assets used within the Gutenberg editor,
     * including JavaScript and CSS files. It hooks into the 'enqueue_block_editor_assets' action.
     */
    public function enqueue_editor_assets()
    {
        wp_enqueue_script(
            'no-translation-gutenberg-editor',
            plugins_url('block/editor-script.js', __FILE__),
            array('wp-blocks', 'wp-editor', 'wp-components', 'wp-i18n'),
            filemtime(plugin_dir_path(__FILE__) . 'block/editor-script.js'),
            false
        );

        wp_enqueue_style(
            'no-translation-gutenberg-editor-styles',
            plugins_url('block/style.css', __FILE__),
            array(),
            filemtime(plugin_dir_path(__FILE__) . 'block/style.css')
        );
    }

    /**
     * Enqueues front-end specific styles.
     *
     * This function is responsible for enqueuing the CSS styles used on the front end of the site.
     * It hooks into the 'wp_enqueue_scripts' action to ensure styles are loaded at the correct time.
     */
    public function enqueue_front_end_styles()
    {
        wp_enqueue_style(
            'no-translation-gutenberg-front-end-styles',
            plugins_url('block/public/css/front-end-style.css', __FILE__),
            array(),
            filemtime(plugin_dir_path(__FILE__) . 'block/public/css/front-end-style.css')
        );
    }

    /**
     * Registers the Gutenberg block.
     *
     * This function registers the custom Gutenberg block with WordPress, making it available
     * in the Gutenberg editor. It uses the 'register_block_type' function provided by WordPress
     * to register the block type and its associated assets.
     */
    public function register_block()
    {
        register_block_type(
            'no-translation-gutenberg/paragraph',
            array(
                'editor_script' => 'no-translation-gutenberg-editor',
                'render_callback' => array($this, 'render_block'),
            )
        );
    }
}

new No_Translation_Block();
