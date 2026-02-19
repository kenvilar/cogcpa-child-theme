<?php

/**
 * Blog Cards (latest three posts)
 * Usage: [cogcpa_blog_cards_three_blogs_only]
 */
function cogcpamedia_render_blog_card_three_blogs( $post_id, $image_size = 'large' ) {
  $img_html = '';
  if ( has_post_thumbnail( $post_id ) ) {
    $img_html = get_the_post_thumbnail( $post_id, $image_size, array(
      'class'   => 'cogcpa-blog-cards__image',
      'loading' => 'lazy',
    ) );
  }

  $cats = get_the_category( $post_id );

  $month = get_the_date( 'F', $post_id );
  $day   = get_the_date( 'd', $post_id );

  ob_start();
  ?>
  <a href="<?= esc_url( get_permalink( $post_id ) ); ?>"
     class="cogcpa-blog-card group"
     data-post-id="<?= esc_attr( $post_id ); ?>">
    <div class="cogcpa-blog-card__thumb"><?= $img_html; ?></div>
    <div class="cogcpa-blog-card__meta">
        <span class="cogcpa-blog-card__date">
          <span class="cogcpa-blog-card__month"><?= esc_html( $month ); ?></span>
          <span class="cogcpa-blog-card__day"><?= esc_html( $day ); ?></span>
        </span>
      |
      <?php
      if ( ! empty( $cats ) ) :
        $cat_names = wp_list_pluck( $cats, 'name' ); ?>
        <span class="cogcpa-blog-card__category"><?= esc_html( implode( ', ', $cat_names ) ); ?></span>
      <?php
      endif; ?>
    </div>
    <h3 class="cogcpa-blog-card__title"><?= esc_html( get_the_title( $post_id ) ); ?></h3>
    <div class="cogcpa-blog-card__excerpt" text-limit="6">
      <?= esc_html( wp_trim_words( get_the_excerpt( $post_id ), 20 ) ); ?></div>
    <div class="cogcpa-blog-card__more">
      <div>Read More</div>
      <div class="transition-all group-hover:translate-x-[2px]" style="display: flex">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="15" viewBox="0 0 17 15" fill="none">
          <path
            d="M16.7659 6.69749C17.078 7.05742 17.078 7.63944 16.7659 7.99554L11.1884 14.4322C10.8763 14.7921 10.3716 14.7921 10.0629 14.4322C9.75413 14.0723 9.75081 13.4902 10.0629 13.1341L14.2793 8.26741H0.796797C0.355238 8.26741 0 7.8577 0 7.34843C0 6.83917 0.355238 6.42946 0.796797 6.42946H14.2793L10.0596 1.56656C9.74749 1.20663 9.74749 0.624616 10.0596 0.268514C10.3716 -0.0875877 10.8763 -0.0914167 11.185 0.268514L16.7659 6.69749Z"
            fill="#017BB1"/>
        </svg>
      </div>
    </div>
  </a>
  <?php

  return ob_get_clean();
}

function cogcpamedia_blog_cards_shortcode_three_blogs( $atts ) {
  // Always show exactly the latest three blog posts
  $atts = shortcode_atts(
    array(
      'image_size' => 'large',
    ),
    $atts,
    'cogcpa_blog_cards_three_blogs_only'
  );

  $q = new WP_Query( array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => 1,
  ) );

  $posts_to_render = $q->have_posts() ? $q->posts : array();

  ob_start();
  ?>
  <style>
		.single-blog-cogcpa-blog-cards__grid {
			display: flex;
			flex-direction: column;
			.cogcpa-blog-card {
				padding-block: 40px;
				padding-left: 40px;
				padding-right: var(--side);
				color: var(--cogcpa-dark-blue);
				&:not(:last-child) {
					border-bottom: 1px solid var(--cogcpa-dark-blue);
				}
        &:last-child {
          padding-bottom: 20px;
        }
				&:hover {
					background: var(--cogcpa-light-grey) !important;
				}
				.cogcpa-blog-card__thumb {
					width: 100%;
					height: 176px;
					margin-bottom: 29px;
					background: var(--cogcpa-dark-blue);
				}
				.cogcpa-blog-card__thumb img {
					width: 100%;
					height: 100%;
					object-fit: cover;
				}
				.cogcpa-blog-card__meta {
					font-size: 11.97px;
					line-height: normal;
					font-weight: 400;
					color: var(--cogcpa-blue);
					margin-bottom: 14px;
				}
				.cogcpa-blog-card__title {
					font-weight: 400;
					font-size: 17px;
					line-height: normal;
					margin-bottom: 17px;
				}
				.cogcpa-blog-card__excerpt {
					font-weight: 300;
					font-size: 13.68px;
					line-height: normal;
					margin-bottom: 36px;
				}
				.cogcpa-blog-card__more {
					display: flex;
					align-items: center;
					gap: 9px;
					font-weight: 600;
					font-size: 13.68px;
					letter-spacing: 1.28px;
					text-transform: uppercase;
				}
			}
		}
    @media screen and (max-width: 767px) {
      .single-blog-first-column, .cogcpa-blog-card {
        padding-inline: 20px !important;
      }
    }
  </style>
  <div class="single-blog-cogcpa-blog-cards">
    <div class="single-blog-cogcpa-blog-cards__grid">
      <?php
      foreach ( $posts_to_render as $post_obj ) {
        echo cogcpamedia_render_blog_card_three_blogs( $post_obj->ID, $atts['image_size'] );
      }
      ?>
    </div>
    <div class="pt-[20px] px-[40px] max-[768px]:px-[20px] btn_primary">
      <a href="/insights" class="inline-block">Explore More</a>
    </div>
  </div>
  <?php

  wp_reset_postdata();

  return ob_get_clean();
}

add_shortcode( 'cogcpa_blog_cards_three_blogs_only', 'cogcpamedia_blog_cards_shortcode_three_blogs' );
