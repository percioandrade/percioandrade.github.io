---
layout: page
permalink: /wp-action/
title:  WordPress Actions
categories: [WordPress,Code]
excerpt: A collection of WordPress actions
---

## Actions codes for you WordPress

Coloque-o em functions.php ou crie um novo plugin para isso.

*   Changelog

- 1.0: Started
- 1.1: Codes updated to use fn() introduced on PHP 7.4
- 1.2: Converted to github pages

---

**<a name="remove_emoji">WordPress - Remove emojis</a>**

```plaintext
add_action('init', fn() => {
    remove_action('wp_head', 'print_emoji_detection_script', 10);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
});
```

---

**WordPress - Change author base url: domain/author to your domain/$NEW\_SLUG**

```plaintext
function wp_custom_author_urlbase($wp_rewrite) {
    $author_slug = 'NEW_SLUG'; // the new slug name
    $wp_rewrite->author_base = $author_slug;
    $wp_rewrite->flush_rules(); // Use flush_rules() instead of flush_rewrite_rules()
}
add_action('init', 'wp_custom_author_urlbase');
```

---

**WordPress - Change query search 's' to other value**

```plaintext
add_action('init', fn() => {
    add_rewrite_tag('%search_query%', '([^&]+)');
    remove_query_arg('s');
});

add_filter('request', fn($request) => {
    if (isset($request['search_query'])) {
        $search_query = sanitize_text_field($request['search_query']);
        $request['s'] = $search_query;
    }
    return $request;
});
```

---

**WordPress - Disable default search on WordPress**

```plaintext
add_action('init', fn() => {
    add_rewrite_tag('%search_query%', '([^&]+)');
    remove_query_arg('s');
});

add_filter('request', fn($request) => {
    if (isset($_GET['search'])) {
        $search_query = sanitize_text_field($_GET['search']);
        $request['s'] = $search_query;
    }

    return $request;
});
```

---

**<a name="remove_wpversion">WordPress - Remove WP version from head</a>**

```plaintext
add_action('init', fn() => {
    remove_action('wp_head', 'wp_generator');
});
```

---

**<a name="remove_fontawesome">WordPress - Disable FontAwesome</a>**

```plaintext
add_action('wp_enqueue_scripts', fn() => wp_dequeue_style('font-awesome'), 50);
```

---

**<a name="remove_gutenbergcss">WordPress - Remove Gutenberg block library CSS</a>**

```plaintext
add_action('wp_enqueue_scripts', fn() => {
    wp_dequeue_style(array('wp-block-library', 'wp-block-library-theme', 'wc-block-style', 'global-styles'));
});
```

---

**Theme - Enable RSS on Header**

```plaintext
add_theme_support('automatic-feed-links');
```

---

**<a name="hide_adminajax">WordPress - Hide admin ajax from no-admin users</a>**

```plaintext
add_action('admin_init', fn() => {
    if (!current_user_can('manage_options') && !is_admin()) {
        wp_redirect(home_url());
        exit;
    }
});
```

---

**WordPress - Change footer text**

```plaintext
add_action('admin_footer_text', fn() => echo 'YOUR NEW FOOTER';);
```

---

**<a name="prevent_upload">WordPress - Prevent upload from no staff users</a>**

```plaintext
function pws_block_admin() {
    $request_uri = $_SERVER['REQUEST_URI'];

    if (
        stripos($request_uri, '/wp-admin/') !== false &&
        stripos($request_uri, 'async-upload.php') === false &&
        stripos($request_uri, 'admin-ajax.php') === false &&
        !current_user_can('manage_options')
    ) {
        wp_safe_redirect(home_url(), 302);
        exit;
    }
}
add_action('admin_init', 'pws_block_admin', 0);
```

---

**<a name="jquery_footer">WordPress - Include jQuery and jQuery Migrate in the footer</a>**

```plaintext
add_action('wp_enqueue_scripts', fn() => {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-migrate');
    }
});

function include_jquery_in_footer() {
    if (!is_admin()) {
        wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true);
        wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.3.2.min.js', array('jquery'), '3.3.2', true);
    }
}
add_action('wp_enqueue_scripts', 'include_jquery_in_footer');
```

---

**WordPress - Add custom js external scripts**

```plaintext
function add_scripts() {
    // Enqueue JavaScript
    wp_enqueue_script('example-js', 'https://example.com/js/example.js', array(), '1.0', true);

    // Enqueue CSS styles
    wp_enqueue_style('example-css', 'https://example.com/css/example.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'add_scripts');
```

---

**WordPress - Insert tags on body**

```plaintext
add_action('wp_footer', fn() => {
    // Insert here the code you want, Google Ads, Analytics, etc
});
```

---

**<a name="remove_fontawesomeelementor">Elementor - Remove the Font Awesome http request as well on elementor</a>**

```plaintext
add_action('elementor/frontend/after_enqueue_styles', fn() => wp_dequeue_style('font-awesome'));

add_action('elementor/frontend/after_register_styles', fn() => {
    foreach (['solid', 'regular', 'brands'] as $style) {
        wp_deregister_style('elementor-icons-fa-' . $style);
    }
}, 20);
```

---

**<a name="remove_elementoreicons">Elementor - Remove Eicons in Elementor</a>**

```plaintext
add_action('wp_enqueue_scripts', fn() => {
    wp_dequeue_style('elementor-icons');
    wp_deregister_style('elementor-icons');
}, 11);
```

---

**<a name="remove_elementoranimations">Elementor - Remove Animations</a>**

```plaintext
add_action('wp_enqueue_scripts', fn() => {
    wp_deregister_style('elementor-animations');
    wp_dequeue_style('elementor-animations');
    wp_dequeue_style('elementor-frontend');
}, 100);
```

---