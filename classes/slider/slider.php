<!-- <style>
  /* =========================================
   yd_carousel
========================================= */

.yd_carousel {
  position: relative;
  max-width: 900px;
  margin: 0 auto;
}

.yd_viewport {
  overflow: hidden;
  border-radius: 16px;
}

.yd_container {
  display: flex;
  will-change: transform;
}

.yd_slide {
  flex: 0 0 100%;
  min-width: 100%;
  height: 400px;

  display: flex;
  align-items: center;
  justify-content: center;

  font-size: 2rem;
  color: white;
}

/* =========================================
   ACTIVE STATES
========================================= */

.yd_slide {
  transition:
    opacity .3s ease,
    transform .3s ease;
}

.yd_slide:not(.active) {
  opacity: .8;
}

.yd_slide.active {
  opacity: 1;
}

/* =========================================
   NAV BUTTONS
========================================= */

.yd_prev,
.yd_next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);

  width: 44px;
  height: 44px;

  border: none;
  border-radius: 999px;

  background: rgba(0, 0, 0, .7);
  color: white;

  cursor: pointer;
  z-index: 10;
}

.yd_prev {
  left: 12px;
}

.yd_next {
  right: 12px;
}

.yd_prev:hover,
.yd_next:hover {
  background: black;
}

/* =========================================
   DOTS
========================================= */

.yd_dots {
  display: flex;
  justify-content: center;
  gap: 10px;

  margin-top: 20px;
}

.yd_dot {
  width: 12px;
  height: 12px;

  border: none;
  border-radius: 999px;

  cursor: pointer;

  background: #cbd5e1;
}

.yd_dot.active {
  background: #2563eb;
}

/* =========================================
   COUNTER
========================================= */

.yd_counter {
  text-align: center;
  margin-top: 12px;
  font-weight: 600;
}
</style>

<div class="yd_carousel loop keyboard autoplay" data-delay="3000">

  <div class="yd_viewport">
    <div class="yd_container">
      <div class="yd_slide bg-main">
        <h2>Slide 1</h2>
      </div>
      <div class="yd_slide bg-sub">
        <h2>Slide 2</h2>
      </div>
      <div class="yd_slide bg-acnt">
        <h2>Slide 3</h2>
      </div>
      <div class="yd_slide bg-g8">
        <h2>Slide 4</h2>
      </div>
    </div>
  </div>

  <button class="yd_prev"> ← </button>
  <button class="yd_next"> → </button>
  <div class="yd_dots"></div>
  <div class="yd_counter"></div>

</div> -->