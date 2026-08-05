<!-- <style>
  /* =========================================
   yd-carousel
========================================= */

.yd-carousel {
  position: relative;
  max-width: 900px;
  margin: 0 auto;
}

.yd-viewport {
  overflow: hidden;
  border-radius: 16px;
}

.yd-container {
  display: flex;
  will-change: transform;
}

.yd-slide {
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

.yd-slide {
  transition:
    opacity .3s ease,
    transform .3s ease;
}

.yd-slide:not(.active) {
  opacity: .8;
}

.yd-slide.active {
  opacity: 1;
}

/* =========================================
   NAV BUTTONS
========================================= */

.yd-prev,
.yd-next {
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

.yd-prev {
  left: 12px;
}

.yd-next {
  right: 12px;
}

.yd-prev:hover,
.yd-next:hover {
  background: black;
}

/* =========================================
   DOTS
========================================= */

.yd-dots {
  display: flex;
  justify-content: center;
  gap: 10px;

  margin-top: 20px;
}

.yd-dot {
  width: 12px;
  height: 12px;

  border: none;
  border-radius: 999px;

  cursor: pointer;

  background: #cbd5e1;
}

.yd-dot.active {
  background: #2563eb;
}

/* =========================================
   COUNTER
========================================= */

.yd-counter {
  text-align: center;
  margin-top: 12px;
  font-weight: 600;
}
</style>

<div class="yd-carousel loop keyboard autoplay" data-delay="3000">

  <div class="yd-viewport">
    <div class="yd-container">
      <div class="yd-slide bg-main">
        <h2>Slide 1</h2>
      </div>
      <div class="yd-slide bg-sub">
        <h2>Slide 2</h2>
      </div>
      <div class="yd-slide bg-acnt">
        <h2>Slide 3</h2>
      </div>
      <div class="yd-slide bg-g8">
        <h2>Slide 4</h2>
      </div>
    </div>
  </div>

  <button class="yd-prev"> ← </button>
  <button class="yd-next"> → </button>
  <div class="yd-dots"></div>
  <div class="yd-counter"></div>

</div> -->