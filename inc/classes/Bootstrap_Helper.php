<?php

/**
 * A utility class to handle responsive image and video rendering in WordPress.
 *
 * This class provides a static method to generate a complete responsive <img> or
 * <video> tag, including `srcset` and `sizes` attributes, based on user-defined
 * breakpoints and a given image or video attachment ID.
 *
 * Now includes support for modern image formats (WebP, AVIF) using the <picture> element.
 */
class Bootstrap_Image_Helper
{
    // A flag to ensure the lazy-loading script is only outputted once.
    private static $script_outputted = false;

    /**
     * Renders a responsive <img> or <video> tag with appropriate attributes.
     *
     * @param int|object|array $attachment The image/video attachment ID, a full attachment object, or an ACF attachment array.
     * @param string $class An additional CSS class for the tag.
     * @param array $viewport_sizes An associative array mapping CSS breakpoints (sm, md, lg, xl)
     * to WordPress registered image sizes (thumbnail, medium, large, full).
     * @param array $video_options An associative array for video-specific attributes.
     * Keys can include 'autoplay', 'loop', 'muted'.
     * @return string The complete HTML <img> or <video> tag.
     */
    public static function renderImage(
        $attachment,
        $class = "",
        $viewport_sizes = [],
        $video_options = [],
    ) {
        // Return an empty string if no valid attachment is provided.
        if (empty($attachment)) {
            return "";
        }

        // Get the attachment ID from the provided data type.
        $attachment_id = 0;
        if (is_int($attachment)) {
            $attachment_id = $attachment;
        } elseif (is_object($attachment) && isset($attachment->ID)) {
            $attachment_id = $attachment->ID;
        } elseif (is_array($attachment) && isset($attachment["ID"])) {
            $attachment_id = $attachment["ID"];
        }

        if (!$attachment_id) {
            return "";
        }

        // Get the full post object.
        $attachment_post = get_post($attachment_id);

        if (!$attachment_post) {
            return "";
        }

        // Check if the attachment is a video.
        if (strpos($attachment_post->post_mime_type, "video") !== false) {
            $video_url = wp_get_attachment_url($attachment_id);
            if (!$video_url) {
                return "";
            }

            // Get the poster image URL if one is set.
            $poster_url = get_the_post_thumbnail_url($attachment_id, "full");

            // Build the video tag with controls enabled by default.
            $output = '<video class="' . esc_attr($class) . '" controls';

            // Add poster attribute if a poster image is found.
            if ($poster_url) {
                $output .= ' poster="' . esc_url($poster_url) . '"';
            }

            // Add additional video options like autoplay, loop, and muted.
            if (isset($video_options["autoplay"])) {
                $output .= " autoplay";
            }
            if (isset($video_options["loop"])) {
                $output .= " loop";
            }
            if (isset($video_options["muted"])) {
                $output .= " muted";
            }

            $output .= ">";
            $output .=
                '<source src="' .
                esc_url($video_url) .
                '" type="' .
                esc_attr($attachment_post->post_mime_type) .
                '">';
            $output .= "</video>";

            return $output;
        }

        // --- Start of Image Handling (if not a video) ---
        $alt_text = get_post_meta(
            $attachment_id,
            "_wp_attachment_image_alt",
            true,
        );

        $breakpoints = [
            "xs" => "480px",
            "sm" => "576px",
            "md" => "768px",
            "lg" => "992px",
            "xl" => "1200px",
        ];

        // Get all available image sizes
        $intermediate_sizes = function_exists('get_intermediate_image_sizes')
            ? get_intermediate_image_sizes()
            : ['thumbnail', 'medium', 'large', 'full'];

        // Build srcsets for different formats
        $format_srcsets = self::buildFormatSrcsets($attachment_id, $intermediate_sizes);

        // Build viewport sizes
        $viewport_media_queries = [];
        $default_size = "full";

        foreach ($viewport_sizes as $breakpoint_key => $size_name) {
            if (
                in_array($size_name, [
                    "thumbnail",
                    "medium",
                    "large",
                    "full",
                ]) ||
                in_array($size_name, $intermediate_sizes)
            ) {
                if (isset($breakpoints[$breakpoint_key])) {
                    $min_width = $breakpoints[$breakpoint_key];
                    $viewport_media_queries[] = "(min-width: {$min_width}) {$size_name}";
                }
                $default_size = $size_name;
            }
        }

        usort($viewport_media_queries, function ($a, $b) {
            preg_match("/min-width: (\d+)px/", $a, $matches_a);
            preg_match("/min-width: (\d+)px/", $b, $matches_b);
            return $matches_a[1] <=> $matches_b[1];
        });

        $sizes = implode(", ", $viewport_media_queries);
        if ($sizes) {
            $sizes .= ", " . $default_size;
        } else {
            $sizes = "100vw";
            $default_size = "full";
        }

        // Get the default src for the fallback img tag
        $src_array = wp_get_attachment_image_src($attachment_id, $default_size);
        $src = "";
        if (is_array($src_array) && isset($src_array[0])) {
            $src = $src_array[0];
        } else {
            // Fallback to full size if the default size is not available.
            $src_array = wp_get_attachment_image_src($attachment_id, "full");
            if (is_array($src_array) && isset($src_array[0])) {
                $src = $src_array[0];
            }
        }

        // Use picture element if we have modern formats
        $has_modern_formats = !empty($format_srcsets['avif']) || !empty($format_srcsets['webp']);

        if ($has_modern_formats) {
            $output = '<picture>';

            // AVIF source (most modern)
            if (!empty($format_srcsets['avif'])) {
                $output .= '<source type="image/avif"';
                $output .= ' data-srcset="' . esc_attr($format_srcsets['avif']) . '"';
                if ($sizes) {
                    $output .= ' data-sizes="' . esc_attr($sizes) . '"';
                }
                $output .= '>';
            }

            // WebP source
            if (!empty($format_srcsets['webp'])) {
                $output .= '<source type="image/webp"';
                $output .= ' data-srcset="' . esc_attr($format_srcsets['webp']) . '"';
                if ($sizes) {
                    $output .= ' data-sizes="' . esc_attr($sizes) . '"';
                }
                $output .= '>';
            }

            // Fallback img tag
            $output .= '<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="';
            $output .= ' alt="' . esc_attr($alt_text) . '"';
            $output .= ' class="' . esc_attr($class) . '"';
            $output .= ' loading="lazy"';
            $output .= ' data-src="' . esc_url($src) . '"';

            if (!empty($format_srcsets['original'])) {
                $output .= ' data-srcset="' . esc_attr($format_srcsets['original']) . '"';
                if ($sizes) {
                    $output .= ' data-sizes="' . esc_attr($sizes) . '"';
                }
            }

            $output .= '>';
            $output .= '</picture>';
        } else {
            // No modern formats, use regular img tag
            $output = '<img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="';
            $output .= ' alt="' . esc_attr($alt_text) . '"';
            $output .= ' class="' . esc_attr($class) . '"';
            $output .= ' loading="lazy"';
            $output .= ' data-src="' . esc_url($src) . '"';

            if (!empty($format_srcsets['original'])) {
                $output .= ' data-srcset="' . esc_attr($format_srcsets['original']) . '"';
                if ($sizes) {
                    $output .= ' data-sizes="' . esc_attr($sizes) . '"';
                }
            }

            $output .= '>';
        }

        // Add the lazy-loading script if it hasn't been added yet.
        if (!self::$script_outputted) {
            $output .= '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    const lazyImages = document.querySelectorAll("img[loading=\'lazy\'], picture source");
                    const lazyLoadObserver = new IntersectionObserver(function(entries, observer) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                const lazyElement = entry.target;

                                // Handle img tags
                                if (lazyElement.tagName === "IMG") {
                                    if (lazyElement.dataset.src) {
                                        lazyElement.src = lazyElement.dataset.src;
                                    }
                                    if (lazyElement.dataset.srcset) {
                                        lazyElement.srcset = lazyElement.dataset.srcset;
                                    }
                                    if (lazyElement.dataset.sizes) {
                                        lazyElement.sizes = lazyElement.dataset.sizes;
                                    }
                                    lazyElement.removeAttribute("loading");
                                }

                                // Handle source tags in picture elements
                                if (lazyElement.tagName === "SOURCE") {
                                    if (lazyElement.dataset.srcset) {
                                        lazyElement.srcset = lazyElement.dataset.srcset;
                                    }
                                    if (lazyElement.dataset.sizes) {
                                        lazyElement.sizes = lazyElement.dataset.sizes;
                                    }
                                }

                                observer.unobserve(lazyElement);
                            }
                        });
                    }, {
                        rootMargin: "0px 0px 200px 0px"
                    });

                    lazyImages.forEach(function(lazyElement) {
                        lazyLoadObserver.observe(lazyElement);
                    });
                });
            </script>';
            self::$script_outputted = true;
        }

        return $output;
    }

    /**
     * Build srcsets for different image formats (AVIF, WebP, original)
     *
     * @param int $attachment_id The attachment ID
     * @param array $intermediate_sizes Array of image size names
     * @return array Associative array with 'avif', 'webp', and 'original' srcsets
     */
    private static function buildFormatSrcsets($attachment_id, $intermediate_sizes)
    {
        $srcsets = [
            'avif' => '',
            'webp' => '',
            'original' => ''
        ];

        $upload_dir = wp_upload_dir();
        $metadata = wp_get_attachment_metadata($attachment_id);

        if (!$metadata) {
            return $srcsets;
        }

        $file_path = get_attached_file($attachment_id);
        $file_info = pathinfo($file_path);
        $base_dir = $file_info['dirname'];
        $base_name = $file_info['filename'];

        foreach ($intermediate_sizes as $size_name) {
            $image_data = wp_get_attachment_image_src($attachment_id, $size_name);

            if ($image_data) {
                $src = $image_data[0];
                $width = $image_data[1];

                // Add to original srcset
                $srcsets['original'] .= "{$src} {$width}w, ";

                // Check for WebP version
                $webp_url = self::getModernFormatUrl($src, 'webp', $base_dir, $base_name, $size_name, $metadata);
                if ($webp_url) {
                    $srcsets['webp'] .= "{$webp_url} {$width}w, ";
                }

                // Check for AVIF version
                $avif_url = self::getModernFormatUrl($src, 'avif', $base_dir, $base_name, $size_name, $metadata);
                if ($avif_url) {
                    $srcsets['avif'] .= "{$avif_url} {$width}w, ";
                }
            }
        }

        // Clean up trailing commas
        $srcsets['original'] = rtrim($srcsets['original'], ', ');
        $srcsets['webp'] = rtrim($srcsets['webp'], ', ');
        $srcsets['avif'] = rtrim($srcsets['avif'], ', ');

        return $srcsets;
    }

    /**
     * Get the URL for a modern format version of an image
     *
     * @param string $original_url The original image URL
     * @param string $format The format to check for ('webp' or 'avif')
     * @param string $base_dir The base directory path
     * @param string $base_name The base filename without extension
     * @param string $size_name The image size name
     * @param array $metadata The attachment metadata
     * @return string|false The URL if the file exists, false otherwise
     */
    private static function getModernFormatUrl($original_url, $format, $base_dir, $base_name, $size_name, $metadata)
    {
        // Try to construct the modern format filename
        $modern_file = '';

        if ($size_name === 'full') {
            $modern_file = $base_dir . '/' . $base_name . '.' . $format;
        } elseif (isset($metadata['sizes'][$size_name]['file'])) {
            $size_file = $metadata['sizes'][$size_name]['file'];
            $size_info = pathinfo($size_file);
            $modern_file = $base_dir . '/' . $size_info['filename'] . '.' . $format;
        }

        /**
         * Filter the path to the modern image format.
         *
         * @param string $modern_file The path to the modern image format.
         * @param string $original_url The original image URL.
         * @param string $format The format to check for ('webp' or 'avif').
         * @param string $base_dir The base directory path.
         * @param string $base_name The base filename without extension.
         * @param string $size_name The image size name.
         * @param array $metadata The attachment metadata.
         */
        $modern_file = apply_filters('crafted_theme_modern_image_path', $modern_file, $original_url, $format, $base_dir, $base_name, $size_name, $metadata);


        // Check if the file exists and is readable
        if ($modern_file && file_exists($modern_file) && is_readable($modern_file)) {
            // Convert file path to URL
            $upload_dir = wp_upload_dir();
            $modern_url = str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $modern_file);
            return $modern_url;
        }

        return false;
    }

    /**
     * Get attachment ID from image URL
     *
     * @param string $url The image URL
     * @return int|false The attachment ID or false if not found
     */
    public static function getAttachmentIdFromUrl($url)
    {
        global $wpdb;

        if (empty($url)) {
            return false;
        }

        // Remove query strings and fragments
        $url = preg_replace('/[?#].*/', '', $url);

        // Try to get the attachment ID
        $attachment_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE guid = %s",
                $url
            )
        );

        if (!$attachment_id) {
            // Try using attachment_url_to_postid as fallback
            $attachment_id = attachment_url_to_postid($url);
        }

        return $attachment_id ? (int) $attachment_id : false;
    }
}

/**
 * A utility class to handle Bootstrap button rendering in WordPress.
 *
 * This class provides a static method to generate a Bootstrap-styled button
 * from a WordPress link object.
 */
class Bootstrap_Button_Helper
{
    /**
     * Renders a Bootstrap button from a WordPress link object.
     * @param array $link_object The WordPress link object with 'url', 'title', and 'target' keys.
     * @param string $class Additional CSS classes for the button.
     * @return string The complete HTML <a> tag styled as a Bootstrap button.
     */
    public static function renderButtonFromLinkObject(
        $link_object,
        $class = "btn btn-primary",
    ) {
        if (empty($link_object) || !is_array($link_object)) {
            return "";
        }
        $url = isset($link_object["url"]) ? $link_object["url"] : "#";
        $title = isset($link_object["title"])
            ? $link_object["title"]
            : "Learn More";
        $target = isset($link_object["target"])
            ? $link_object["target"]
            : "_self";

        $output = '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . '" target="' . esc_attr($target) . '">';
        $output .= esc_html($title);
        $output .= '</a>';
        return $output;
    }
}
