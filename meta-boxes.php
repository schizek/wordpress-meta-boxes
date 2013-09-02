<?php
/**
 * Meta Boxes
 *
 * A class to easily add custom meta boxes and fields programmatically
 *
 * @version 0.1
 * @author Fetch Designs
 * @copyright 2013 Fetch Designs <http://www.fetchdesigns.com/>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class FD_Meta_Boxes
{

    /**
     * Meta Box Definition
     *
     * @var array $meta_box
     */
    private $meta_box;

    /**
     * Initialize Class
     *
     * @param array $meta_box
     */
    public function __construct($meta_box)
    {
        // Clean Input
        $defaults = array(
            'id' => null, // HTML 'id' attribute of the edit screen section
            'title' => ' ',
            'post_type' => 'page',
            'context' => 'normal', // ('normal', 'advanced', or 'side')
            'priority' => 'default', // ('high', 'core', 'default' or 'low')
            'fields' => array( // the value of this field is not set as a default, just included for reference
                'label' => null,
                'key' => null,
                'type' => 'text',
            ),
        );
        $this->meta_box = array_intersect_key($meta_box + $defaults, $defaults);

        add_action('admin_init', array($this, 'admin_init'));
        add_action('save_post', array($this, 'save_details'));
    }

    /**
     * Admin Init to actually add the meta box
     */
    public function admin_init()
    {
        add_meta_box($this->meta_box['id'], $this->meta_box['title'], array($this, 'display_fields'), $this->meta_box['post_type']);
    }

    /**
     * Display the fields in the edit pages
     */
    public function display_fields()
    {
        global $post;
        $custom = get_post_custom($post->ID);

        foreach ($this->meta_box['fields'] as $field) {
            $value = (isset($custom[$field['key']])) ? $custom[$field['key']][0] : null;
            echo '<label>' . $field['label'] . '</label><br />';
            switch ($field['type']) {
                case 'textarea':
                    echo '<textarea name="' . $field['key'] . '" style="width: 98%; ' . (!empty($field['style']) ? ' '.$field['style'] : null) . '"' . (!empty($field['rows']) ? ' rows="'.$field['rows'].'"' : null) . '>' . $value . '</textarea>';
                    break;
                case 'text':
                default:
                    echo '<input name="' . $field['key'] . '" value="' . $value . '"' . (!empty($field['style']) ? ' style="'.$field['style'].'"' : null) . '" />';
                    break;
            }
            echo '<br /><br />';
        }
        reset($this->meta_box);
    }

    /**
     * Save details when data is updated
     */
    public function save_details()
    {
        global $post;
        if (!isset($post->ID)) return;

        foreach ($this->meta_box['fields'] as $field) {
            $value = (isset($_POST[$field['key']])) ? $_POST[$field['key']] : null;
            update_post_meta($post->ID, $field['key'], $value);
        }
        reset($this->meta_box);
    }

}
