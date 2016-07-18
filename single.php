<?php

// Post title
beans_add_attribute( 'beans_post_title', 'class', 'uk-margin-small-bottom' );

// Move the post image above the post title.
//beans_modify_action_hook( 'beans_post_navigation', 'beans_main_grid_prepend_markup');
//beans_modify_action_hook( 'beans_post_image', 'beans_post_navigation_item[_previous]_after_markup' );

//remove breadcrumb
beans_remove_action( 'beans_breadcrumb' );

// Post navigation
beans_add_attribute( 'beans_post_navigation', 'class', 'uk-grid-margin' );

// Post navigation
beans_add_attribute( 'beans_post_navigation', 'class', 'uk-grid-margin uk-margin-bottom-remove' );

// Post comments
beans_add_attribute( 'beans_comments', 'class', 'uk-margin-bottom-remove' );
beans_add_attribute( 'beans_comment_form_wrap', 'class', 'uk-contrast' );
beans_add_attribute( 'beans_comment_form_submit', 'class', 'uk-button-large' );
beans_add_attribute( 'beans_no_comment', 'class', 'tm-no-comments uk-text-center uk-text-large uk-block' );

//FB Scripts
beans_add_action( 'fb_scripts', 'beans_head_append_markup', 'add_fb_scripts');
function add_fb_scripts() { ?>
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1004140779634904";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));

    </script>
    <?php
}

// Share Buttons
beans_add_action( 'site_share_buttons', 'beans_post_content_prepend_markup', 'add_site_share_buttons' );
beans_add_action( 'site_share_buttons', 'beans_post_content_append_markup', 'add_site_share_buttons' );
function add_site_share_buttons() {
?>
        <ul class="site-share-buttons uk-grid">
            <li class="uk-width-medium-1-2 uk-container-center"><a href="javascript:fbShare('<?php the_permalink(); ?>', '<?php the_title(); ?>', '<?php the_excerpt(); ?>', '<?php get_the_post_thumbnail(); ?>', 520, 350)" target="_blank" rel="external nofollow" class="tm-share-facebook"><i class="uk-icon-facebook"></i><span>Share on Facebook</span></a></li>
            <li class="uk-width-medium-1-2 uk-hidden-small"><a href="http://twitter.com/share?text='<?php the_title(); ?>'&amp;url='<?php the_permalink(); ?>'&amp;via=sharefaithit" target="_blank" rel="external nofollow" class="tm-share-twitter"><i class="uk-icon-twitter"></i><span>Share on Twitter</span></a></li>
        </ul>
        <?php
                                  }

// Mobile Sticky Share
beans_add_action( 'sticky_share_buttons', 'beans_site_before_markup','add_sticky_share_buttons');
function add_sticky_share_buttons() { ?>
            <div id="fb-nav-bar">
                <div id="nav-fb-share" class="facebook-share"><i class="uk-icon-facebook fb-nav"> Share on Facebook</i></div>
                <div id="nav-tweet-share" class="twitter-share"><i class="uk-icon-twitter tweet-nav"> Share on Twitter</i></div>
            </div>
            <?php
}

// Header Image Size
add_filter( 'beans_edit_post_image_args', 'example_post_image_edit_args' );

function example_post_image_edit_args( $args ) {

    return array_merge( $args, array(
        'resize' => array( 753, true ),
    ) );

}

// Remove Footer Tags
beans_remove_action('beans_post_meta_categories');
beans_remove_action('beans_post_meta_tags');

// Author Bio
beans_add_action ( 'author_bio','beans_post_append_markup','add_author_bio');
function add_author_bio() { ?>
                <div class="author-bio uk-block">
                    <div class="uk-align-left">
                        <?php echo get_avatar( get_the_author_meta( 'user_email' ), 96 ); ?>
                    </div>
                    <div class="uk-text-large uk-text-bold">By
                        <?php the_author_posts_link(); ?>
                    </div>
                    <p>
                        <?php the_author_meta( 'description' ); ?>
                    </p>
                </div>
                <?php
}

// FB Comments
beans_add_action( 'fb_comments', 'beans_post_append_markup', 'add_fb_comments' );
function add_fb_comments() { ?>
<div class="fb-comments-box uk-block">
                        <h3>Comments</h3>
                        <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-width="100%"></div>
                    </div>
                    <?php }

// Related Posts
beans_add_action ( 'post_related_content','beans_post_append_markup','add_related_content' );
function add_related_content() {
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args=array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page'=>3, // Number of related posts that will be shown.
            'ignore_sticky_posts'=>1,
            'orderby'=>'rand'
        );
        $my_query = new wp_query( $args );
        if( $my_query->have_posts() ) {
            echo '<div class="uk-block uk-padding-bottom-remove related-posts"><h3>Next on To Save a Life</h3><ul class="uk-grid">';
            while( $my_query->have_posts() ) {
                $my_query->the_post(); ?>
                        <li class="uk-width-small-1-3">
                            <div class="relatedthumb">
                                <a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
                                    <?php the_post_thumbnail(); ?>
                                </a>
                            </div>
                            <div class="relatedcontent">
                                <h3><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                        </li>
                        <? }
            echo '</ul></div>';
        }
    }
    $post = $orig_post;
    wp_reset_query();
}

// Load Beans document.
beans_load_document();
