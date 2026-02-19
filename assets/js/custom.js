document.addEventListener("DOMContentLoaded", (event) => {
	function buttonRingSweepAnimation() {
		document.querySelectorAll(".arrow-sweep-btn").forEach((btn) => {
			const sweeps = btn.querySelectorAll(".ring-sweep");
			const btn_ring = btn.querySelector(".ring");
			const DURATION_MS = 900; // keep in sync with CSS drawArc (.65s)

			btn.addEventListener("mouseenter", () => {
				if (btn.classList.contains("is-animating")) return;

				btn.classList.add("is-animating");
				// btn_ring.style.opacity = "1";

				// restart sweep animations cleanly
				sweeps.forEach((p) => {
					p.style.animation = "none";
					p.getBoundingClientRect(); // reflow
					p.style.animation = "";
				});

				setTimeout(() => {
					btn.classList.remove("is-animating");
					// btn_ring.style.opacity = "0";
				}, DURATION_MS);
			});
		});
		document.querySelectorAll(".arrow-sweep-btn-hover").forEach((btn) => {
			const sweeps = btn.querySelectorAll(".ring-sweep");
			const btn_ring = btn.querySelector(".ring");
			const DURATION_MS = 900; // keep in sync with CSS drawArc (.65s)

			btn.closest('.group').addEventListener("mouseenter", () => {
				if (btn.classList.contains("is-animating")) return;

				btn.classList.add("is-animating");
				// btn_ring.style.opacity = "1";

				// restart sweep animations cleanly
				sweeps.forEach((p) => {
					p.style.animation = "none";
					p.getBoundingClientRect(); // reflow
					p.style.animation = "";
				});

				setTimeout(() => {
					btn.classList.remove("is-animating");
					// btn_ring.style.opacity = "0";
				}, DURATION_MS);
			});
		});
	}

	function myAccordion() {
		const accordionItemHeaders = document.querySelectorAll(
			".my-accordion-item-header"
		);

		accordionItemHeaders.forEach((accordionItemHeader) => {
			accordionItemHeader.addEventListener("click", (event) => {
				// Uncomment in case you only want to allow for the display of only one collapsed item at a time!
				const currentlyActiveAccordionItemHeader = document.querySelector(".my-accordion-item-header.active");
				if (currentlyActiveAccordionItemHeader && currentlyActiveAccordionItemHeader !== accordionItemHeader) {
					currentlyActiveAccordionItemHeader.classList.toggle("active");
					currentlyActiveAccordionItemHeader.closest(".my-accordion-item").classList.toggle("active");
					currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
				}

				accordionItemHeader.closest(".my-accordion-item").classList.toggle("active");
				accordionItemHeader.classList.toggle("active");
				const accordionItemBody = accordionItemHeader.nextElementSibling;
				if (accordionItemHeader.closest(".my-accordion-item").classList.contains("active")) {
					accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
				} else {
					accordionItemBody.style.maxHeight = 0;
				}
			});
		});
	}

	function textLimiter() {
		var elementsWithTextLimit = document.querySelectorAll('[text-limit]');
		elementsWithTextLimit.forEach(function (element) {
			var numberOfLines = parseInt(element.getAttribute('text-limit'));
			if (!isNaN(numberOfLines)) {
				element.style.overflow = 'hidden';
				element.style.textOverflow = 'ellipsis';
				element.style.display = '-webkit-box';
				element.style.webkitLineClamp = numberOfLines;
				element.style.webkitBoxOrient = 'vertical';
			}
		});
	}

	function putCaretIntoNavMenuItem() {
		const links = document.querySelectorAll(
			'.data-header-menu ul.menu > li.menu-item-has-children > a'
		);

		const svg = `
      <svg width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0.203711 1.22451L4.98811 6.0089C5.26919 6.28999 5.72371 6.28999 6.0018 6.0089L10.7892 1.22451C11.0703 0.943423 11.0703 0.488905 10.7892 0.210812C10.5081 -0.0672806 10.0536 -0.0702709 9.77549 0.210812L5.49944 4.48687L1.22339 0.210812C0.942303 -0.0702713 0.487785 -0.0702713 0.209693 0.210812C-0.0684004 0.491895 -0.0713902 0.946413 0.209693 1.22451L0.203711 1.22451Z" fill="#1E3348"/>
      </svg>
    `;

		links.forEach((a) => {
			// avoid double-inserting if the script runs twice
			if (a.querySelector('.menu-icon')) return;

			a.insertAdjacentHTML('beforeend', svg);
		});
	}

	function putCaretIntoMobileNavMenuItem() {
		const links = document.querySelectorAll(
			'.custom-sandwich-container .vce-sandwich-side-menu-container .vce-sandwich-side-menu-scroll-container .vce-sandwich-side-menu-inner nav > ul > li.menu-item-has-children > a'
		);

		const svg = `
      <svg width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M10.7963 1.22451L6.01189 6.0089C5.73081 6.28999 5.27629 6.28999 4.9982 6.0089L0.210812 1.22451C-0.0702709 0.943423 -0.0702708 0.488905 0.210812 0.210812C0.491896 -0.0672806 0.946413 -0.0702708 1.22451 0.210812L5.50056 4.48687L9.77661 0.210813C10.0577 -0.0702704 10.5122 -0.0702704 10.7903 0.210813C11.0684 0.491896 11.0714 0.946414 10.7903 1.22451L10.7963 1.22451Z" fill="currentColor"/>
      </svg>
    `;

		links.forEach((a) => {
			// avoid double-inserting if the script runs twice
			if (a.querySelector('.menu-icon')) return;

			a.insertAdjacentHTML('beforeend', svg);
		});
	}

	function clickMobileMenuItem() {
		const items = document.querySelectorAll(
			".custom-sandwich-container nav > ul > li.menu-item-has-children"
		);

		items.forEach((li) => {
			li.addEventListener("click", (e) => {
				const wasActive = li.classList.contains("active");

				// remove active from all
				items.forEach((other) => other.classList.remove("active"));

				// toggle current
				if (!wasActive) li.classList.add("active");
			});
		});
	}

	function divBlockClickable() {
		document.addEventListener("click", (e) => {
			const block = e.target.closest(".js-redirect-block, [data-href]");
			if (!block) return;

			const url = block.getAttribute("data-href");
			const target = block.getAttribute("data-target") || "_self";

			if (url) window.open(url, target);
		});
	}

	function putArrowInHowWeCanServeYouButton() {
		const links = document.querySelectorAll('.how-we-can-serve-you-arrow');
		const svg = `
      <button class="arrow-sweep-btn arrow-sweep-btn-hover w-auto! h-auto! bg-transparent!" data-dir="right">
			<span class="icon w-[17px]! h-[14px]!" aria-hidden="true">
			<svg class="chev chev--a" viewbox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M16.7659 6.69749C17.078 7.05742 17.078 7.63944 16.7659 7.99554L11.1884 14.4322C10.8763 14.7921 10.3716 14.7921 10.0629 14.4322C9.75413 14.0723 9.75081 13.4902 10.0629 13.1341L14.2793 8.26741H0.796797C0.355238 8.26741 0 7.8577 0 7.34843C0 6.83917 0.355238 6.42946 0.796797 6.42946H14.2793L10.0596 1.56656C9.74749 1.20663 9.74749 0.624616 10.0596 0.268514C10.3716 -0.0875877 10.8763 -0.0914167 11.185 0.268514L16.7659 6.69749Z" fill="white"/>
			</svg>
			<svg class="chev chev--b" viewbox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M16.7659 6.69749C17.078 7.05742 17.078 7.63944 16.7659 7.99554L11.1884 14.4322C10.8763 14.7921 10.3716 14.7921 10.0629 14.4322C9.75413 14.0723 9.75081 13.4902 10.0629 13.1341L14.2793 8.26741H0.796797C0.355238 8.26741 0 7.8577 0 7.34843C0 6.83917 0.355238 6.42946 0.796797 6.42946H14.2793L10.0596 1.56656C9.74749 1.20663 9.74749 0.624616 10.0596 0.268514C10.3716 -0.0875877 10.8763 -0.0914167 11.185 0.268514L16.7659 6.69749Z" fill="white"/>
			</svg>
			</span>
			</button>
    `;
		links.forEach((a) => {
			// avoid double-inserting if the script runs twice
			if (a.querySelector('.menu-icon')) return;

			a.insertAdjacentHTML('beforeend', svg);
		});
	}

	function menuToggleBtnIcon() {
		let menuWrapper = document.querySelector('.vce-sandwich-side-menu-wrapper');
		let openMenuBtn = document.querySelector(
			'.vce-sandwich-side-menu-open-button'
		);
		let openedMenuBtn = document.querySelector(
			'.menu-opened .vce-sandwich-side-menu-open-button'
		);

		openMenuBtn.addEventListener('click', () => {
			setTimeout(() => {
				if (menuWrapper.classList.contains('menu-opened')) {
					clickCloseMenuIcon();
				}
				menuWrapper.classList.toggle('menu-opened');
			}, 10);
		});

		function clickCloseMenuIcon() {
			let closeMenuBtn = document.querySelector(
				'.vce-sandwich-side-menu-close-button'
			);
			closeMenuBtn.click();
		}
	}

	myAccordion();
	textLimiter();
	putCaretIntoNavMenuItem();
	putCaretIntoMobileNavMenuItem();
	clickMobileMenuItem();
	putArrowInHowWeCanServeYouButton();
	menuToggleBtnIcon();
	setTimeout(() => {
		buttonRingSweepAnimation();
		divBlockClickable();
	}, 500)
});

// - moves [data-top-talk-to-an-expert] right after nav.menu-header-v2-container when < 1200px
// - moves it back to its original spot when >= 1200px
// - remembers the original position using a hidden placeholder
document.addEventListener('DOMContentLoaded', () => {
	const mq = window.matchMedia('(max-width: 1199px)');

	const el = document.querySelector('[data-top-talk-to-an-expert]');
	const nav = document.querySelector(
		'.vce-sandwich-side-menu-wrapper nav.menu-header-v2-container'
	);
	if (!el || !nav) return;

	// placeholder to remember original position
	const placeholder = document.createComment('talk-to-expert-placeholder');
	el.parentNode.insertBefore(placeholder, el);

	function moveForMobile() {
		// move element to right after nav
		nav.insertAdjacentElement('afterend', el);
	}

	function moveBack() {
		// move element back to where the placeholder is
		placeholder.parentNode.insertBefore(el, placeholder.nextSibling);
	}

	function apply() {
		if (mq.matches) moveForMobile();
		else moveBack();
	}

	apply();

	// watch breakpoint changes
	if (mq.addEventListener) mq.addEventListener('change', apply);
	else mq.addListener(apply);
});