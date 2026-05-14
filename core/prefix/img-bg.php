/* Background-like diret image that remains semantic */
.bg-container {
  position: relative;
  overflow: hidden;
}

.bg-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center; /* default */
}

/* Optional overlay */
.bg-overlay {
  position: absolute;
  inset: 0;
  pointer-events: none;
}