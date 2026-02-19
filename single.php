<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package gate39media
 */
get_header();
// Check if the blog page has a featured image
if ( has_post_thumbnail() ) {
  // Get the featured image URL
  $thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'full' ); // You can specify a different image size if needed
} else {
  $thumbnail_url = get_template_directory_uri() . '/public/img/img-article-default.png';
}

$cats     = get_the_category( $post->ID );
$cat_name = ( ! empty( $cats ) && ! empty( $cats[0] ) ) ? $cats[0]->name : '';

$month = get_the_date( 'F', $post->ID );
$day   = get_the_date( 'd', $post->ID );
?>
  <style>
		.single-blog-post {
			--side: max(32px, calc((100vw - 1236px) / 2));
		}
		.single-blog-post-img {
			position: absolute;
			inset: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
		.single-blog-post-img-overlay {
			position: absolute;
			inset: 0;
			background-image: linear-gradient(135deg, #1E3348 0%, rgba(30, 51, 72, 0) 100%);
		}
		.single-blog-first-column {
			padding-left: var(--side);
			border-right: 1px solid var(--cogcpa-dark-blue);
			width: calc(50% + 265px) !important;
			flex: none !important;
		}
		.single-blog-second-column {
		}
		@media screen and (max-width: 991px) {
			.single-blog-first-column,
			.single-blog-second-column {
				width: 100% !important;
			}
			.single-blog-first-column {
				padding-inline: 32px;
				border-right: 0;
			}
		}
		@media screen and (max-width: 479px) {
		}
  </style>
  <section class="section">
    <div
      class="site-padding py-[60px] relative z-1 min-h-[634px] flex flex-row items-center max-[768px]:py-[112px] max-[768px]:min-h-auto!">
      <div class="max-w-[1236px] w-full mx-auto">
        <div class="max-w-[622px]! max-[768px]:max-w-full!">
          <div class="group text-white" data-post-id="<?= esc_attr( $post->ID ); ?>">
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
            <h3 class="font-normal! text-[50px]! leading-[normal]! max-[768px]:text-[36px]!">
              <?= get_the_title( $post->ID ); ?>
            </h3>
            <div class="mb-[22px]"></div>
            <div class="font-light! text-lg! max-[768px]:text-sm!" text-limit="2">
              <?= esc_html( wp_trim_words( get_the_excerpt( $post->ID ), 20 ) ); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <img src="<?= esc_url( $thumbnail_url ); ?>" class="single-blog-post-img" alt="single-blog-post-featured-image">
    <div class="single-blog-post-img-overlay"></div>
  </section>
  <div class="single-blog-post" style="background-color: white">
    <div class="flex justify-between">
      <div class="single-blog-first-column">
        <div class="flex gap-[28px] items-center">
          <a href="/insights" class="flex gap-[12px] items-center text-inherit! text-reg font-semibold tracking-[1.28px]">
            <div class="flex">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="15" viewBox="0 0 17 15" fill="none">
                <path d="M0.23406 8.00465C-0.0780185 7.64472 -0.0780184 7.06271 0.234061 6.70661L5.81164 0.269968C6.12372 -0.0899628 6.62836 -0.0899628 6.93712 0.269968C7.24588 0.629899 7.2492 1.21192 6.93712 1.56802L2.72073 6.43474L16.2032 6.43475C16.6448 6.43475 17 6.84445 17 7.35372C17 7.86298 16.6448 8.27269 16.2032 8.27269L2.72073 8.27269L6.94044 13.1356C7.25252 13.4955 7.25251 14.0775 6.94044 14.4336C6.62836 14.7897 6.12372 14.7936 5.81496 14.4336L0.23406 8.00465Z" fill="#017BB1"/>
              </svg>
            </div>
            <div class="">BACK</div>
          </a>
          <div>
            <?= do_shortcode('[social_linkedin_sharing]') ?>
          </div>
        </div>
        <?php
        the_content(); ?>
      </div>
      <div class="single-blog-second-column">

      </div>
    </div>
  </div>
<?php
get_footer();