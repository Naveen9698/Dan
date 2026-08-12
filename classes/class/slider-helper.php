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