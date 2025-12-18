<?php

if ( ! function_exists( 'industry_news_shortcode' ) ) {
	function industry_news_shortcode( $atts = [], $content = null ) {
		ob_start();

		?>
      <div class="grid grid-cols-[1070fr_370fr] divide-x divide-darkblue md:grid-cols-1 md:divide-y md:divide-darkblue">
        <div class="flex flex-col w-full divide-y divide-darkblue">
            <?php
            $args = array(
	            'post_type'      => 'post',
	            'posts_per_page' => 2,
            );
            $posts = new WP_Query( $args );
            if ( $posts->have_posts() ) {
	            while ( $posts->have_posts() ) {
		            $posts->the_post();
		            ?>
                <a href="<?php the_permalink(); ?>"
                   class="text-inherit! h-full block py-[27px] pr-[20px] pl-[max(1.5rem,calc((100vw-1236px)/2))] bg-white transition-colors hover:bg-lightgrey!">
                  <div class="max-w-[940px] w-full md:max-w-full">
                    <div class="flex flex-row items-center gap-[27px] max-[768px]:flex-col!">
                      <div class="max-w-[320px] w-full md:max-w-full max-[768px]:order-2">
                        <h3 class="text-xl font-normal"><?php the_title(); ?></h3>
                        <div class="mb-[22px]"></div>
                        <p class="font-light">
	                        <?php echo get_the_excerpt(); ?>
                        </p>
                        <div class="mb-[30px]"></div>
                        <div class="flex items-center gap-[12px]">
                          <p class="font-semibold m-0">READ MORE</p>
                          <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M16.7659 6.69749C17.078 7.05742 17.078 7.63944 16.7659 7.99554L11.1884 14.4322C10.8763 14.7921 10.3716 14.7921 10.0629 14.4322C9.75413 14.0723 9.75081 13.4902 10.0629 13.1341L14.2793 8.26741H0.796797C0.355238 8.26741 0 7.8577 0 7.34843C0 6.83917 0.355238 6.42946 0.796797 6.42946H14.2793L10.0596 1.56656C9.74749 1.20663 9.74749 0.624616 10.0596 0.268514C10.3716 -0.0875877 10.8763 -0.0914167 11.185 0.268514L16.7659 6.69749Z"
                              fill="#1E3348"/>
                          </svg>
                        </div>
                      </div>
                      <div class="max-w-[593px] w-full md:max-w-full">
                        <?php if ( has_post_thumbnail() ) : ?>
                        <img class="w-full h-full object-cover" src="<?php the_post_thumbnail_url('full'); ?>" alt="featured image">
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </a>
		            <?php
	            }
	            wp_reset_postdata();
            }
            ?>
        </div>
        <div class="flex flex-col w-full divide-y divide-darkblue">
          <a href=""
             class="text-inherit! block py-[27px] pl-[27px] pr-[max(1.5rem,calc((100vw-1236px)/2))] bg-white transition-colors hover:bg-lightgrey!">
            <div class="max-w-[317px] ml-auto w-full md:max-w-full md:ml-0">
              <h3 class="text-xl font-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
              <div class="mb-[10px]"></div>
              <p class="font-light m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut ...
              </p>
            </div>
          </a>
          <a href=""
             class="text-inherit! block py-[27px] pl-[27px] pr-[max(1.5rem,calc((100vw-1236px)/2))] bg-white transition-colors hover:bg-lightgrey!">
            <div class="max-w-[317px] ml-auto w-full md:max-w-full md:ml-0">
              <h3 class="text-xl font-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
              <div class="mb-[10px]"></div>
              <p class="font-light m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut ...
              </p>
            </div>
          </a>
          <a href=""
             class="text-inherit! block py-[27px] pl-[27px] pr-[max(1.5rem,calc((100vw-1236px)/2))] bg-white transition-colors hover:bg-lightgrey!">
            <div class="max-w-[317px] ml-auto w-full md:max-w-full md:ml-0">
              <h3 class="text-xl font-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
              <div class="mb-[10px]"></div>
              <p class="font-light m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut ...
              </p>
            </div>
          </a>
          <a href=""
             class="text-inherit! block py-[27px] pl-[27px] pr-[max(1.5rem,calc((100vw-1236px)/2))] bg-white transition-colors hover:bg-lightgrey!">
            <div class="max-w-[317px] ml-auto w-full md:max-w-full md:ml-0">
              <h3 class="text-xl font-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h3>
              <div class="mb-[10px]"></div>
              <p class="font-light m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                incididunt ut ...
              </p>
            </div>
          </a>
        </div>
      </div>
		<?php

		return ob_get_clean();
	}
}
add_action( 'init', function () {
	add_shortcode( 'industry_news', 'industry_news_shortcode' );
} );