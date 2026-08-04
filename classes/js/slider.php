class CustomCarouselEngine {
  constructor(container) {
    this.track = container.querySelector('.carousel-track');
    this.slides = Array.from(this.track.children);
    
    // Physics State
    this.currentX = 0;   // Where the track actually is right now
    this.targetX = 0;    // Where the track wants to go
    
    // Drag State
    this.isDragging = false;
    this.startX = 0;
    this.dragOffset = 0;
    
    // Engine Settings
    this.friction = 0.1; // Lower = softer/slower, Higher = stiffer/faster
    
    this.init();
  }

  init() {
    this.bindEvents();
    this.updateSnapPoints();
    this.startPhysicsLoop();
  }

  // 1. Calculate where each slide lives
  updateSnapPoints() {
    // Maps each slide to its exact left offset
    this.snapPoints = this.slides.map(slide => -slide.offsetLeft);
    this.boundaries = {
      max: this.snapPoints[0], // 0 (start)
      min: this.snapPoints[this.snapPoints.length - 1] // Max scroll (end)
    };
  }

  // 2. The Interaction Cycle
  bindEvents() {
    this.track.addEventListener('pointerdown', (e) => {
      this.isDragging = true;
      // Record where we clicked relative to where the track currently is
      this.startX = e.clientX - this.targetX;
      this.track.style.cursor = 'grabbing';
    });

    window.addEventListener('pointermove', (e) => {
      if (!this.isDragging) return;
      // Update target directly to mouse position
      let newTarget = e.clientX - this.startX;
      
      // Optional: Add "rubber band" resistance if dragging past boundaries
      if (newTarget > this.boundaries.max) {
        newTarget = this.boundaries.max + (newTarget - this.boundaries.max) * 0.3;
      } else if (newTarget < this.boundaries.min) {
        newTarget = this.boundaries.min + (newTarget - this.boundaries.min) * 0.3;
      }
      
      this.targetX = newTarget;
    });

    window.addEventListener('pointerup', () => {
      if (!this.isDragging) return;
      this.isDragging = false;
      this.track.style.cursor = '';
      
      // Find the closest slide to snap to
      this.snapToClosest();
    });
  }

  // 3. The Math
  snapToClosest() {
    // Find which snap point is closest to our current targetX
    const closestSnap = this.snapPoints.reduce((prev, curr) => {
      return (Math.abs(curr - this.targetX) < Math.abs(prev - this.targetX) ? curr : prev);
    });
    
    this.targetX = closestSnap;
  }

  // 4. The Animation Loop (The Engine Heartbeat)
  startPhysicsLoop() {
    const tick = () => {
      // Lerp (Linear Interpolation) formula:
      // current += (target - current) * friction
      this.currentX += (this.targetX - this.currentX) * this.friction;

      // Apply the math to the DOM
      this.track.style.transform = `translate3d(${this.currentX}px, 0, 0)`;

      // Loop infinitely
      requestAnimationFrame(tick);
    };
    
    requestAnimationFrame(tick);
  }
}

// Initialize
const myCarousel = new CustomCarouselEngine(document.querySelector('.carousel'));