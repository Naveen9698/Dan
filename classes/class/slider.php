.slider {
  overflow: hidden; /* The window */
  width: 100%;
}
.slides {
  display: flex; /* The track that moves */
  touch-action: pan-y; /* Allows native vertical scroll, blocks horizontal */
  will-change: transform; /* Hardware acceleration */
}
.slide {
  flex: 0 0 100%; /* Change this to 50%, 80%, etc. The JS won't care! */
  min-width: 0;
}