function buttonRingSweepAnimation() {
	document.addEventListener("DOMContentLoaded", (event) => {
		document.querySelectorAll(".arrow-sweep-btn").forEach((btn) => {
			const sweeps = btn.querySelectorAll(".ring-sweep");
			const btn_ring = btn.querySelector(".ring");
			const DURATION_MS = 900; // keep in sync with CSS drawArc (.65s)

			btn.addEventListener("click", () => {
				if (btn.classList.contains("is-animating")) return;

				btn.classList.add("is-animating");
				btn_ring.style.opacity = "1";

				// restart sweep animations cleanly
				sweeps.forEach((p) => {
					p.style.animation = "none";
					p.getBoundingClientRect(); // reflow
					p.style.animation = "";
				});

				setTimeout(() => {
					btn.classList.remove("is-animating");
					btn_ring.style.opacity = "0";
				}, DURATION_MS);
			});
		});

	});
}

buttonRingSweepAnimation();