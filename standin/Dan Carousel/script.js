(function () {
    "use strict";

    var root = document.querySelector(".embla");
    if (!root || typeof window.EmblaCarousel !== "function") return;

    var viewport = root.querySelector(".embla__viewport");
    var prevBtn = root.querySelector(".embla__btn--prev");
    var nextBtn = root.querySelector(".embla__btn--next");
    var dotsWrap = root.querySelector(".embla__dots");
    var status = document.getElementById("emblaStatus");

    var embla = window.EmblaCarousel(viewport, {
        loop: true,
        align: "center",
        skipSnaps: false,
        containScroll: "trimSnaps"
    });

    function qsa(el, sel) {
        return Array.prototype.slice.call(el.querySelectorAll(sel));
    }

    function setSelectedSlideClass() {
        var slides = qsa(root, ".embla__slide");
        for (var i = 0; i < slides.length; i++) slides[i].classList.remove("is-selected");
        var idx = embla.selectedScrollSnap();
        var slideNodes = embla.slideNodes();
        if (slideNodes && slideNodes[idx]) slideNodes[idx].classList.add("is-selected");
    }

    function buildDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = "";

        var count = embla.scrollSnapList().length;
        for (var i = 0; i < count; i++) {
            (function (index) {
                var b = document.createElement("button");
                b.type = "button";
                b.className = "embla__dot";
                b.setAttribute("role", "tab");
                b.setAttribute("aria-label", "Go to testimonial " + (index + 1));
                b.setAttribute("aria-selected", "false");
                b.addEventListener("click", function () {
                    embla.scrollTo(index);
                });
                dotsWrap.appendChild(b);
            })(i);
        }
    }

    function setDotState() {
        if (!dotsWrap) return;
        var dots = qsa(dotsWrap, ".embla__dot");
        var idx = embla.selectedScrollSnap();

        for (var i = 0; i < dots.length; i++) {
            dots[i].setAttribute("aria-selected", i === idx ? "true" : "false");
        }

        if (status) status.textContent = "Testimonial " + (idx + 1) + " of " + dots.length;
    }

    function onPrev() { embla.scrollPrev(); }
    function onNext() { embla.scrollNext(); }

    function bind() {
        if (prevBtn) prevBtn.addEventListener("click", onPrev);
        if (nextBtn) nextBtn.addEventListener("click", onNext);
    }

    function onSelect() {
        setSelectedSlideClass();
        setDotState();
    }

    function init() {
        bind();
        buildDots();
        onSelect();
    }

    init();

    embla.on("select", onSelect);
    embla.on("reInit", function () {
        buildDots();
        onSelect();
    });

    // CodePen/layout loads can cause wrong measurements on first paint
    window.setTimeout(function () {
        embla.reInit();
    }, 0);

    window.addEventListener(
        "resize",
        (function () {
            var t = null;
            return function () {
                window.clearTimeout(t);
                t = window.setTimeout(function () {
                    embla.reInit();
                }, 120);
            };
        })()
    );
})();