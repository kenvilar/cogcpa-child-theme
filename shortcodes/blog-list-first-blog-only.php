<?php

/**
 * Single latest blog card.
 * Usage: [cogcpa_blog_first_blog_latest]
 */
function cogcpamedia_render_blog_card_first_blog( $post_id, $image_size = 'large' ) {
  $img_html = '';
  if ( has_post_thumbnail( $post_id ) ) {
    $img_html = get_the_post_thumbnail( $post_id, $image_size, array(
      'class'   => 'cogcpa-blog-cards__image',
      'loading' => 'lazy',
    ) );
  }

  $cats     = get_the_category( $post_id );
  $cat_name = ( ! empty( $cats ) && ! empty( $cats[0] ) ) ? $cats[0]->name : '';

  $month = get_the_date( 'F', $post_id );
  $day   = get_the_date( 'd', $post_id );

  ob_start();
  ?>
  <div class="site-padding py-[60px] relative z-1 min-h-[634px] flex flex-row items-center max-[768px]:py-[112px] max-[768px]:min-h-auto!">
    <div class="max-w-[1236px] w-full mx-auto">
      <div class="max-w-[622px]! max-[768px]:max-w-full!">
        <div class="group text-white" data-post-id="<?= esc_attr( $post_id ); ?>">
          <!--<div class="cogcpa-blog-card__thumb"><?php /*= $img_html; */?></div>-->
          <div class="font-normal text-[20px] leading-[normal] max-[768px]:text-[16px]">
        <span class="">
          <span class=""><?= esc_html( $month ); ?></span>
          <span class=""><?= esc_html( $day ); ?></span>
        </span>
            |
            <?php
            if ( ! empty( $cats ) ) :
              $cat_names = wp_list_pluck( $cats, 'name' ); ?>
              <span class=""><?= esc_html( implode( ', ', $cat_names ) ); ?></span>
            <?php
            endif; ?>
          </div>
          <div class="mb-[17px]"></div>
          <h3 class="font-normal! text-[50px]! leading-[normal]! max-[768px]:text-[36px]!"><?= esc_html( get_the_title( $post_id ) ); ?></h3>
          <div class="mb-[22px]"></div>
          <div class="font-light! text-lg! max-[768px]:text-sm!" text-limit="2">
            <?= esc_html( wp_trim_words( get_the_excerpt( $post_id ), 20 ) ); ?>
          </div>
          <div class="mb-[35px]"></div>
          <div class="btn_primary">
            <a href="<?= esc_url( get_permalink( $post_id ) ); ?>" class="">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <img class="absolute! inset-0! w-full! h-full! object-cover" src="<?= esc_url( get_the_post_thumbnail_url( $post_id, 'full' ) ) ?>" alt="latest-blog">
  <div class="absolute! inset-0! bg-[linear-gradient(135deg,_#1E3348_0%,_rgba(30,51,72,0)_100%)]"></div>
  <?php

  return ob_get_clean();
}

function cogcpamedia_blog_cards_first_blog_shortcode( $atts ) {
  $atts = shortcode_atts(
    array(
      'image_size' => 'large',
    ),
    $atts,
    'cogcpa_blog_first_blog_latest'
  );

  $q = new WP_Query( array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'posts_per_page'      => 1,
    'ignore_sticky_posts' => 1,
  ) );

  $posts_to_render = $q->have_posts() ? $q->posts : array();

  ob_start();
  ?>
  <div class="">
    <div class="">
      <?php
      foreach ( $posts_to_render as $post_obj ) {
        echo cogcpamedia_render_blog_card_first_blog( $post_obj->ID, $atts['image_size'] );
      }
      ?>
    </div>
  </div>
  <?php

  wp_reset_postdata();

  return ob_get_clean();
}

add_shortcode( 'cogcpa_blog_first_blog_latest', 'cogcpamedia_blog_cards_first_blog_shortcode' );
