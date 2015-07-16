<?php

if ( ! function_exists( 'atom_v9_setup' ) ) :
    function atom_v9_setup() {

    	// Add default posts and comments RSS feed links to head.
    	add_theme_support( 'automatic-feed-links' );

    	add_theme_support( 'title-tag' );

    	add_theme_support( 'post-thumbnails' );

        add_theme_support( 'menus' );
        
    	add_theme_support( 'html5', array(
    		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    	) );

    	add_theme_support( 'post-formats', array(
    		'aside', 'image', 'video', 'quote', 'link',
    	) );

        load_theme_textdomain( 'atom', get_template_directory() . '/languages' );

    }
endif; 
add_action( 'after_setup_theme', 'atom_v9_setup' );

/**
 * Enqueue scripts and styles.
 */
function atom_scripts_and_styles() {

    // Only on stage
    if( !strpos($_SERVER['SERVER_NAME'], 'bulledev.com') ){
        wp_enqueue_style( 'atom-style', get_stylesheet_uri() );
    }
	
    // jQuery
    if( is_page(199) || is_page(1485) || is_page(1489) || is_page(1450) ){
        wp_enqueue_script( 'jquery' ); 
    }

}

add_filter( 'gform_submit_button', 'theme_t_wp_submit_button', 10, 2 );
function theme_t_wp_submit_button( $button, $form ){
 
  return '<button class="button button-blue button-big" type="submit" name="action" id="gform_submit_button_'.$form["id"].'">'.$form["button"]["text"]. '</button>';
 
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="button button-blue btn_page"';
}

add_action('after_setup_theme','atom_startup');
function atom_startup() {
    // launching operation cleanup
    add_action('init', 'atom_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'atom_rss_version');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'atom_scripts_and_styles', 999);

    // add comment script only when the comment form is loaded
    add_action( 'comment_form_before', 'xtreme_enqueue_comments_reply' );

} 

// Some cleanup
function atom_head_cleanup() {

    // Remove emoji from WP 4.2
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
    remove_action( 'wp_head', 'rsd_link' );
    // windows live writer
    remove_action( 'wp_head', 'wlwmanifest_link' );
    // index link
    remove_action( 'wp_head', 'index_rel_link' );
    // previous link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
    // start link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    // links for adjacent posts
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    // WP version
    remove_action( 'wp_head', 'wp_generator' );

    // remove WP version from css
    add_filter( 'style_loader_src', 'atom_remove_wp_ver_css_js', 9999 );

    // remove Wp version from scripts
    add_filter( 'script_loader_src', 'atom_remove_wp_ver_css_js', 9999 );

    // Defer script
    add_filter( 'script_loader_tag', 'add_async', 10, 2 );

} /* end head cleanup */

// remove WP version from RSS
function atom_rss_version() { return ''; }

// remove WP version from scripts
function atom_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

function notify_question_author($comment_id, $comment = null) {
    global $post;
    if( 'question' == get_post_type($post->ID) ){
        $to = get_post_meta( $post->ID, 'question-courriel', true );
        $subject = 'Une nouvelle réponse à votre question!';
        $message = 'Il y a une nouvelle réponse à votre question: ' . get_permalink($post->ID);
        $headers[] = 'From: atom.com <no-reply@atom.com>';

        wp_mail( $to, $subject, $message, $headers );
    }
}
add_action('wp_insert_comment', 'notify_question_author');

function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php echo get_comment_author_link(); ?>
    
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
            <br />
        <?php endif; ?>

        <em> <small>- <?php echo get_comment_date(); ?></small></em>

    </div>


    

    <?php comment_text(); ?>

    <div class="reply">
    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}

function xtreme_enqueue_comments_reply() {
    if( get_option( 'thread_comments' ) )  {
        wp_enqueue_script( 'comment-reply' );
    }
}

// Defer all script
function add_async( $tag, $handle ) {
    if( is_admin() || is_page(199) || is_page(1485) || is_page(1489) || is_page(1450) ) {
        return $tag;
    }else{
        return str_replace( ' src', ' async src', $tag );
    }
}

