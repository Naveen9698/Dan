.yd_container { 
  display: flex; 
  will-change: transform; 
}

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
  cursor: pointer;
  background: #cbd5e1;
}

.yd_dot.active {
  background: #2563eb;
}

.yd_counter {
  text-align: center;
  margin-top: 12px;
  font-weight: 600;
}

.yd_progress {
  height: 10px;
  margin-top: 12px;
  background: #ddd;
  overflow: hidden;
}

.yd_progress-fill {
  height: 100%;
  width: var(--progress, 0%);
  background: #0066ff;
}

.yd_autoplay-progress {
  height: 10px;
  margin-top: 12px;
  background: #ddd;
  overflow: hidden;
}

.yd_autoplay-progress-fill {
  height: 100%;
  width: var(--ap-progress, 0%);
  background: #ff5500;
}

.yd_scrollbar {
  height: 10px;
  margin-top: 12px;
  background: #ddd;
  overflow: hidden;
}

.yd_scrollbar-thumb {
  height: 100%;
  background: #00cc66;
}