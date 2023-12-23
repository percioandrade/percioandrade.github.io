---
layout: page
permalink: /wp-shortcode/
title:  WordPress Shortcodes
categories: [WordPress,Code]
excerpt: A collection of WordPress shortcodes
---

## Shortcodes codes for you WordPress

Place it on functions.php or create a new plugin for this.

*   Changelog

- 1.0: Started
- 1.1: Codes updated to use fn() introduced on PHP 7.4
- 1.2: Converted to github pages

---

**Show post title - Usage: [page_title]**

    function show_page_title() {
        $title = get_transient('show_page_title');

        if (false === $title) {
            $title = get_the_title();
            set_transient('show_page_title', $title, 1 * HOUR_IN_SECONDS);
        }

        return esc_html($title) ?: 'Untitled';
    }
    add_shortcode('page_title', 'show_page_title');

---

**Get page/post URL - Usage: [page_url]**

    function show_page_url() {
        $url = get_transient('show_page_url');

        if (false === $url) {
            $url = get_permalink();
            $url = rtrim($url, '/');
            set_transient('show_page_url', $url, 1 * HOUR_IN_SECONDS);
        }

        return esc_url($url);
    }
    add_shortcode('page_url', 'show_page_url');

---

**Show featured image from post - Usage: [thumb size="thumbnail"]**

    function show_thumb($atts) {
        $atts = shortcode_atts(array(
            'size' => 'thumbnail',
        ), $atts);

        $thumbnail = get_the_post_thumbnail(null, $atts['size']);
        $caption = get_the_post_thumbnail_caption();
        $link = get_permalink();

        return '<div class="featured-image">'
            . $thumbnail . '<span class="caption imgPerfil">' . esc_html($caption) . '</span>'
            . '</div>';
    }
    add_shortcode('thumb', 'show_thumb');

---

**Show latest posts - Usage: [latest_post]**

    function latest_post() {
        $the_query = new WP_Query(array(
            'category_name' => 'noticias',
            'posts_per_page' => 3,
        ));

        $output = ''; // initialize output variable

        if ($the_query->have_posts()) {
            $output .= '<div class="latest-posts">'; // start a container div

            foreach ($the_query->posts as $post) {
                setup_postdata($post);
                $output .= '<div class="latest-post">';
                $output .= '<a href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, array(80, 80)) . '</a>';
                $output .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                $output .= '</div>';
            }

            $output .= '</div>'; // close the container div
            wp_reset_query();
        } else {
            $output .= '<p>' . __('No News') . '</p>';
        }

        return $output;
    }
    add_shortcode('latest_post', 'latest_post');

---

**Show latest post updated time - Usage: [update_time]**

    function update_time() {
        $u_time = get_the_time('U');
        $u_modified_time = get_the_modified_time('U');
        
        // Only display modified date if 24 hours have passed since the post was published.
        if ($u_modified_time >= $u_time + 86400) {
            $updated_date = get_the_modified_time('d/m/Y');
            $updated_time = get_the_modified_time('h:i a');
            
            $description = empty($desc) ? '' : $desc . ' ';
            $description .= $updated_date . ' ' . $updated_time;
            
            return wp_kses_post($description);
        }
    }
    add_shortcode('update_time', 'update_time');

---

**Count total posts for category taxonomy - Usage: [cat_count]**

    function update_time() {
        $u_time = get_the_time('U');
        $u_modified_time = get_the_modified_time('U');
        
        // Only display modified date if 24 hours have passed since the post was published.
        if ($u_modified_time >= $u_time + 86400) {
            $updated_date = get_the_modified_time('d/m/Y');
            $updated_time = get_the_modified_time('h:i a');
            
            $description = empty($desc) ? '' : $desc . ' ';
            $description .= $updated_date . ' ' . $updated_time;
            
            return wp_kses_post($description);
        }
    }
    add_shortcode('update_time', 'update_time');

---

**Get imagems from template dir - Usage: [get_the image="/path/image"]**

    add_shortcode('get_the', function($atts) {
        global $bndurl;
        // Check if 'image' attribute exists
        $image = $atts['image'] ?? null;

        if (!$image) {
            return 'Error: image attribute missing';
        }

        // Use string interpolation to create image URL
        $image_url = "{$bndurl}/assets/img{$image}";
        return $image_url;
    });

---

**Get actual user url - Usage: [user_url]**

    function user_url() {
        $base_url = get_bloginfo('url');
        $current_user = wp_get_current_user();
        $username_slug = $current_user->user_nicename;
        $wordpress_url = $base_url . '/author/' . $username_slug;
        return $wordpress_url;
    }
    add_shortcode('user_url', 'user_url');

---

**Generate a url from random post - Usage: [random_post]**

    function random_post() {
        $random_post = get_posts(array(
            'post_type'      => 'post',
            'orderby'        => 'rand',
            'posts_per_page' => 1,
            'post_status'    => 'publish'
        ));

        if ($random_post) {
            return get_the_permalink($random_post[0]->ID);
        }

        return '';
    }
    add_shortcode('random_post', 'random_post');

---