// Inject icon font
add_action('wp_head','inject_font', 4);
function inject_font()
{
    $critical_syle = "<style>";

    $critical_syle .= "@font-face {";
        $critical_syle .= "font-family: 'icomoon';";
        $critical_syle .= "src:url('" . get_bloginfo("template_directory") . "/assets/fonts/icomoon.eot?nkq9bc');";
        $critical_syle .= "src:url('" . get_bloginfo("template_directory") . "/assets/fonts/icomoon.eot?#iefixnkq9bc') format('embedded-opentype'),";
            $critical_syle .= "url('" . get_bloginfo("template_directory") . "/assets/fonts/icomoon.ttf?nkq9bc') format('truetype'),";
            $critical_syle .= "url('" . get_bloginfo("template_directory") . "/assets/fonts/icomoon.woff?nkq9bc') format('woff'),";
            $critical_syle .= "url('" . get_bloginfo("template_directory") . "/assets/fonts/icomoon.svg?nkq9bc#icomoon') format('svg');";
        $critical_syle .= "font-weight: normal;";
        $critical_syle .= "font-style: normal;";
    $critical_syle .= "}";

    $critical_syle .= "</style>";

    echo $critical_syle;
}

// Critical CSS only for main domain
if( strpos($_SERVER['SERVER_NAME'], 'bulledev.com') ){
    add_action('wp_head','inject_css', 5);
}

function inject_css()
{
    $critical_syle = "<style>";

    if( is_front_page() || is_archive() ){
        $critical_syle .= file_get_contents( get_bloginfo("template_directory") . "/critical/archive.min.css");
    }elseif( is_single() ){
        $critical_syle .= file_get_contents( get_bloginfo("template_directory") . "/critical/single.min.css");
    }else{
        $critical_syle .= file_get_contents( get_bloginfo("template_directory") . "/critical/page.min.css");
    }

    $critical_syle .= "</style>";

    echo $critical_syle;

    echo '<script>';
        echo 'function loadCSS( href, before, media ){';
            echo '"use strict";';
            echo 'var ss = window.document.createElement( "link" );';
            echo 'var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];';
            echo 'var sheets = window.document.styleSheets;';
            echo 'ss.rel = "stylesheet";';
            echo 'ss.href = href;';
            echo 'ss.media = "only x";';
            echo 'ref.parentNode.insertBefore( ss, ref );';
            echo 'function toggleMedia(){';
                echo 'var defined;';
                echo 'for( var i = 0; i < sheets.length; i++ ){';
                    echo 'if( sheets[ i ].href && sheets[ i ].href.indexOf( href ) > -1 ){';
                        echo 'defined = true;';
                    echo '}';
                echo '}';
                echo 'if( defined ){';
                    echo 'ss.media = media || "all";';
                echo '}';
                echo 'else {';
                    echo 'setTimeout( toggleMedia );';
                echo '}';
            echo '}';
            echo 'toggleMedia();';
            echo 'return ss;';
        echo '}';

        echo 'loadCSS( "' . get_bloginfo("template_directory") . '/style.css" );';
    echo ' </script>';

    echo '<noscript><link href="' . get_bloginfo("template_directory") . '/style.css" rel="stylesheet"></noscript>';
}

/*
* Javascripts injection in the footer
*/
add_action('wp_footer','inject_js', 5);
function inject_js(){
    echo '<script>';
        // Menu toggle
        echo 'document.getElementById("icon-bars").addEventListener("click", function () {';
        echo 'var menu = document.getElementById("menu");';
        echo 'if (menu.classList.contains("open")) {';
            echo 'menu.classList.remove("open");';
        echo '} else {';
            echo 'menu.classList.add("open");';
        echo '}';
        echo '});';
        
        // Google Analytics
        echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){";
        echo "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),";
        echo "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)";
        echo "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');";
        echo "ga('create', 'UA-43847997-1', {'siteSpeedSampleRate': 100});";
        echo "ga('send', 'pageview');";
    echo '</script>';
}
