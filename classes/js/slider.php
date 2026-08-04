class CustomCarouselEngine {
  constructor(container) {
    // UPDATED: Now targets '.slides' based on your new HTML structure
    this.track = container.querySelector('.slides');
    this.slides = Array.from(this.track.children);
    
    // Physics State
    this.currentX = 0;   // Where the track actually is rendering
    this.targetX = 0;    // Where the track is mathematically aiming to go
    
    // Navigation State
    this.currentIndex = 0;
    
    // Drag State
    this.isDragging = false;
    this.startX = 0;
    
    // Engine Settings
    this.friction = 0.1; // Lower = softer/slower, Higher = stiffer/faster
    
    this.init();
  }

  init() {
    this.updateSnapPoints();
    this.bindEvents();
    this.startPhysicsLoop();

    // Re-calculate snap points if the window resizes
    window.addEventListener('resize', () => this.updateSnapPoints());
  }

  // 1. Calculate where each slide lives
  updateSnapPoints() {
    // Maps each slide to its exact left offset
    this.snapPoints = this.slides.map(slide => -slide.offsetLeft);
    this.boundaries = {
      max: this.snapPoints[0], // Usually 0 (start)
      min: this.snapPoints[this.snapPoints.length - 1] // Max scroll distance (end)
    };
    
    // Make sure our target updates if the window resized
    this.goTo(this.currentIndex);
  }

  // 2. Navigation API
  goTo(index) {
    // Math.max and Math.min clamp the index so it doesn't go out of bounds
    this.currentIndex = Math.max(0, Math.min(index, this.slides.length - 1));
    
    // Update the target. The physics loop will handle the actual movement.
    this.targetX = this.snapPoints[this.currentIndex];
  }

  next() {
    this.goTo(this.currentIndex + 1);
  }

  prev() {
    this.goTo(this.currentIndex - 1);
  }

  // 3. The Interaction Cycle (Dragging)
  bindEvents() {
    this.track.addEventListener('pointerdown', (e) => {
      this.isDragging = true;
      // Record where we clicked relative to where the track is currently aiming
      this.startX = e.clientX - this.targetX;
      this.track.style.cursor = 'grabbing';
      
      // Prevent default image dragging behavior which breaks pointer events
      e.preventDefault(); 
    });

    window.addEventListener('pointermove', (e) => {
      if (!this.isDragging) return;
      
      // Update target directly to mouse position
      let newTarget = e.clientX - this.startX;
      
      // Add "rubber band" resistance if dragging past boundaries
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
      
      this.snapToClosest();
    });
  }

  // 4. Snapping Math
  snapToClosest() {
    let closestIndex = 0;
    let minDistance = Infinity;

    // Find which snap point is nearest to our current targetX
    this.snapPoints.forEach((point, index) => {
      const distance = Math.abs(point - this.targetX);
      if (distance < minDistance) {
        minDistance = distance;
        closestIndex = index;
      }
    });

    // Fire the navigation method to lock into the closest slide
    this.goTo(closestIndex);
  }

  // 5. The Animation Loop (The Engine Heartbeat)
  startPhysicsLoop() {
    const tick = () => {
      // Lerp (Linear Interpolation) formula: current += (target - current) * friction
      this.currentX += (this.targetX - this.currentX) * this.friction;

      // Apply the math to the DOM
      this.track.style.transform = `translate3d(${this.currentX}px, 0, 0)`;

      // Loop infinitely
      requestAnimationFrame(tick);
    };
    
    requestAnimationFrame(tick);
  }
}

// ==========================================
// Implementation / Wiring it up to the DOM
// ==========================================

document.addEventListener('DOMContentLoaded', () => {
  // UPDATED: Now queries '.slider'
  const container = document.querySelector('.slider');
  
  if (container) {
    const mySlider = new CustomCarouselEngine(container);

    // UPDATED: Now queries 'prev' and 'next' IDs
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    if (prevBtn) prevBtn.addEventListener('click', () => mySlider.prev());
    if (nextBtn) nextBtn.addEventListener('click', () => mySlider.next());
  }
});