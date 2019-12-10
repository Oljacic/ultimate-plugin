<?php
/**
 * Created by PhpStorm.
 * User: Stef
 * Date: 12/10/2019
 * Time: 18:34 PM
 */

namespace Inc\Api\Callbacks;

class TaxonomyCallbacks
{
    public function taxSectionManager(){
        echo 'Create as many Taxonomies as you want.';
    }

    public function taxSanitize($input) {

        $taxonomy = strtolower(str_replace(' ', '', $input['taxonomy']));

        $output = get_option('ultimate_plugin_tax');

        if(isset($_POST['remove'])) {

            $delete = strtolower(str_replace(' ', '', $_POST['remove']));
            unset($output[$delete]);

            return $output;
        }


        if (count($output) == 0) {
            $output[$taxonomy] = $input;
            return $output;
        }

        foreach ($output as $key => $value) {
            if ($taxonomy === $key) {
                $output[$key] = $input;
            } else {
                $output[$taxonomy] = $input;
            }
        }
        return $output;
    }

    public function textField($args){

        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $readonly = '';

        if(isset($_POST["edit_tax"])) {
            $input = get_option($option_name);
            $value = $input[strtolower(str_replace(' ', '',$_POST['edit_tax']))][$name];

            $readonly = ($name === 'post_type') ? 'readonly' : '';
        }

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'. $value .'" placeholder="' . $args['placeholder'] . '" required="required" ' . $readonly .'>';
    }

    public function checkboxField($args){

        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];
        $checked = false;

        if (isset($_POST["edit_tax"])) {
            $post_type_name = strtolower(str_replace(' ', '', $_POST["edit_tax"]));
            $checkbox = get_option($option_name);
            $checked = isset($checkbox[$post_type_name][$name])?: false;
        }
        echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
    }
}