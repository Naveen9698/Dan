.slide{
  font-size: 3.75rem;
  width: 100%;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  background-color: #4a4a4a;
}

.yd_slide,
.yd_container,
.yd_viewport {
  box-sizing: border-box;
}

.yd_slide { flex-shrink:0 }

.yd_viewport {
  overflow: hidden;
  position: relative;
  transition: height 0.3s ease;
  touch-action: pan-y;
}

.yd_carousel.vertical .yd_viewport {
  touch-action: pan-x;
}

.yd_scrollbar.disabled { 
  pointer-events: none; 
  opacity: 0.5; 
}

.yd_slide-clone {
  pointer-events: none;
  user-select: none;
  -webkit-user-select: none;
}

.yd_carousel.vertical .yd_scrollbar {
  width: 10px;
  height: 100%;
  position: absolute;
  right: 0;
  top: 0;
  margin-top: 0;
}

.yd_carousel[data-direction="rtl"] {
  direction: rtl;
}

.yd_scrollbar {
  direction: ltr;
}

.yd_carousel.debug {
  position: relative;
}

.yd_prev,
.yd_next,
.yd_dots,
.yd_counter,
.yd_progress,
.yd_autoplay-progress,
.yd_scrollbar {
  margin-top: 12px;
}
.yd_prev,
.yd_next {
  background: #2563eb;
  color: #fff;
  border: none;
  cursor: pointer;
  padding: 8px 16px;
}
.yd_progress,
.yd_autoplay-progress,
.yd_scrollbar {
  height: 10px;
  background: #ddd;
  overflow: hidden;
}
.yd_progress-fill,
.yd_autoplay-progress-fill,
.yd_scrollbar-thumb {
  height: 100%;
}

.yd_container {
  display: flex;
  will-change: transform;
  transform: translate3d(0,0,0);
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
}

.yd_carousel.vertical .yd_container {
    flex-direction: column;
}
.yd_dots {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.yd_dot {
  width: 12px;
  height: 12px;
  border: none;
  cursor: pointer;
  background: #cbd5e1;
}

.yd_dot.active {
  background: #2563eb;
}
.yd_counter {
  text-align: center;
  font-weight: 600;
}
.yd_progress-fill {
  width: var(--progress, 0%);
  background: #0066ff;
}

.yd_autoplay-progress-fill {
  width: var(--ap-progress, 0%);
  background: #ff5500;
}

.yd_scrollbar-thumb {
  background: #00cc66;
}