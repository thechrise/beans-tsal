<?php
/*-----------------------------------------------------------------------------------*/
/*	Helpers and utils functions for theme use
/*-----------------------------------------------------------------------------------*/

/* Custom function to limit post content words */
if (!function_exists('bench_get_excerpt')):
    function bench_get_excerpt($content)
    {
        $excerpt = '';
        if (has_excerpt()) {
            $excerpt = get_the_excerpt();
        } else {
            $excerpt = strip_tags($content);
            if (!empty($excerpt)) {
                $excerpt = strtok($excerpt, "\n"); //first para

								if(strlen($excerpt) > 75) {
									  $excerpt = preg_replace('/\s+?(\S+)?$/', '', substr($excerpt, 0, 76)) . '…';
								}
            }
        }
        return $excerpt;
    }
endif;

/* Placeholder div */
if (!function_exists('bench_placeholder_img')):
    function bench_placeholder_img()
    {
        $image = '<span class="tm-placeholder-img uk-float-left uk-margin-right"><i class="uk-icon-circle-thin uk-icon-large"></i></span>';
        $name = beans_output( 'beans_site_title_text', get_bloginfo( 'name' ) );
        if ( $logo = get_theme_mod( 'beans_logo_image', false ) )
      		$image = beans_selfclose_markup( 'beans_post_logo_image', 'img', array(
      			'class' => 'tm-post-widget-img uk-border-rounded uk-float-left',
      			'src' => esc_url( $logo ),
      			'alt' => esc_attr( $name ),
      		) );
        return $image;
    }
endif;

/* Custom function to get meta data for specific layout */
if (!function_exists('bench_get_meta_data')):
    function bench_get_meta_data($force_meta = false)
    {
        $output = '';
        //Check for sticky
        if (is_sticky()) {
            $output = $output .= '<div class="meta-item"><i class="fa fa-thumb-tack"></i>' . __('Sticky', 'bench') . '</div>';
        }
        //Check meta options
        if (!$force_meta) {
            if (is_single()) {
                $metas = bench_get_option('single_meta');
            } else {
                $metas = bench_get_option('meta');
            }
        } else {
            $metas = array(
                $force_meta
            );
        }
        if (!empty($metas)) {
            foreach ($metas as $meta_id) {
                $meta = '';
                switch ($meta_id) {
                    case 'date':
                        $meta = '<i class="fa fa-calendar"></i><span class="updated">' . get_the_date() . '</span>';
                        break;
                    case 'author':
                        $author_id = get_post_field('post_author', get_the_ID());
                        $meta      = '<i class="fa fa-user"></i><span class="vcard author"><span class="fn">' . __('by', 'bench') . ' <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID', $author_id))) . '">' . get_the_author_meta('display_name', $author_id) . '</a></span></span>';
                        break;
                    case 'rtime':
                        $meta = bench_read_time(get_post_field('post_content', get_the_ID()));
                        if (!empty($meta)) {
                            $meta = '<i class="fa fa-clock-o"></i>' . $meta . ' ' . __('min read', 'bench');
                        }
                        break;
                    case 'comments':
                        if (comments_open() || get_comments_number()) {
                            ob_start();
                            comments_popup_link(__('Add Comment', 'bench'), __('1 Comment', 'bench'), __('% Comments', 'bench'));
                            $meta = '<i class="fa fa-comments-o"></i>' . ob_get_contents();
                            ob_end_clean();
                        } else {
                            $meta = '';
                        }
                        break;
                    default:
                        break;
                }
                if (!empty($meta)) {
                    $output .= '<div class="meta-item">' . $meta . '</div>';
                }
            }
        }
        return $output;
    }
endif;


/* 	Calculate reading time by content length */
if ( !function_exists( 'bench_read_time' ) ):
	function bench_read_time( $text ) {
		$words = str_word_count( strip_tags( $text ) );
		if ( !empty( $words ) ) {
			$time_in_minutes = ceil( $words / 200 );
			return $time_in_minutes;
		}
		return false;
	}
endif;

/* Top element for scroll */
function bench_top_element() { ?>
		<div id="top"></div>
            <?php
}

/* Site toolbar for scrolling to top and to show share buttons */
function bench_site_toolbar() { ?>
  <div id="tm-toolbar" class="uk-visible-large" style="display:none;">
    <div class="back-to-top"><a href="#top" title="Click to go back to top" data-uk-smooth-scroll><i class="uk-icon-arrow-up"></i></a></div>
</div>
<?php
}
