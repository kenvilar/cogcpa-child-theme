<?php

/**
 * Blog Cards (with category filter, search, and load more)
 * Usage: [cogcpa_blog_cards]
 *
 * Optional params (if you want different counts):
 * [cogcpa_blog_cards initial="12" more="6"]
 */
function cogcpamedia_render_blog_card( $post_id, $image_size = 'large' ) {
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

function cogcpamedia_blog_cards_shortcode( $atts ) {
  $atts = shortcode_atts(
    array(
      'initial'    => 12,
      'more'       => 6,
      'image_size' => 'large',
    ),
    $atts,
    'cogcpa_blog_cards'
  );

  $initial = max( 1, intval( $atts['initial'] ) );
  $more    = max( 1, intval( $atts['more'] ) );

  // Get latest post ID (to exclude from the cards list)
  $latest    = get_posts( array(
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'orderby'        => 'date',
    'order'          => 'DESC',
  ) );
  $latest_id = ! empty( $latest ) ? intval( $latest[0] ) : 0;

  // Categories for filter UI
  $categories = get_categories( array(
    'taxonomy'   => 'category',
    'hide_empty' => true,
  ) );

  // Initial query (show first 12 cards, excluding the latest post)
  $args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'posts_per_page'      => $initial + 1, // +1 to detect "has more"
    'offset'              => 0,            // already exclude latest via post__not_in
    'ignore_sticky_posts' => 1,
  );
  if ( $latest_id ) {
    $args['post__not_in'] = array( $latest_id );
  }

  $q = new WP_Query( $args );

  $posts_to_render = array();
  $has_more        = false;

  if ( $q->have_posts() ) {
    foreach ( $q->posts as $p ) {
      $posts_to_render[] = $p;
    }
    if ( count( $posts_to_render ) > $initial ) {
      $has_more        = true;
      $posts_to_render = array_slice( $posts_to_render, 0, $initial );
    }
  }

  $nonce = wp_create_nonce( 'cogcpa_blog_cards_nonce' );

  ob_start();
  ?>
  <style>
		.cogcpa-blog-cards__controls {
			border-bottom: 1px solid var(--cogcpa-dark-blue);
			.cogcpa-blog-cards__categories {
				display: flex;
				gap: 50px;
			}
			.cogcpa-blog-cards__cat.is-active {
				opacity: 1;
				color: var(--cogcpa-blue);
			}
			.cogcpa-blog-cards__cat {
				background: transparent;
				border: 0 solid transparent;
				font-weight: 600;
				font-size: 16px;
				line-height: normal;
				letter-spacing: 1.28px;
				color: var(--cogcpa-dark-blue);
				opacity: 0.25;
				padding-inline: 0;
				text-transform: uppercase;
				&[data-cat='1'] {
					display: none;
				}
			}
			input.cogcpa-blog-cards__search-input {
				width: 100%;
				border: 1px solid transparent;
				border-bottom: 1px solid color-mix(in oklab, var(--cogcpa-dark-blue) 25%, transparent);
				padding-bottom: 6px;
				font-size: 16px;
				line-height: normal;
				outline: none;
				&::placeholder {
					font-size: 16px;
					font-weight: 600;
					letter-spacing: 1.28px;
					opacity: 0.25;
				}
			}
		}
		.cogcpa-blog-cards__grid {
			--side: max(32px, calc((100vw - 1236px) / 2));
			display: grid;
			grid-template-columns: repeat(3, minmax(0, 1fr));
			padding-left: var(--side);
			padding-right: var(--side);
			.cogcpa-blog-card {
				padding-block: 40px;
				color: var(--cogcpa-dark-blue);
				border-bottom: 1px solid var(--cogcpa-dark-blue);
				&:hover {
					background: var(--cogcpa-light-grey) !important;
				}
				/* 1st column (1,4,7,...) full-bleed to the left */
				&:nth-child(3n + 1) {
					margin-left: calc(var(--side) * -1);
					padding-left: var(--side);
					padding-right: 34px;
					border-right: 1px solid var(--cogcpa-dark-blue);
				}
				&:nth-child(3n + 2) {
					padding-inline: 30px;
					border-right: 1px solid var(--cogcpa-dark-blue);
				}
				/* 3rd column (3,6,9,...) full-bleed to the right */
				&:nth-child(3n + 3) {
					margin-right: calc(var(--side) * -1);
					padding-left: 34px;
					padding-right: var(--side);
				}
				.cogcpa-blog-card__thumb {
					width: 100%;
					height: 206px;
					margin-bottom: 29px;
					background: var(--cogcpa-dark-blue);
				}
				.cogcpa-blog-card__thumb img {
					width: 100%;
					height: 100%;
					object-fit: cover;
				}
				.cogcpa-blog-card__meta {
					font-size: 14px;
					line-height: normal;
					font-weight: 400;
					color: var(--cogcpa-blue);
					margin-bottom: 16px;
				}
				.cogcpa-blog-card__title {
					font-weight: 400;
					font-size: 20px;
					line-height: normal;
					margin-bottom: 22px;
				}
				.cogcpa-blog-card__excerpt {
					font-weight: 300;
					font-size: 16px;
					line-height: normal;
					margin-bottom: 42px;
				}
				.cogcpa-blog-card__more {
					display: flex;
					align-items: center;
					gap: 12px;
					font-weight: 600;
					font-size: 16px;
					letter-spacing: 1.28px;
					text-transform: uppercase;
				}
			}
		}
		.cogcpa-blog-cards__footer {
			display: flex;
			justify-content: center;
			padding-top: 40px;
		}
		@media screen and (max-width: 767px) {
			.cogcpa-blog-cards__controls {
				.cogcpa-blog-cards__categories {
					flex-wrap: wrap;
					gap: 20px;
					justify-content: center;
				}
			}
			.cogcpa-blog-cards__grid {
				display: flex;
				flex-direction: column;
				padding-inline: 0;
				.cogcpa-blog-card {
					padding-inline: 32px;
					&:nth-child(3n + 1) {
						margin-inline: 0;
						border-right: 0;
					}
					&:nth-child(3n + 2) {
						border-right: 0;
					}
					&:nth-child(3n + 3) {
						margin-inline: 0;
					}
				}
			}
		}
		@media screen and (max-width: 479px) {
			.cogcpa-blog-cards__grid {
				.cogcpa-blog-card {
					padding-block: 20px;
				}
			}
		}
  </style>
  <div
    class="cogcpa-blog-cards"
    data-ajaxurl="<?php
    echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
    data-nonce="<?php
    echo esc_attr( $nonce ); ?>"
    data-initial="<?php
    echo esc_attr( $initial ); ?>"
    data-more="<?php
    echo esc_attr( $more ); ?>"
    data-loaded="<?php
    echo esc_attr( count( $posts_to_render ) ); ?>"
  >
    <div class="cogcpa-blog-cards__controls site-padding pt-[21px] pb-[14px]">
      <div class="max-w-[1236px] mx-auto">
        <div class="flex items-center justify-between gap-[20px] max-[992px]:flex-col">
          <div class="cogcpa-blog-cards__categories">
            <button type="button" class="cogcpa-blog-cards__cat is-active" data-cat="0">All</button>
            <?php
            foreach ( $categories as $cat ) : ?>
              <button type="button"
                      class="cogcpa-blog-cards__cat"
                      data-cat="<?php
                      echo esc_attr( intval( $cat->term_id ) ); ?>"
              >
                <?php
                echo esc_html( $cat->name ); ?>
              </button>
            <?php
            endforeach; ?>
          </div>
          <div class="cogcpa-blog-cards__search max-w-[366px] w-full">
            <input type="text" class="cogcpa-blog-cards__search-input" placeholder="Search..."/>
          </div>
        </div>
      </div>
    </div>
    <div class="cogcpa-blog-cards__grid">
      <?php
      foreach ( $posts_to_render as $post_obj ) {
        echo cogcpamedia_render_blog_card( $post_obj->ID, $atts['image_size'] );
      }
      ?>
    </div>
    <div class="cogcpa-blog-cards__footer">
      <div class="btn_primary">
        <button type="button" class="cogcpa-blog-cards__more-btn" <?php
        echo $has_more ? '' : 'style="display:none"'; ?>>
          More
        </button>
      </div>
    </div>
  </div>
  <script type="text/javascript">
		(function ($) {
			function debounce(fn, wait) {
				var t;
				return function () {
					var ctx = this, args = arguments;
					clearTimeout(t);
					t = setTimeout(function () {
						fn.apply(ctx, args);
					}, wait);
				};
			}

			function requestCards($wrap, opts) {
				var ajaxurl = $wrap.data('ajaxurl');
				var nonce = $wrap.data('nonce');

				var data = {
					action: 'cogcpamedia_load_more_blog_cards',
					nonce: nonce,
					loaded: opts.loaded || 0,
					per_page: opts.per_page,
					cat: opts.cat || 0,
					s: opts.s || ''
				};

				$wrap.addClass('is-loading');

				return $.post(ajaxurl, data)
					.done(function (resp) {
						if (!resp || !resp.success || !resp.data) return;

						if (opts.replace) {
							$wrap.find('.cogcpa-blog-cards__grid').html(resp.data.html);
							$wrap.data('loaded', resp.data.loaded);
						} else {
							$wrap.find('.cogcpa-blog-cards__grid').append(resp.data.html);
							$wrap.data('loaded', resp.data.loaded_total);
						}

						if (resp.data.has_more) {
							$wrap.find('.cogcpa-blog-cards__more-btn').show();
						} else {
							$wrap.find('.cogcpa-blog-cards__more-btn').hide();
						}
					})
					.always(function () {
						$wrap.removeClass('is-loading');
					});
			}

			$(document).on('click', '.cogcpa-blog-cards__cat', function () {
				var $btn = $(this);
				var $wrap = $btn.closest('.cogcpa-blog-cards');

				$wrap.find('.cogcpa-blog-cards__cat').removeClass('is-active');
				$btn.addClass('is-active');

				var initial = parseInt($wrap.data('initial'), 10) || 12;
				var cat = parseInt($btn.data('cat'), 10) || 0;
				var s = $wrap.find('.cogcpa-blog-cards__search-input').val() || '';

				requestCards($wrap, {
					replace: true,
					loaded: 0,
					per_page: initial,
					cat: cat,
					s: s
				});
			});

			$(document).on('input', '.cogcpa-blog-cards__search-input', debounce(function () {
				var $input = $(this);
				var $wrap = $input.closest('.cogcpa-blog-cards');

				var initial = parseInt($wrap.data('initial'), 10) || 12;
				var $active = $wrap.find('.cogcpa-blog-cards__cat.is-active');
				var cat = $active.length ? (parseInt($active.data('cat'), 10) || 0) : 0;
				var s = $input.val() || '';

				requestCards($wrap, {
					replace: true,
					loaded: 0,
					per_page: initial,
					cat: cat,
					s: s
				});
			}, 300));

			$(document).on('click', '.cogcpa-blog-cards__more-btn', function () {
				var $btn = $(this);
				var $wrap = $btn.closest('.cogcpa-blog-cards');

				var more = parseInt($wrap.data('more'), 10) || 6;
				var loaded = parseInt($wrap.data('loaded'), 10) || 0;

				var $active = $wrap.find('.cogcpa-blog-cards__cat.is-active');
				var cat = $active.length ? (parseInt($active.data('cat'), 10) || 0) : 0;
				var s = $wrap.find('.cogcpa-blog-cards__search-input').val() || '';

				requestCards($wrap, {
					replace: false,
					loaded: loaded,
					per_page: more,
					cat: cat,
					s: s
				});
			});

		})(jQuery);
  </script>
  <?php

  wp_reset_postdata();

  return ob_get_clean();
}

