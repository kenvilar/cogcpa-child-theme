function buttonRingSweepAnimation() {
	document.addEventListener("DOMContentLoaded", (event) => {
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
	});
}

function myAccordion() {
	document.addEventListener("DOMContentLoaded", (event) => {
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
	});
}

function textLimiter() {
	document.addEventListener("DOMContentLoaded", (event) => {
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
	});
}

function divElementClickable() {
	document.addEventListener("DOMContentLoaded", (event) => {
		function divBlockClickable() {
			document.addEventListener("click", (e) => {
				const block = e.target.closest(".js-redirect-block, [data-href]");
				if (!block) return;

				const url = block.getAttribute("data-href");
				const target = block.getAttribute("data-target") || "_self";

				if (url) window.open(url, target);
			});
		}

		divBlockClickable();
	});
}

buttonRingSweepAnimation();
myAccordion();
textLimiter();
divElementClickable();