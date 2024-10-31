<?php
/*
Plugin Name: OSS Cards
Plugin URI:  http://vivapro.net
Description: Using this Plugin you can present your products, services or content in beautiful style. Crate cards within a few minutes. Just fill the form and click - Add. All you do displays immediately in the preview without saving and reloading. You can use images or icons, change colors, and add animation
Version:     1.1.1
Author:      VIVA PRO
Author URI:  http://vivapro.net/about/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
define('OSSC_ASSETS', plugin_dir_url(__FILE__) . 'assets/');

class Oss_Cards
{

    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'osscards_load_textdomain')); //add plugin textdomain
        add_action('init', array($this, 'register_cards_content_type')); //register cards content type
        add_action('add_meta_boxes', array($this, 'add_card_meta_boxes')); //add meta boxes
        add_action('save_post_oss_cards', array($this, 'save_cards')); //save cards
        add_action('init', array($this, 'register_cards_shortcodes')); //shortcodes
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts_and_styles')); //admin scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts_and_styles')); //public scripts and styles
        add_action('admin_menu', array($this, 'add_submenu'));//add setting page
        add_filter('the_content', array($this, 'prepend_cards_meta')); //gets our meta data and dispayed it before the content
        add_filter('script_loader_tag', array($this, 'add_type_attribute'), 10, 3);
        register_activation_hook(__FILE__, array($this, 'plugin_activate')); //activate hook
        register_deactivation_hook(__FILE__, array($this, 'plugin_deactivate')); //deactivate hook
    }

    // Add plugin textdomain
    public function osscards_load_textdomain()
    {
        load_plugin_textdomain('oss-cards', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    //add setting page
    public function add_submenu()
    {

        add_submenu_page(
            'edit.php?post_type=oss_cards',
            'Settings', // Page title
            'Settings', // Menu title
            'manage_options', // Capability required to access the page
            'oss-cards-settings', // Page slug
            array($this, 'oss_cards_settings_page') // Callback public function to render the page
        );

        //call register settings function
        add_action('admin_init', array($this, 'register_ossettings'));
    }

    //display seeting page

    public function oss_cards_settings_page()
    {
        ?>
        <div class="wrap">
            <h2>Cards Settings</h2>
            <form method="post" action="options.php">
                <?php settings_fields('oss-slideshow-opt-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Description Lenght', 'oss-cards') ?><span
                                    class="dashicons dashicons-editor-help os_help_lenght"></th>
                        <td><input type="number" name="length" min="5" max="55" step="1"
                                   value="<?php echo get_option('length'); ?>"/></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Read More Text', 'oss-cards') ?><span
                                    class="dashicons dashicons-editor-help os_help_readmore"></th>
                        <td><input type="text" name="read_more" value="<?php echo get_option('read_more'); ?>"
                                   placeholder="Default is Read More"/></td>
                    </tr>
                    <!--
                TODO IN VER 1.1.1
                <tr valign="top">
                <th scope="row"><?php esc_html_e('Admin Layout', 'oss-cards') ?> <span class="dashicons dashicons-editor-help os_help"></th>
                <td>
                    <select name="admin_style">
                        <option value="oss_classic"<?php if (get_option('admin_style') === 'oss_classic') echo ' selected'; ?>>Classic</option>
                        <option value="vv_admin_style"<?php if (get_option('admin_style') === 'vv_admin_style') echo ' selected'; ?>>VIVA Layout(BETA)</option>
                    </select> 
                </td>
                </tr> -->
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
                </p>
            </form>
            <!-- help modals -->
            <div class="os_modal_lenght"
                 style="width: 460px; padding: 20px; position: fixed; top: 100px; left: 50%; margin-left: -170px; background: #404550; color:#fff; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;display:none">
                <span class="dashicons dashicons-no" style="float: right; margin: -10px -10px 0 0;"></span>
                <p><?php esc_html_e('Description Length(words) by default, maximum 55. This refers only to fetched text from content items. Length of custom cards as you wish. Also you can add or shorten fetched text for a senseful description. Default is 20', 'oss-cards') ?></p>
            </div>
            <div class="os_modal_readmore"
                 style="width: 460px; padding: 20px; position: fixed; top: 100px; left: 50%; margin-left: -170px; background: #404550; color:#fff; -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;display:none">
                <span class="dashicons dashicons-no" style="float: right; margin: -10px -10px 0 0;"></span>
                <p><?php esc_html_e('Default text is "Read More", you can change it as you wish or write your own if your site language is not English', 'oss-cards') ?></p>
                <p><?php esc_html_e('Note: Also you can change it for every card when add or edit ', 'oss-cards') ?></p>
            </div>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                console.log(".os_modal  2 ");
                $('.os_help_readmore').click(function (event) {
                    $('.os_modal_readmore').fadeToggle(300);
                });
                $('.os_help_lenght').click(function (event) {
                    $('.os_modal_lenght').fadeToggle(300);
                });
                $('.os_modal_readmore, .os_modal_lenght').click(function (event) {
                    console.log(".os_modal click");
                    $(this).fadeOut(300);
                });
            });
        </script>
        <?php
    }


    //register our settings
    public function register_ossettings()
    {
        register_setting('oss-slideshow-opt-group', 'length', array($this, 'sanitize_callback'));
        register_setting('oss-slideshow-opt-group', 'read_more', array($this, 'sanitize_callback'));
        // register_setting( 'oss-slideshow-opt-group', 'admin_style', array($this, 'sanitize_callback'));//todo
    }

    //get plugin settings -default data
    public function get_settings()
    {
        $length = 20;
        $read_more = 'Read More';
        if (get_option('length')) {
            $length = get_option('length');
        }
        if (get_option('read_more')) {
            $read_more = get_option('read_more');
        }
        return array(
            'length' => $length,
            'read_more' => $read_more,
            // 'admin_style' => get_option('admin_style'),//todo
        );
    }

    // sanitize data
    public function sanitize_callback($options)
    {
        $options = sanitize_text_field($options);
        return $options;
    }

    //register the cards content type
    public function register_cards_content_type()
    {
        //Labels for post type
        $labels = array(
            'name' => 'OSS Cards',
            'singular_name' => 'OSS Card',
            'menu_name' => 'OSS Cards',
            'name_admin_bar' => 'OSS Card',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Card',
            'new_item' => 'New Card',
            'edit_item' => 'Edit Card',
            'view_item' => 'View Card',
            'all_items' => 'All Cards',
            'search_items' => 'Search Cards',
            'parent_item_colon' => 'Parent Card:',
            'not_found' => 'No Cards found.',
            'not_found_in_trash' => 'No Cards found in Trash.',
        );
        //arguments for post type
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav' => true,
            'query_var' => true,
            'hierarchical' => false,
            'supports' => array('title'),//editor disable by css as not used for now, but Gutenberg layout doesnt work without it
            'has_archive' => true,
            'menu_position' => 20,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,//set true if need to add to menu as page
            'menu_icon' => 'dashicons-images-alt2',
            'rewrite' => array('slug' => 'cards', 'with_front' => 'true'),
            'capability_type' => 'post',
            'show_in_rest' => false,    // for Gutenberg
        );
        //register post type
        register_post_type('oss_cards', $args);
    }

    //adding meta boxes for the cards content type*/
    public function add_card_meta_boxes()
    {
        add_meta_box(
            'oss_cards_meta_box', //id
            'Edit Cards & Preview', //name
            array($this, 'display_card_metabox'), //display function
            'oss_cards', //post type
            'normal', //location
            'default' //priority
        );
    }

    //display function used for our cards meta box*/
    public function display_card_metabox($post)
    {
        //set nonce field
        wp_nonce_field('oss_cards_nonce', 'oss_cards_nonce_field');
        //collect variables
        $oss_cards_data = get_post_meta($post->ID, 'oss_cards_data', true);
        ?>
        <div class="field-container">
        <?php
        //before main form elementst hook
        do_action('oss_cards_admin_form_start');
        ?>
        <div id="app-cards" class="oss-cards-admin">
            <div id="osti_show_data">
                <span id="close_data" v-on:click="editElMain(9), closeModals()"><i
                            class="fas fa-times-circle"></i></span>
                <div class="oss_copy_data_click">
                    <i class="far fa-copy"></i> <?php esc_html_e('Copy To Clipboard', 'oss-cards') ?>
                    <span class="oss_copyed_alert_data"><?php esc_html_e('Data Is Copied', 'oss-cards') ?></span>
                </div>
                <?php
                /*
                toString() is js object converted to JSON string where there's all card's data and its parameters - no html or js tags(inc/funcs/functions line 93)
                 */
                ?>
                <textarea id="oss_cards_data" name="oss_cards_data" cols="100" rows="10">{{toString()}}</textarea>
            </div>
            <?php
            include 'inc/preview-cards.php';
            include 'inc/sidebar.php';
            echo '</div>'; //end app
            //after main form elementst hook
            do_action('oss_cards_admin_form_end');
            ?>
        </div>
        <?php
    }

    //triggered on activation of the plugin (called only once)
    public function plugin_activate()
    {
        //call our custom content type function
        $this->register_cards_content_type();
        //flush permalinks //
        flush_rewrite_rules();
    }

    //trigered on deactivation of the plugin (called only once)
    public function plugin_deactivate()
    {
        //flush permalinks
        flush_rewrite_rules();
    }

    //show cards(meta data) just for WP preview
    public function prepend_cards_meta($content)
    {
        global $post, $post_type;
        //display meta only on our cardss (and if its a single cards)
        if ($post_type == 'oss_cards') {
            //collect variables
            $oss_cards_data = get_post_meta($post->ID, 'oss_cards_data', true);
            //display
            if (!empty($oss_cards_data)) {
                ob_start();
                $data = json_decode($oss_cards_data, true);
                include 'inc/render-cards.php';
                $cards = ob_get_clean();
                return $cards . $content;
            }
        } else {
            return $content;
        }
    }

    //shortcode
    public function register_cards_shortcodes()
    {
        add_shortcode('oss_cards', array($this, 'display_cards_shortcode'));
    }

    //shortcode display
    public function display_cards_shortcode($atts)
    {
        $arguments = shortcode_atts(
            array(
                'id' => ''
            ),
            $atts
        );
        $html = $this->get_cards_output($arguments);
        return $html;
    }

    //main function for displaying cards
    public function get_cards_output($arguments = "")
    {
        $card_object = '';
        //default args
        $default_args = array(
            'id' => '',
        );
        //update default args if we passed in new args
        if (!empty($arguments)) {
            $cards_id = $arguments['id'];
            $oss_cards_data = get_post_meta($cards_id, 'oss_cards_data', true);
            //display if there's data & status published
            if (!empty($oss_cards_data) && get_post_status($cards_id) === 'publish') {
                ob_start();
                $data = json_decode($oss_cards_data, true);
                include 'inc/render-cards.php';
                $card_object = ob_get_clean();
            }
        }
        return $card_object;
    }

    //triggered when adding or editing a cards
    public function save_cards($post_id)
    {
        //check for nonce
        if (!isset($_POST['oss_cards_nonce_field'])) {
            return $post_id;
        }
        //verify nonce
        if (!wp_verify_nonce($_POST['oss_cards_nonce_field'], 'oss_cards_nonce')) {
            return $post_id;
        }
        //check for autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        /*
        `oss_cards_data is the only data passed to post meta - it's a JSON string of the js object off all cards and its parameters, sanitized before post
         */
        $oss_cards_data = isset($_POST['oss_cards_data']) ? sanitize_textarea_field($_POST['oss_cards_data']) : '';
        //update data
        update_post_meta($post_id, 'oss_cards_data', $oss_cards_data);

        //save hook
        do_action('oss_cards_admin_save', $post_id);
    }

    //add tag module to main js script
    public function add_type_attribute($tag, $handle, $src)
    {
        // if not your script, do nothing and return original $tag
        if ('osscards-app' !== $handle) {
            return $tag;
        }
        // remove the current type if there is one
        $tag = preg_replace('/ type=([\'"])[^\'"]+\1/', '', $tag);

        // add type
        $tag = str_replace('src=', 'type="module" src=', $tag);

        return $tag;
    }

    //enqueus scripts and stles on the back end
    public function enqueue_admin_scripts_and_styles()
    {
        wp_enqueue_script('omi-admin', plugin_dir_url(__FILE__) . 'assets/js/admin.js', array('jquery'), '1.0');

        //calls if post type is oss_cards only and edit or new page
        if (get_current_screen()->base == 'post' && get_post_type() === 'oss_cards') {
            wp_enqueue_style('icons-fa', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', array(), '202302');
            wp_enqueue_style('omi-admin-style', plugin_dir_url(__FILE__) . 'assets/css/admin.css', array(), '202302');
            wp_enqueue_style('omi-frontend-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
            wp_enqueue_style('uikit-css', plugin_dir_url(__FILE__) . 'assets/css/uikit.min.css', array(), '202302');
            wp_enqueue_media();//requires for images
            wp_enqueue_script('uikit-js', plugin_dir_url(__FILE__) . 'assets/js/uikit.min.js', array(), '3.0');
            wp_enqueue_script('omi-vue', plugin_dir_url(__FILE__) . 'assets/js/vue.js', array(), '2.0');
            wp_enqueue_script('omi-vue-color', plugin_dir_url(__FILE__) . 'assets/js/vue-color.min.js', array(), '2.0');
            wp_enqueue_script('omi-color', plugin_dir_url(__FILE__) . 'assets/js/color.js', array(), '2.0');
            wp_enqueue_script('omi-axios', plugin_dir_url(__FILE__) . 'assets/js/axios.min.js', array(), '2.0');
            //main script as type module & localize_script
            wp_enqueue_script('osscards-app', plugin_dir_url(__FILE__) . 'assets/js/app.js', array(), null, true);
            global $post, $post_type;
            $oss_cards_data = get_post_meta($post->ID, 'oss_cards_data', true);
            if ($oss_cards_data) {
                wp_add_inline_script('osscards-app', 'const OSDATA = ' . wp_json_encode($oss_cards_data), 'before');
            }
            wp_add_inline_script('osscards-app', 'const OSDEFAULT = ' . wp_json_encode($this->get_settings()), 'before');
        }
    }

    //enqueues scripts and styled on the front end
    public function enqueue_public_scripts_and_styles()
    {
        wp_enqueue_style('icons-fa', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', array(), '202302');
        wp_enqueue_style('uikit-css', plugin_dir_url(__FILE__) . 'assets/css/uikit.min.css', array(), '202302');
        wp_enqueue_style('omm-public-styles', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '202302');
        wp_enqueue_script('osc-uikit-js', plugin_dir_url(__FILE__) . 'assets/js/uikit.min.js', array(), '2.0');
        wp_enqueue_script('omm-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '202302', true);
    }
}

$oss_cards = new Oss_Cards;
//include widget
include(plugin_dir_path(__FILE__) . 'inc/oss_cards_widget.php');
?>