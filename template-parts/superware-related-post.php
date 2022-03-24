<?php
    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );

    if(!empty($categories) && !is_wp_error($categories)):
        foreach ($categories as $category):
            array_push($cat_ids, $category->term_id);
        endforeach;
    endif;

    $current_post_type = get_post_type($post_id);

    $query_args = array( 
        'category__in'   => $cat_ids,
        'post_type'      => $current_post_type,
        'post__not_in'    => array($post_id),
        'posts_per_page'  => '3',
     );

    $related_cats_post = new WP_Query( $query_args );

    if($related_cats_post->have_posts()):
?>

<!-- Begin Related
================================================== -->
<div class="graybg">
    <div class="container">
        <div class="section-title">
            <h2>
                <span>
                    <?php _e("Related Posts -", "superware"); ?>
                </span>
            </h2>
        </div>
        <div class="row listrecent listrelated">
            <?php
                while($related_cats_post->have_posts()):
                    $related_cats_post->the_post();
            ?>
            <!-- begin post -->
            <div class="col-md-4">
                <div <?php post_class( array('card')); ?>>
                    <?php
                        if(has_post_thumbnail()) :
                    ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php
                            the_post_thumbnail('large', array('class'=>'img-fluid img-thumb'));
                        ?>
                    </a>
                    <?php
                        endif;
                    ?>
                    <div class="card-block">
                        <h2 class="card-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                    the_title();
                                ?>
                            </a>
                        </h2>
                        <div class="metafooter">
                            <div class="wrapfooter">
                                <span class="meta-footer-thumb">
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ); ?>">
                                        <img class="author-thumb" src="<?php echo esc_url(get_avatar_url(get_the_author_meta("ID"))); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                </span>
                                <span class="author-meta">
                                    <span class="post-name">
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ); ?>">
                                            <?php
                                                echo esc_html(get_the_author_meta("display_name"));
                                            ?>
                                        </a>
                                    </span>
                                    <br />
                                    <span class="post-date">
                                        <?php
                                            echo get_the_date();
                                        ?>
                                    </span>
                                    <span class="dot"></span>
                                    <a href="<?php echo esc_url(get_category_link($category)); ?>">
                                        <span class="post-read">
                                            <?php
                                                echo esc_html( wp_trim_words( $category->name, 1 ) );
                                            ?>
                                        </span>
                                    </a>
                                </span>
                                <span class="post-read-more">
                                    <a href="<?php the_permalink() ?>">
                                        <svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25">
                                            <path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end post -->
            <?php
                endwhile;
            ?>
        </div>
    </div>
</div>
<!-- End Related Posts
================================================== -->
<?php
    endif;
    wp_reset_postdata();
?>