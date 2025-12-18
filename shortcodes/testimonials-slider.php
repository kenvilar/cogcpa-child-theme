<?php

if ( ! function_exists( 'testimonials_slider_shortcode' ) ) {
	function testimonials_slider_shortcode( $atts = [], $content = null ) {
		ob_start();

		$args = array(
			'post_type'      => 'testimonial',
			'posts_per_page' => - 1,
		);

		$testimonials_query = new WP_Query( $args );

		if ( $testimonials_query->have_posts() ) {
			?>
          <style>
						#testimonials-slider .splide__slide:not(.is-active) {
							opacity: 0.25;
						}
						#testimonials-slider .splide__arrows {
							display: flex;
							align-items: center;
							justify-content: center;
							gap: 11px;
						}
						#testimonials-slider .splide__arrow {
							-ms-flex-align: center;
							align-items: center;
							background: #017BB1;
							border: 0;
							border-radius: 50%;
							cursor: pointer;
							display: -ms-flexbox;
							display: flex;
							-ms-flex-pack: center;
							justify-content: center;
							opacity: 1;
							padding: 0;
							position: relative;
							top: 0;
							transform: translateY(0%);
							width: 40px;
							height: 40px;
							z-index: 1;
							overflow: hidden;
						}
						#testimonials-slider .splide__arrow--prev {
							left: 0;
						}
						#testimonials-slider .splide__arrow--prev svg {
							transform: scaleX(1);
						}
						#testimonials-slider .splide__arrow--next {
							right: 0;
						}
						#testimonials-slider .splide__arrow svg {
							height: auto;
							width: auto;
							fill: none;
						}
            .testimonials-slider {
              display: flex;
              flex-wrap: nowrap;
            }
          </style>
          <div id="testimonials-slider" class="splide" role="group" aria-label="Testimonials Slider">
            <div class="splide__track">
              <ul class="splide__list"></ul>
            </div>
            <div class="mb-[37px]"></div>
            <div class="splide__arrows">
              <button class="splide__arrow splide__arrow--prev arrow-sweep-btn" data-dir="left" aria-label="Previous">
                <span class="icon" aria-hidden="true">
                  <svg class="chev chev--a" viewBox="0 0 24 24">
                    <path d="M15 6L9 12l6 6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                  </svg>
                  <svg class="chev chev--b" viewBox="0 0 24 24">
                    <path d="M15 6L9 12l6 6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                  </svg>
                </span>
                <svg class="ring" viewBox="0 0 80 80" aria-hidden="true">
                  <!-- r=39 -> edge points are 1 and 79 -->
                  <circle class="ring-base" cx="41" cy="41" r="41"></circle>
                  <!-- start at LEFT (1,40), split to TOP + BOTTOM, meet at RIGHT (79,40) -->
                  <path class="ring-sweep ring-sweep--top" pathLength="100" d="M1 40 A39 39 0 0 1 79 40"></path>
                  <path class="ring-sweep ring-sweep--bottom" pathLength="100" d="M1 40 A39 39 0 0 0 79 40"></path>
                </svg>
              </button>
              <button class="splide__arrow splide__arrow--next arrow-sweep-btn" data-dir="right" aria-label="Next">
                <span class="icon" aria-hidden="true">
                  <svg class="chev chev--a" viewBox="0 0 24 24">
                    <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                  </svg>
                  <svg class="chev chev--b" viewBox="0 0 24 24">
                    <path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                          stroke-linejoin="round"/>
                  </svg>
                </span>
                <svg class="ring" viewBox="0 0 80 80" aria-hidden="true">
                  <circle class="ring-base" cx="41" cy="41" r="41"></circle>
                  <!-- start at RIGHT (79,40), split to TOP + BOTTOM, meet at LEFT (1,40) -->
                  <path class="ring-sweep ring-sweep--top" pathLength="100" d="M79 40 A39 39 0 0 0 1 40"></path>
                  <path class="ring-sweep ring-sweep--bottom" pathLength="100" d="M79 40 A39 39 0 0 1 1 40"></path>
                </svg>
              </button>
            </div>
          </div>
          <div class="testimonials-slider" data-slides-for="testimonials-slider">
			  <?php
			  while ( $testimonials_query->have_posts() ) {
				  $testimonials_query->the_post();
				  ?>
                <div class="testimonial-item">
					<?php
					if ( has_post_thumbnail() ) : ?>
                      <div class="testimonial-image">
						  <?php
						  the_post_thumbnail( 'full' ); ?>
                      </div>
					<?php
					endif; ?>
                  <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M3.36362 17C2.3953 17 1.57988 16.568 0.91735 15.704C0.305783 14.7892 0 13.5187 0 11.8924C0 9.1988 0.560603 6.8864 1.68181 4.95516C2.85398 2.97309 4.45934 1.32137 6.49789 0L7.87392 1.75336C6.19211 3.12556 4.91801 4.52317 4.05163 5.94619C3.18524 7.31838 2.75205 9.07175 2.75205 11.2063C2.85398 11.1555 3.05783 11.13 3.36362 11.13C4.12807 11.13 4.81609 11.3587 5.42765 11.8161C6.09018 12.2735 6.42145 12.9851 6.42145 13.9507C6.42145 14.9163 6.11567 15.6786 5.5041 16.2377C4.9435 16.7459 4.23 17 3.36362 17ZM14.1425 17C13.1742 17 12.3587 16.568 11.6962 15.704C11.0846 14.7892 10.7789 13.5187 10.7789 11.8924C10.7789 9.1988 11.3395 6.8864 12.4607 4.95516C13.6328 2.97309 15.2382 1.32137 17.2768 0L18.6528 1.75336C16.971 3.12556 15.6969 4.52317 14.8305 5.94619C13.9641 7.31838 13.5309 9.07175 13.5309 11.2063C13.6328 11.1555 13.8367 11.13 14.1425 11.13C14.9069 11.13 15.5949 11.3587 16.2065 11.8161C16.869 12.2735 17.2003 12.9851 17.2003 13.9507C17.2003 14.9163 16.8945 15.6786 16.283 16.2377C15.7224 16.7459 15.0089 17 14.1425 17Z"
                      fill="#017BB1"/>
                  </svg>
                  <div class="mb-[35px]"></div>
                  <div class="testimonial-content font-light">
					  <?php
					  the_content(); ?>
                  </div>
                  <div class="mb-[35px]"></div>
                  <hr class="h-[1px] bg-darkblue! opacity-100! m-0! p-0!"/>
                  <div class="mb-[17px]"></div>
                  <div class="flex items-center gap-[16px]">
                    <h3 class="text-xl">
						<?php
						the_title(); ?>
                    </h3>
                    <div class="w-[1px] h-[25px] bg-darkblue"></div>
                    <div class="max-w-[107px] w-full">
                      <img src="/wp-content/uploads/highground-trading-group.avif" class="w-full h-full object-cover"
                           alt="logo">
                    </div>
                  </div>
                </div>
				  <?php
			  }
			  ?>
          </div>
          <script>
						document.addEventListener("DOMContentLoaded", function () {
							function initTestimonialSlider() {
								//configs
								const splideMarqueeElementId = "testimonials-slider";

								//elements
								const marqueeElement = document.getElementById(splideMarqueeElementId);
								const slideContents = Array.from(
									document.querySelector(`[data-slides-for=${splideMarqueeElementId}]`)
										.children
								);

								//options
								const splideMarqueeOptions = {
									/*suggested options*/
									type: "loop", //"loop",
									arrows: true,
									pagination: false,
									/*custom options*/
									gap: "117px",
									perPage: 3,
									perMove: 1,
									rewind: true,
									pauseOnHover: false,
									lazyLoad: "sequential",
									updateOnMove: true,
									focus: "center",
									autoHeight: true,
									intersection: {
										inView: {
											autoplay: true
										},
										outView: {
											autoplay: false
										}
									},
									breakpoints: {
										991: {
											gap: "40px",
											perPage: 2,
										},
										767: {
											gap: "1.5rem",
											perPage: 1,
										}
									}
								};

								//init
								slideContents.forEach((slideContent) => {
									let slide = document.createElement("li");
									slide.classList.add("splide__slide");
									slide.appendChild(slideContent);
									marqueeElement.querySelector("ul").appendChild(slide);
								});

								const splideMarquee = new Splide(
									`#${splideMarqueeElementId}`,
									splideMarqueeOptions
								);

								splideMarquee.on("ready", function () {
									//setHeightCarousel(0);
								});

								splideMarquee.mount(); //splideMarquee.mount(window.splide.Extensions);

								splideMarquee.on("move", function () {
									const currentIndex = splideMarquee.index;
									//setHeightCarousel(currentIndex);
								});

								function setHeightCarousel(index) {
									const image = document.querySelectorAll(
										`#testimonials-slider li:nth-child(${index + 1}) > div`
									);

									let imgHeight;

									if (image[0]) {
										imgHeight = image[0].offsetHeight;
										splideMarquee.options = {
											height: imgHeight + "px"
										};
									} else {
										image[index].addEventListener("load", function () {
											imgHeight = this.offsetHeight;
											splideMarquee.options = {
												height: imgHeight + "px"
											};
										});
									}
								}
							}

							initTestimonialSlider();
						});
          </script>
			<?php
			wp_reset_postdata();
		}

		return ob_get_clean();
	}
}
add_action( 'init', function () {
	add_shortcode( 'testimonials_slider', 'testimonials_slider_shortcode' );
} );