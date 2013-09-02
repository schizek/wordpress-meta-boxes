wordpress-meta-boxes
====================

A class to easily add custom meta boxes and fields programmatically

Example Usage...

$meta_box = array(
   'id'        => 'my-custom-meta',
   'title'     => 'My Metabox Title',
   'post_type' => 'page',
   'context'   => 'normal',
   'priority'  => 'default',
   'fields'    => array(
       array(
           'label' => 'Description',
           'key'   => 'my-custom-desc',
           'type'  => 'textarea',
       ),
       array(
           'label' => 'Goal Amount',
           'key'   => 'my-custom-amount',
           'type'  => 'text',
       ),
   ),
);
$meta_box_setup = new FD_Meta_Boxes($meta_box);
