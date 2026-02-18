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
            <h3
              class="font-normal! text-[50px]! leading-[normal]! max-[768px]:text-[36px]!"><?= esc_html( get_the_title( $post->ID ) ); ?></h3>
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
    <?php
    the_content(); ?>
  </div>
<?php
get_footer();