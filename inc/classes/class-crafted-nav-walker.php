<?php
/**
 * Custom navigation walker - Bootstrap Compatible
 *
 * @package Crafted_Theme
 */

if (!class_exists("Crafted_Nav_Walker")) {
    /**
     * Custom Nav Walker for Crafted Theme - Bootstrap Compatible
     */
    class Crafted_Nav_Walker extends Walker_Nav_Menu
    {
        /**
         * Starts the element output.
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param WP_Post  $item   Menu item data object.
         * @param int      $depth  Depth of menu item.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         * @param int      $id     Current item ID.
         */
        public function start_el(
            &$output,
            $item,
            $depth = 0,
            $args = null,
            $id = 0,
        ) {
            if (
                isset($args->item_spacing) &&
                "discard" === $args->item_spacing
            ) {
                $t = "";
                $n = "";
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = $depth ? str_repeat($t, $depth) : "";
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $classes[] = "menu-item-" . $item->ID;

            // Bootstrap specific classes
            if ($depth === 0) {
                $classes[] = "nav-item";
            }

            // Add Bootstrap dropdown class for parent items
            if (in_array("menu-item-has-children", $classes, true)) {
                $classes[] = "has-dropdown";
                if ($depth === 0) {
                    $classes[] = "dropdown";
                }
            }

            /**
             * Filters the arguments for a single nav menu item.
             */
            $args = apply_filters("nav_menu_item_args", $args, $item, $depth);

            /**
             * Filters the CSS classes applied to a menu item's list item element.
             */
            $class_names = implode(
                " ",
                apply_filters(
                    "nav_menu_css_class",
                    array_filter($classes),
                    $item,
                    $args,
                    $depth,
                ),
            );
            $class_names = $class_names
                ? ' class="' . esc_attr($class_names) . '"'
                : "";

            /**
             * Filters the ID applied to a menu item's list item element.
             */
            $id = apply_filters(
                "nav_menu_item_id",
                "menu-item-" . $item->ID,
                $item,
                $args,
                $depth,
            );
            $id = $id ? ' id="' . esc_attr($id) . '"' : "";

            $output .= $indent . "<li" . $id . $class_names . ">";

            $atts = [];
            $atts["title"] = !empty($item->attr_title) ? $item->attr_title : "";
            $atts["target"] = !empty($item->target) ? $item->target : "";
            if ("_blank" === $item->target && empty($item->xfn)) {
                $atts["rel"] = "noopener noreferrer";
            } else {
                $atts["rel"] = $item->xfn;
            }
            $atts["href"] = !empty($item->url) ? $item->url : "";
            $atts["aria-current"] = $item->current ? "page" : "";

            // Bootstrap nav-link class
            $link_classes = [];
            if ($depth === 0) {
                $link_classes[] = "nav-link";
                // Add Bootstrap dropdown toggle attributes for parent items
                if (in_array("menu-item-has-children", $classes, true)) {
                    $link_classes[] = "dropdown-toggle";
                    $atts["data-bs-toggle"] = "dropdown";
                    $atts["aria-expanded"] = "false";
                }
            } else {
                $link_classes[] = "dropdown-item";
            }

            // Add current page classes
            if (
                $item->current ||
                $item->current_item_ancestor ||
                $item->current_item_parent
            ) {
                $link_classes[] = $depth === 0 ? "current-menu-item" : "active";
            }

            if (!empty($link_classes)) {
                $atts["class"] = implode(" ", $link_classes);
            }

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             */
            $atts = apply_filters(
                "nav_menu_link_attributes",
                $atts,
                $item,
                $args,
                $depth,
            );

            $attributes = "";
            foreach ($atts as $attr => $value) {
                if (is_scalar($value) && "" !== $value && false !== $value) {
                    $value =
                        "href" === $attr ? esc_url($value) : esc_attr($value);
                    $attributes .= " " . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters("the_title", $item->title, $item->ID);

            /**
             * Filters a menu item's title.
             */
            $title = apply_filters(
                "nav_menu_item_title",
                $title,
                $item,
                $args,
                $depth,
            );

            $item_output = $args->before ?? "";
            $item_output .= "<a" . $attributes . ">";
            $item_output .=
                ($args->link_before ?? "") . $title . ($args->link_after ?? "");
            $item_output .= "</a>";
            $item_output .= $args->after ?? "";

            /**
             * Filters a menu item's starting output.
             */
            $output .= apply_filters(
                "walker_nav_menu_start_el",
                $item_output,
                $item,
                $depth,
                $args,
            );
        }

        /**
         * Ends the element output, if needed.
         */
        public function end_el(&$output, $item, $depth = 0, $args = null)
        {
            if (
                isset($args->item_spacing) &&
                "discard" === $args->item_spacing
            ) {
                $t = "";
                $n = "";
            } else {
                $t = "\t";
                $n = "\n";
            }
            $output .= "</li>{$n}";
        }

        /**
         * Starts the list before the elements are added.
         */
        public function start_lvl(&$output, $depth = 0, $args = null)
        {
            if (
                isset($args->item_spacing) &&
                "discard" === $args->item_spacing
            ) {
                $t = "";
                $n = "";
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = str_repeat($t, $depth);
            // Bootstrap dropdown-menu class for submenus
            $output .= "{$n}{$indent}<ul class=\"dropdown-menu\">{$n}";
        }

        /**
         * Ends the list of after the elements are added.
         */
        public function end_lvl(&$output, $depth = 0, $args = null)
        {
            if (
                isset($args->item_spacing) &&
                "discard" === $args->item_spacing
            ) {
                $t = "";
                $n = "";
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = str_repeat($t, $depth);
            $output .= "{$indent}</ul>{$n}";
        }
    }
}

/**
 * Mobile Nav Walker for Side Drawer
 */
if (!class_exists("Crafted_Mobile_Nav_Walker")) {
    class Crafted_Mobile_Nav_Walker extends Walker_Nav_Menu
    {
        public function start_el(
            &$output,
            $item,
            $depth = 0,
            $args = null,
            $id = 0,
        ) {
            $classes = empty($item->classes) ? [] : (array) $item->classes;

            $attributes = !empty($item->attr_title)
                ? ' title="' . esc_attr($item->attr_title) . '"'
                : "";
            $attributes .= !empty($item->target)
                ? ' target="' . esc_attr($item->target) . '"'
                : "";
            $attributes .= !empty($item->xfn)
                ? ' rel="' . esc_attr($item->xfn) . '"'
                : "";
            $attributes .= !empty($item->url)
                ? ' href="' . esc_attr($item->url) . '"'
                : "";
            $attributes .= ' data-bs-dismiss="offcanvas"'; // Close drawer on click

            // Add current page class
            $current_class = "";
            if (
                $item->current ||
                $item->current_item_ancestor ||
                $item->current_item_parent
            ) {
                $current_class = " current-menu-item";
            }

            // Get Font Awesome icon based on menu item title
            $icon = $this->get_menu_item_icon($item->title);

            $item_output =
                '<a class="nav-link' . $current_class . '"' . $attributes . ">";
            $item_output .= '<i class="' . $icon . ' me-2"></i>';
            $item_output .= apply_filters("the_title", $item->title, $item->ID);
            $item_output .= "</a>";

            $output .= $item_output;
        }

        /**
         * Helper function to get icons for mobile menu items
         */
        private function get_menu_item_icon($title)
        {
            $icons = [
                "About" => "fas fa-user",
                "Services" => "fas fa-cogs",
                "Portfolio" => "fas fa-briefcase",
                "Contact" => "fas fa-envelope",
                "Home" => "fas fa-home",
                "Blog" => "fas fa-blog",
                "Shop" => "fas fa-shopping-cart",
            ];

            return isset($icons[$title]) ? $icons[$title] : "fas fa-link";
        }
    }
}
