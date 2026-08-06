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
  border-radius: 999px;

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