add_shortcode( 'cogcpa_blog_cards', 'cogcpamedia_blog_cards_shortcode' );

/**
 * AJAX: load more / filter / search blog cards
 */
function cogcpamedia_ajax_load_more_blog_cards() {
  if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'cogcpa_blog_cards_nonce' ) ) {
    wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
  }

  $loaded   = isset( $_POST['loaded'] ) ? max( 0, intval( $_POST['loaded'] ) ) : 0;
  $per_page = isset( $_POST['per_page'] ) ? max( 1, intval( $_POST['per_page'] ) ) : 6;
  $cat      = isset( $_POST['cat'] ) ? intval( $_POST['cat'] ) : 0;
  $s        = isset( $_POST['s'] ) ? sanitize_text_field( $_POST['s'] ) : '';

  // Latest post ID (exclude always)
  $latest    = get_posts( array(
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'orderby'        => 'date',
    'order'          => 'DESC',
  ) );
  $latest_id = ! empty( $latest ) ? intval( $latest[0] ) : 0;

  $args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'orderby'             => 'date',
    'order'               => 'DESC',
    'posts_per_page'      => $per_page + 1,        // +1 to detect "has more"
    'offset'              => $loaded,              // already exclude latest via post__not_in
    'ignore_sticky_posts' => 1,
  );

  if ( $latest_id ) {
    $args['post__not_in'] = array( $latest_id );
  }
  if ( $cat > 0 ) {
    $args['cat'] = $cat;
  }
  if ( ! empty( $s ) ) {
    $args['s'] = $s;
  }

  $q = new WP_Query( $args );

  $posts_to_render = array();
  $has_more        = false;

  if ( $q->have_posts() ) {
    $posts_to_render = $q->posts;
    if ( count( $posts_to_render ) > $per_page ) {
      $has_more        = true;
      $posts_to_render = array_slice( $posts_to_render, 0, $per_page );
    }
  }

  ob_start();
  foreach ( $posts_to_render as $post_obj ) {
    echo cogcpamedia_render_blog_card( $post_obj->ID );
  }
  $html = ob_get_clean();

  wp_reset_postdata();

  wp_send_json_success( array(
    'html'         => $html,
    'loaded'       => count( $posts_to_render ),
    'loaded_total' => $loaded + count( $posts_to_render ),
    'has_more'     => $has_more,
  ) );
}

add_action( 'wp_ajax_cogcpamedia_load_more_blog_cards', 'cogcpamedia_ajax_load_more_blog_cards' );
add_action( 'wp_ajax_nopriv_cogcpamedia_load_more_blog_cards', 'cogcpamedia_ajax_load_more_blog_cards' );
