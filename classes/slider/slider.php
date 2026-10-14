<div class="yd_carousel pn-relative loop keyboard debug">

  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-xl">
      <div class="yd_slide">
        <h2 class="slide">1</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">2</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">3</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">4</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">5</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">6</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">7</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">8</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">9</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">10</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">11</h2>
      </div>
      <div class="yd_slide">
        <h2 class="slide">12</h2>
      </div>
    </div>
  </div>

  <div class="yd_controles">
    <button class="yd_prev"> Prev </button>
    <button class="yd_next"> Next </button>

    <div class="yd_dots">
      <div class="yd_dot blur-md ac:blur-0"></div>
    </div>

    <div class="yd_counter">
      <span class="yd_current">1</span> / <span class="yd_total">4</span>
    </div>

  </div>

</div>


<!-- ==========================================
       GLOBAL QA HELPERS (SCRIPTS)
  =========================================== -->
<script>
  // 1. Virtual Renderer Callback
  window.qaVirtualRender = function(idx) {
    const hue = (idx * 25) % 360;
    return `<div class="slide" style="background-color: hsl(${hue}, 70%, 85%); color: #333; border-color: hsl(${hue}, 70%, 60%)">${idx + 1}</div>`;
  };

  // 2. Stress Test DOM Populator
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-inject-slides]').forEach(el => {
      const count = parseInt(el.getAttribute('data-inject-slides'), 10);
      let html = '';
      for (let i = 0; i < count; i++) html += `<div class="yd_slide"><div class="slide">${i+1}</div></div>`;
      el.innerHTML = html;
    });
  });
</script>

<!-- ==========================================
     SECTION 01: CORE NAVIGATION
=========================================== -->
<h2 class="section-title">SECTION 01: Core Navigation</h2>

<h3 class="test-title">TEST-001: Slide Snap (Default)</h3>
<div class="yd_carousel slide-snap" id="test-001">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-002: Group Snap (2 Slides)</h3>
<div class="yd_carousel group-snap" id="test-002">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-003: Group Snap (3 Slides)</h3>
<div class="yd_carousel group-snap" id="test-003">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="9"></div>
  </div>
</div>

<h3 class="test-title">TEST-004: Drag Free</h3>
<div class="yd_carousel drag-free" id="test-004">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-005: Slide Snap + Drag Free</h3>
<div class="yd_carousel slide-snap drag-free" id="test-005">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-006: Group Snap + Drag Free</h3>
<div class="yd_carousel group-snap drag-free" id="test-006">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 02: DIRECTION & LAYOUT
=========================================== -->
<h2 class="section-title">SECTION 02: Direction & Layout</h2>

<h3 class="test-title">TEST-007: RTL</h3>
<div class="yd_carousel rtl" id="test-007">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-008: RTL + Loop</h3>
<div class="yd_carousel rtl loop" id="test-008">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-009: Vertical</h3>
<div class="yd_carousel vertical" id="test-009">
  <div class="yd_viewport h-420px h-add-4px">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-010: Vertical + Keyboard</h3>
<div class="yd_carousel vertical keyboard" id="test-010">
  <div class="yd_viewport h-420px h-add-4px">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-011: Vertical + Loop + Keyboard</h3>
<div class="yd_carousel vertical loop keyboard" id="test-011">
  <div class="yd_viewport h-420px h-add-4px">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 03: ALIGNMENT
=========================================== -->
<h2 class="section-title">SECTION 03: Alignment</h2>

<h3 class="test-title">TEST-012: Align Start (Default)</h3>
<div class="yd_carousel" id="test-012">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
</div>

<h3 class="test-title">TEST-013: Align Center</h3>
<div class="yd_carousel align-center" id="test-013">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-014: Align End</h3>
<div class="yd_carousel align-end" id="test-014">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
</div>

<h3 class="test-title">TEST-015: Align Start + Loop</h3>
<div class="yd_carousel loop" id="test-015">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
</div>

<h3 class="test-title">TEST-016: Align Center + Loop</h3>
<div class="yd_carousel align-center loop" id="test-016">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-017: Align End + Loop</h3>
<div class="yd_carousel align-end loop" id="test-017">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 04: LOOP SYSTEM
=========================================== -->
<h2 class="section-title">SECTION 04: Loop System</h2>

<h3 class="test-title">TEST-018: Loop</h3>
<div class="yd_carousel loop" id="test-018">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-019: Loop + Drag Free</h3>
<div class="yd_carousel loop drag-free" id="test-019">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-020: Loop + Keyboard</h3>
<div class="yd_carousel loop keyboard" id="test-020">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-021: Loop + Autoplay</h3>
<div class="yd_carousel loop autoplay" id="test-021">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-022: Loop + Drag Free + Autoplay</h3>
<div class="yd_carousel loop drag-free autoplay" id="test-022">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 05: INPUTS
=========================================== -->
<h2 class="section-title">SECTION 05: Inputs</h2>

<h3 class="test-title">TEST-023: Drag (Default)</h3>
<div class="yd_carousel" id="test-023">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-024: Keyboard</h3>
<div class="yd_carousel keyboard" id="test-024">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-025: Wheel</h3>
<div class="yd_carousel wheel" id="test-025">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-026: RTL + Keyboard</h3>
<div class="yd_carousel rtl keyboard" id="test-026">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-027: Vertical + Keyboard</h3>
<div class="yd_carousel vertical keyboard" id="test-027">
  <div class="yd_viewport h-420px h-add-4px">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-028: Loop + Keyboard</h3>
<div class="yd_carousel loop keyboard" id="test-028">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 06: BEHAVIORS
=========================================== -->
<h2 class="section-title">SECTION 06: Behaviors</h2>

<h3 class="test-title">TEST-029: Focus On Change</h3>
<div class="yd_carousel focus-on-change" id="test-029">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><button class="slide" style="width:100%">Btn 1</button></div>
      <div class="yd_slide"><button class="slide" style="width:100%">Btn 2</button></div>
      <div class="yd_slide"><button class="slide" style="width:100%">Btn 3</button></div>
    </div>
  </div>
  <button class="yd_next mt-sm">Next</button>
</div>

<h3 class="test-title">TEST-030: Reduced Motion</h3>
<div class="yd_carousel" data-reduced-motion="true" id="test-030">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <button class="yd_next mt-sm">Next (No Anim)</button>
</div>

<h3 class="test-title">TEST-031: Autoplay</h3>
<div class="yd_carousel autoplay" id="test-031">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-032: Autoplay Pause Hover</h3>
<div class="yd_carousel autoplay pause-hover" id="test-032">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
  <p style="font-size: 12px; color: #666;">Hover over the slider to pause.</p>
</div>

<h3 class="test-title">TEST-033: Autoplay Backward</h3>
<div class="yd_carousel autoplay loop" data-autoplay-direction="backward" id="test-033">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-034: Autoplay API</h3>
<div class="yd_carousel autoplay" id="test-034">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="mt-sm flex-x">
    <button onclick="document.getElementById('test-034').__ydCarousel.autoplayApi.play()">Play</button>
    <button onclick="document.getElementById('test-034').__ydCarousel.autoplayApi.pause()">Pause</button>
    <button onclick="document.getElementById('test-034').__ydCarousel.autoplayApi.stop()">Stop</button>
  </div>
</div>

<!-- ==========================================
     SECTION 07: PLUGINS
=========================================== -->
<h2 class="section-title">SECTION 07: Plugins</h2>

<h3 class="test-title">TEST-035: Controls</h3>
<div class="yd_carousel" id="test-035">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-036: Dots</h3>
<div class="yd_carousel" id="test-036">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_dots"></div>
</div>

<h3 class="test-title">TEST-037: Counter</h3>
<div class="yd_carousel" id="test-037">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_counter mt-sm"></div>
</div>

<h3 class="test-title">TEST-038: Progress</h3>
<div class="yd_carousel" id="test-038">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_progress mt-sm">
    <div class="yd_progress-fill"></div>
  </div>
</div>

<h3 class="test-title">TEST-039: Scrollbar</h3>
<div class="yd_carousel" id="test-039">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
  <div class="yd_scrollbar mt-sm">
    <div class="yd_scrollbar-thumb"></div>
  </div>
</div>

<h3 class="test-title">TEST-040: Full Plugin Stack</h3>
<div class="yd_carousel" id="test-040">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
  <div class="mt-sm flex-x"><button class="yd_prev">Prev</button><button class="yd_next">Next</button>
    <div class="yd_dots"></div>
    <div class="yd_counter" style="margin-top:0; margin-left: 10px; line-height:35px;"></div>
  </div>
  <div class="yd_progress mt-sm">
    <div class="yd_progress-fill"></div>
  </div>
  <div class="yd_scrollbar mt-sm">
    <div class="yd_scrollbar-thumb"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 08: HASH
=========================================== -->
<h2 class="section-title">SECTION 08: Hash</h2>

<h3 class="test-title">TEST-041: Hash Basic</h3>
<div class="yd_carousel hash" id="test-041">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide" data-hash="h1">
        <div class="slide">#h1</div>
      </div>
      <div class="yd_slide" data-hash="h2">
        <div class="slide">#h2</div>
      </div>
      <div class="yd_slide" data-hash="h3">
        <div class="slide">#h3</div>
      </div>
    </div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-042: Hash Groups</h3>
<div class="yd_carousel hash" data-hash-group="gallery" id="test-042">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide" data-hash="img1">
        <div class="slide">#gallery:img1</div>
      </div>
      <div class="yd_slide" data-hash="img2">
        <div class="slide">#gallery:img2</div>
      </div>
      <div class="yd_slide" data-hash="img3">
        <div class="slide">#gallery:img3</div>
      </div>
    </div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<!-- ==========================================
     SECTION 09: SYNC
=========================================== -->
<h2 class="section-title">SECTION 09: Sync (Microkernel Architecture)</h2>
<p style="font-size: 14px; color: #666;">
  All synchronization is now handled purely via <code>data-sync</code> attributes. No manual JavaScript event mapping is required.
</p>

<style>
  /* Optional: Make the hero slide stand out visually */
  .slide.hero { height: 250px; font-size: 32px; background: #cfe2ff; color: #084298; border-color: #0d6efd; }

  /* 
   * THUMBNAIL SYNC STYLING
   * We rely completely on the framework's native .active class applied by the AccessibilityManager 
   */
  .yd_carousel-thumbnail-mode .yd_slide { 
    cursor: pointer; 
    opacity: 0.4; 
    transition: opacity 0.2s ease, transform 0.2s ease; 
  }
  
  .yd_carousel-thumbnail-mode .yd_slide:hover {
    opacity: 0.8;
  }

  .yd_carousel-thumbnail-mode .yd_slide.active { 
    opacity: 1; 
    transform: scale(1.03);
  }

  .yd_carousel-thumbnail-mode .yd_slide.active .slide { 
    background: #198754; 
    color: white; 
    border-color: #146c43; 
  }
</style>

<h3 class="test-title">TEST-043: Swiper-Style Thumbnail Gallery (Bidirectional)</h3>
<p style="font-size: 13px; color: #666;">
  <strong>Hero:</strong> Drives the thumbnails when swiped/navigated.<br>
  <strong>Thumbnails:</strong> Drives the Hero when clicked or activated via Keyboard (Tab + Enter/Space).
</p>

<!-- MASTER HERO -->
<div class="yd_carousel sync loop drag-free keyboard mb-md" 
     id="test-hero" 
     data-sync="#test-thumbs">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide"><div class="slide hero">Image 1</div></div>
      <div class="yd_slide"><div class="slide hero">Image 2</div></div>
      <div class="yd_slide"><div class="slide hero">Image 3</div></div>
      <div class="yd_slide"><div class="slide hero">Image 4</div></div>
      <div class="yd_slide"><div class="slide hero">Image 5</div></div>
      <div class="yd_slide"><div class="slide hero">Image 6</div></div>
    </div>
  </div>
  <div class="mt-sm">
    <button class="yd_prev">Prev</button> 
    <button class="yd_next">Next</button>
  </div>
</div>

<!-- THUMBNAIL SLAVE -->
<div class="yd_carousel sync loop align-center" 
     id="test-thumbs" 
     data-sync="#test-hero" 
     data-sync-role="thumbnail">
  <div class="yd_viewport">
    <div class="yd_container slides-4 gap-sm">
      <div class="yd_slide"><div class="slide">Thumb 1</div></div>
      <div class="yd_slide"><div class="slide">Thumb 2</div></div>
      <div class="yd_slide"><div class="slide">Thumb 3</div></div>
      <div class="yd_slide"><div class="slide">Thumb 4</div></div>
      <div class="yd_slide"><div class="slide">Thumb 5</div></div>
      <div class="yd_slide"><div class="slide">Thumb 6</div></div>
    </div>
  </div>
</div>

<hr style="margin: 40px 0; border: 1px solid #eee;">
<!-- MASTER CAROUSEL -->
<div class="yd_carousel sync loop keyboard mb-md" 
     data-sync-group="product-gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide"><div class="slide hero">Image 1</div></div>
      <div class="yd_slide"><div class="slide hero">Image 2</div></div>
      <div class="yd_slide"><div class="slide hero">Image 3</div></div>
      <div class="yd_slide"><div class="slide hero">Image 4</div></div>
      <div class="yd_slide"><div class="slide hero">Image 5</div></div>
      <div class="yd_slide"><div class="slide hero">Image 6</div></div>
    </div>
  </div>
</div>

<!-- THUMBNAIL CAROUSEL -->
<div class="yd_carousel sync loop align-center" 
     data-sync-group="product-gallery" 
     data-sync-role="thumbnail">
  <div class="yd_viewport">
    <div class="yd_container slides-4 gap-sm">
      <div class="yd_slide"><div class="slide">Thumb 1</div></div>
      <div class="yd_slide"><div class="slide">Thumb 2</div></div>
      <div class="yd_slide"><div class="slide">Thumb 3</div></div>
      <div class="yd_slide"><div class="slide">Thumb 4</div></div>
      <div class="yd_slide"><div class="slide">Thumb 5</div></div>
      <div class="yd_slide"><div class="slide">Thumb 6</div></div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-044: Standard Slide Sync (1:1 Bidirectional)</h3>
<p style="font-size: 13px; color: #666;">Both carousels follow each other's physical navigations identically.</p>

<div id="master-slide" class="yd_carousel sync loop keyboard mb-md" data-sync="#slave-slide" data-sync-by="slide">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm" data-inject-slides="6"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<div id="slave-slide" class="yd_carousel sync loop" data-sync="#master-slide" data-sync-by="slide">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<hr style="margin: 40px 0; border: 1px solid #eee;">

<h3 class="test-title">TEST-045: Group Sync (Cross-Layout Translation)</h3>
<p style="font-size: 13px; color: #666;">
  Master moves 1 slide at a time. Slave automatically calculates which logical group contains that slide and jumps entire pages.
</p>

<div id="master-group" class="yd_carousel sync loop keyboard mb-md" data-sync="#slave-group" data-sync-by="group">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm" data-inject-slides="9"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<div id="slave-group" class="yd_carousel sync loop group-snap" data-sync="#master-group">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="9"></div>
  </div>
  <div class="yd_counter mt-sm"></div>
</div>

<hr style="margin: 40px 0; border: 1px solid #eee;">

<h3 class="test-title">TEST-046: Global Sync Group</h3>
<p style="font-size: 13px; color: #666;">Multiple completely disconnected carousels grouped by a shared data attribute.</p>

<div class="yd_carousel sync loop keyboard mb-md" data-sync-group="gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide"><div class="slide bg-main">A-1</div></div>
      <div class="yd_slide"><div class="slide bg-main">A-2</div></div>
      <div class="yd_slide"><div class="slide bg-main">A-3</div></div>
      <div class="yd_slide"><div class="slide bg-main">A-4</div></div>
    </div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<div class="yd_carousel sync loop mb-md" data-sync-group="gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide bg-sub">B-1</div></div>
      <div class="yd_slide"><div class="slide bg-sub">B-2</div></div>
      <div class="yd_slide"><div class="slide bg-sub">B-3</div></div>
      <div class="yd_slide"><div class="slide bg-sub">B-4</div></div>
    </div>
  </div>
</div>

<div class="yd_carousel sync loop" data-sync-group="gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm">
      <div class="yd_slide"><div class="slide bg-acnt">C-1</div></div>
      <div class="yd_slide"><div class="slide bg-acnt">C-2</div></div>
      <div class="yd_slide"><div class="slide bg-acnt">C-3</div></div>
      <div class="yd_slide"><div class="slide bg-acnt">C-4</div></div>
    </div>
  </div>
</div>


<!-- ==========================================
     SECTION 10: DYNAMIC API
=========================================== -->
<h2 class="section-title">SECTION 10: Dynamic API</h2>

<h3 class="test-title">TEST-048 to 054: addSlide, remove, batch</h3>
<div class="yd_carousel loop" id="test-dynamic">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide">
        <div class="slide">Start</div>
      </div>
    </div>
  </div>
  <div class="mt-sm flex-x">
    <button onclick="document.getElementById('test-dynamic').__ydCarousel.addSlide(`<div class='yd_slide'><div class='slide bg-acnt'>Add</div></div>`)">Add</button>
    <button onclick="document.getElementById('test-dynamic').__ydCarousel.removeSlide(0)">Remove Idx 0</button>
    <button onclick="document.getElementById('test-dynamic').__ydCarousel.removeAllSlides()">Clear</button>
    <button onclick="const api = document.getElementById('test-dynamic').__ydCarousel; api.batch(() => { api.addSlide(`<div class='yd_slide'><div class='slide'>B1</div></div>`); api.addSlide(`<div class='yd_slide'><div class='slide'>B2</div></div>`); })">Batch 2</button>
  </div>
</div>

<!-- ==========================================
     SECTION 11: LIFECYCLE
=========================================== -->
<h2 class="section-title">SECTION 11: Lifecycle</h2>

<h3 class="test-title">TEST-055 to 060: Pause, Resume, Freeze</h3>
<div class="yd_carousel autoplay loop" id="test-lifecycle" data-auto-visibility="true">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="mt-sm flex-x">
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.pause()">Pause</button>
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.resume()">Resume</button>
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.freeze()">Freeze</button>
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.unfreeze()">Unfreeze</button>
  </div>
</div>

<!-- ==========================================
     SECTION 12: DIAGNOSTICS
=========================================== -->
<h2 class="section-title">SECTION 12: Diagnostics</h2>

<h3 class="test-title">TEST-061 to 069: Console Prints</h3>
<div class="yd_carousel" id="test-diag">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="3"></div>
  </div>
  <div class="mt-sm flex-x f-wrap">
    <button onclick="console.log(document.getElementById('test-diag').__ydCarousel.health())">Health</button>
    <button onclick="console.log(document.getElementById('test-diag').__ydCarousel.state())">State</button>
    <button onclick="console.log(document.getElementById('test-diag').__ydCarousel.performanceStats())">Perf</button>
    <button onclick="console.log(document.getElementById('test-diag').__ydCarousel.dependencyReport())">Deps</button>
    <button onclick="console.log(document.getElementById('test-diag').__ydCarousel.xray())">X-Ray (Check Console)</button>
  </div>
</div>

<!-- ==========================================
     SECTION 13: DESTROY
=========================================== -->
<h2 class="section-title">SECTION 13: Destroy</h2>

<h3 class="test-title">TEST-070 to 073: Destroy & Cleanup</h3>
<div class="yd_carousel loop autoplay drag-free" id="test-destroy">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <button class="mt-sm" onclick="document.getElementById('test-destroy').__ydCarousel.destroy(); this.innerText='Destroyed!'">Destroy Engine</button>
</div>

<!-- ==========================================
     SECTION 14: STATE APIS
=========================================== -->
<h2 class="section-title">SECTION 14: State APIs</h2>

<h3 class="test-title">TEST-074 to 077: Export/Import/ReInit</h3>
<div class="yd_carousel" id="test-state-api">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="mt-sm flex-x">
    <button class="yd_prev">Prev</button> <button class="yd_next">Next</button>
    <button onclick="window.ydTmpState = document.getElementById('test-state-api').__ydCarousel.stateData(); alert('Exported Idx: ' + window.ydTmpState.currentIndex)">Export</button>
    <button onclick="document.getElementById('test-state-api').__ydCarousel.goToSlide(window.ydTmpState.currentIndex, true)">Import (Go To)</button>
    <button onclick="document.getElementById('test-state-api').__ydCarousel.refresh(true)">reInit (Refresh)</button>
  </div>
</div>

<!-- ==========================================
     SECTION 15: MIXED COMBINATIONS
=========================================== -->
<h2 class="section-title">SECTION 15: Mixed Combinations</h2>

<h3 class="test-title">TEST-078: Loop + DragFree + Autoplay</h3>
<div class="yd_carousel loop drag-free autoplay" id="test-078">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-079: Loop + RTL + Autoplay + Keyboard</h3>
<div class="yd_carousel loop rtl autoplay keyboard" id="test-079">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-080: Vertical + Autoplay + Keyboard</h3>
<div class="yd_carousel vertical autoplay keyboard" id="test-080">
  <div class="yd_viewport h-420px h-add-4px">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="5"></div>
  </div>
</div>

<h3 class="test-title">TEST-081: Loop + DragFree + AutoHeight</h3>
<div class="yd_carousel loop drag-free auto-height" id="test-081">
  <div class="yd_viewport" style="transition: height 0.3s">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide">
        <div class="slide" style="height: 100px;">100px</div>
      </div>
      <div class="yd_slide">
        <div class="slide" style="height: 250px;">250px</div>
      </div>
      <div class="yd_slide">
        <div class="slide" style="height: 150px;">150px</div>
      </div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-082: Loop + Autoplay + FocusOnChange + Keyboard</h3>
<div class="yd_carousel loop autoplay focus-on-change keyboard" id="test-082">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><button class="slide" style="width:100%">1</button></div>
      <div class="yd_slide"><button class="slide" style="width:100%">2</button></div>
      <div class="yd_slide"><button class="slide" style="width:100%">3</button></div>
      <div class="yd_slide"><button class="slide" style="width:100%">4</button></div>
    </div>
  </div>
</div>

<!-- ==========================================
     SECTION 16: MISSING AREAS (CRITICAL)
=========================================== -->
<h2 class="section-title" style="color: #dc3545;">SECTION 16: Empty & Single States</h2>

<h3 class="test-title">TEST-083: Empty Carousel (0 Slides)</h3>
<div class="yd_carousel" id="test-083">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm"></div>
  </div>
</div>

<h3 class="test-title">TEST-084: Empty Carousel + Loop</h3>
<div class="yd_carousel loop" id="test-084">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm"></div>
  </div>
</div>

<h3 class="test-title">TEST-085: Empty Carousel + Autoplay</h3>
<div class="yd_carousel autoplay" id="test-085">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm"></div>
  </div>
</div>

<h3 class="test-title">TEST-086: Single Slide</h3>
<div class="yd_carousel" id="test-086">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide">
        <div class="slide">Solo</div>
      </div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-087: Single Slide + Loop</h3>
<div class="yd_carousel loop" id="test-087">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide">
        <div class="slide">Solo</div>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     SECTION 17: AUTO HEIGHT
=========================================== -->
<h2 class="section-title">SECTION 17: Auto Height</h2>

<h3 class="test-title">TEST-090: Auto Height Basic</h3>
<div class="yd_carousel auto-height" id="test-090">
  <div class="yd_viewport" style="transition: height 0.3s">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide">
        <div class="slide" style="height:100px;">100</div>
      </div>
      <div class="yd_slide">
        <div class="slide" style="height:200px;">200</div>
      </div>
    </div>
  </div>
  <button class="yd_next mt-sm">Next</button>
</div>

<h3 class="test-title">TEST-091: Auto Height + Loop</h3>
<div class="yd_carousel loop auto-height" id="test-091">
  <div class="yd_viewport" style="transition: height 0.3s">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide">
        <div class="slide" style="height:150px;">150</div>
      </div>
      <div class="yd_slide">
        <div class="slide" style="height:300px;">300</div>
      </div>
    </div>
  </div>
  <button class="yd_next mt-sm">Next</button>
</div>

<!-- ==========================================
     SECTION 18: MULTIPLE INSTANCES
=========================================== -->
<h2 class="section-title">SECTION 18: Multiple Instances</h2>

<h3 class="test-title">TEST-094 to 096: Grid Rendering Stability</h3>
<div class="of-x-scroll">
  <div id="multiple-instances-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;"></div>
</div>
<script>
  const multiContainer = document.getElementById('multiple-instances-container');
  let multiHtml = '';
  for (let i = 0; i < 2; i++) {
    const isLoop = i % 3 === 0 ? 'loop' : '';
    const isAuto = i % 2 === 0 ? 'autoplay' : '';
    multiHtml += `
      <div class="yd_carousel ${isLoop} ${isAuto} slide-snap">
        <div class="yd_viewport"><div class="yd_container slides-2 gap-sm" data-inject-slides="3"></div></div>
      </div>`;
  }
  multiContainer.innerHTML = multiHtml;
</script>

<!-- ==========================================
     SECTION 19: VIRTUAL RENDERER
=========================================== -->
<h2 class="section-title">SECTION 19: Virtual Renderer</h2>

<h3 class="test-title">TEST-097: Virtual Renderer (100 Slides)</h3>
<div class="yd_carousel" data-renderer="virtual" data-virtual-total="100" data-virtual-render="qaVirtualRender" id="test-097">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm"></div>
  </div>
  <div class="yd_scrollbar mt-sm">
    <div class="yd_scrollbar-thumb"></div>
  </div>
</div>

<h3 class="test-title">TEST-098: Virtual Renderer (1000 Slides)</h3>
<div class="yd_carousel" data-renderer="virtual" data-virtual-total="1000" data-virtual-render="qaVirtualRender" id="test-098">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-099: Virtual Renderer + Loop (1000 Slides)</h3>
<div class="yd_carousel loop" data-renderer="virtual" data-virtual-total="1000" data-virtual-render="qaVirtualRender" id="test-099">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 20: STRESS TESTS
=========================================== -->
<h2 class="section-title">SECTION 20: Stress Tests</h2>

<h3 class="test-title">TEST-103 to 105: Native DOM Overload</h3>
<div class="yd_carousel drag-free" id="test-stress-dom">
  <div class="yd_viewport">
    <div class="yd_container slides-5 gap-sm" data-inject-slides="500"></div>
  </div>
</div>
<p style="font-size:13px; color:#6c757d;">Note: Injected 500 nodes physically into the DOM to test mutation and event stability.</p>

<!-- ==========================================
     SECTION 21: REGISTRY TESTS
=========================================== -->
<h2 class="section-title">SECTION 21: Registry Tests</h2>

<div class="p-md bg-main" style="border-radius: 8px;">
  <div class="flex-x f-wrap">
    <button onclick="alert('Instances: ' + CarouselRegistry._instances.size)">Check Active Instances</button>
    <button onclick="alert('Keyboard Target: ' + (CarouselRegistry.activeCarousel && CarouselRegistry.activeCarousel.root.id ? CarouselRegistry.activeCarousel.root.id : 'None'))">Check Keyboard Target</button>
  </div>
</div>

<!-- ==========================================
     SECTION 22: OBSERVER TESTS
=========================================== -->
<h2 class="section-title">SECTION 22: Observer Tests</h2>

<h3 class="test-title">TEST-113 to 117: Resize, Hide/Show & Freezing</h3>
<div class="yd_carousel autoplay drag-free" id="test-obs">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="8"></div>
  </div>
  <div class="mt-sm flex-x">
    <button onclick="document.getElementById('test-obs').style.width = '50%' ">Shrink Width (Test ResizeOb)</button>
    <button onclick="document.getElementById('test-obs').style.width = '100%' ">Reset Width</button>
  </div>
</div>

<!-- ==========================================
     SECTION 23: EVENT SYSTEM
=========================================== -->
<h2 class="section-title">SECTION 23: Event System</h2>

<h3 class="test-title">TEST-118 to 123: Wildcard & Stats</h3>
<div class="yd_carousel loop" id="test-events">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="mt-sm flex-x">
    <button class="yd_prev">Prev</button> <button class="yd_next">Next</button>
  </div>
</div>

<!-- ==========================================
     SECTION 24: AUTOPLAY CONFIGURATIONS
=========================================== -->
<h2 class="section-title">SECTION 24: Autoplay Configurations</h2>

<h3 class="test-title">TEST-124: Autoplay Delay (Fast vs Slow)</h3>
<h4>Fast (300ms Delay)</h4>
<div class="yd_carousel autoplay" data-delay="300">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>
<h4 class="mt-sm">Slow (8000ms Delay)</h4>
<div class="yd_carousel autoplay" data-delay="8000">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
</div>

<h3 class="test-title">TEST-125: Autoplay Runtime Direction Toggle</h3>
<div class="yd_carousel autoplay loop" id="test-125" data-delay="1000">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="6"></div>
  </div>
  <p style="font-size: 13px; color: #6c757d;" id="test-125-status">Direction: forward</p>
</div>
<script>
  setTimeout(() => {
    const api = document.getElementById('test-125').__ydCarousel;
    const statusText = document.getElementById('test-125-status');
    setInterval(() => {
      if (!api || api.isDestroyed()) return;
      const current = api.autoplayApi.getDirection();
      const nextDir = current === 'forward' ? 'backward' : 'forward';
      api.autoplayApi.setDirection(nextDir);
      statusText.innerText = `Direction toggled dynamically to: ${nextDir}`;
    }, 4000);
  }, 500);
</script>


<!-- ==========================================
     SECTION 25: PHYSICS & ANIMATION SPEED
=========================================== -->
<h2 class="section-title">SECTION 25: Physics & Animation Speed</h2>

<h3 class="test-title">TEST-126: Animation Speed (Duration)</h3>
<h4>Instant-ish (data-duration="0.8")</h4>
<div class="yd_carousel" data-duration="0.8">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h4>Slow Cinematic (data-duration="0.03")</h4>
<div class="yd_carousel" data-duration="0.03">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-127: Drag Inertia</h3>
<h4>Weak Inertia (data-drag-inertia="10")</h4>
<div class="yd_carousel drag-free" data-drag-inertia="10">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="8"></div>
  </div>
</div>

<h4>Extreme Inertia (data-drag-inertia="250")</h4>
<div class="yd_carousel drag-free" data-drag-inertia="250">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="15"></div>
  </div>
  <p style="font-size: 12px;">Flick hard. It will keep sliding.</p>
</div>

<h3 class="test-title">TEST-128: Friction (Decay)</h3>
<h4>Stops Quickly (data-friction="0.75")</h4>
<div class="yd_carousel drag-free" data-friction="0.75" data-drag-inertia="100">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="10"></div>
  </div>
</div>

<h4>Crazy Glide (data-friction="0.995")</h4>
<div class="yd_carousel drag-free" data-friction="0.995" data-drag-inertia="80">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="20"></div>
  </div>
</div>

<!-- ==========================================
     SECTION 26: INPUT THRESHOLDS
=========================================== -->
<h2 class="section-title">SECTION 26: Input Thresholds</h2>

<h3 class="test-title">TEST-129: Velocity Threshold</h3>
<div class="yd_carousel" data-velocity-threshold="1.5">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="5"></div>
  </div>
  <p style="font-size: 13px; color: #6c757d;">Strict Threshold (1.5). You must flick very fast to advance the slide.</p>
</div>

<h3 class="test-title">TEST-130: Drag Threshold</h3>
<div class="yd_carousel" data-drag-threshold="30">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="5"></div>
  </div>
  <p style="font-size: 13px; color: #6c757d;">Touch-Safe (30). You must drag significantly horizontally before it takes over pointer events.</p>
</div>

<h3 class="test-title">TEST-131: Wheel Threshold</h3>
<div class="yd_carousel wheel" data-wheel-threshold="150">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="5"></div>
  </div>
  <p style="font-size: 13px; color: #6c757d;">Strict Wheel (150). Takes a heavy trackpad/mouse scroll to trigger.</p>
</div>


<!-- ==========================================
     SECTION 27: EXTREME QA PROFILES & STRESS
=========================================== -->
<h2 class="section-title">SECTION 27: Extreme QA Profiles</h2>

<h3 class="test-title">TEST-132: Arcade Mode</h3>
<div class="yd_carousel drag-free autoplay loop" data-delay="500" data-duration="0.5" data-drag-inertia="150" data-friction="0.98">
  <div class="yd_viewport">
    <div class="yd_container slides-4 gap-sm" data-inject-slides="12"></div>
  </div>
  <div class="yd_progress mt-sm">
    <div class="yd_progress-fill"></div>
  </div>
</div>

<h3 class="test-title">TEST-133: Stress Test Mode</h3>
<div class="yd_carousel drag-free autoplay loop" data-delay="100" data-duration="1" data-drag-inertia="300" data-friction="0.995">
  <div class="yd_viewport">
    <div class="yd_container slides-5 gap-sm" data-inject-slides="15"></div>
  </div>
</div>

<h3 class="test-title">TEST-134: Slow Motion Debug Mode</h3>
<div class="yd_carousel drag-free loop" data-delay="10000" data-duration="0.01" data-drag-inertia="5" data-friction="0.6">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
  <div class="mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-135: Loop Breaker Test</h3>
<div class="yd_carousel loop drag-free autoplay" data-delay="100" data-duration="0.8" data-friction="0.999" data-drag-inertia="500">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="8"></div>
  </div>
  <p style="font-size: 13px; color: #6c757d;">Designed to force rapid-fire boundary wrap evaluations simultaneously against intense drag inertia.</p>
</div>

<h3 class="test-title" style="color: #dc3545;">TEST-136: The Final Boss (Production Validation Pass)</h3>
<div class="yd_carousel loop drag-free autoplay keyboard wheel" data-delay="500" data-duration="0.4" data-friction="0.98" data-drag-inertia="150" data-velocity-threshold="0.1">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-md" data-inject-slides="10"></div>
  </div>
  <div class="mt-sm flex-x"><button class="yd_prev">Prev</button><button class="yd_next">Next</button>
    <div class="yd_dots"></div>
  </div>
  <div class="yd_scrollbar mt-sm">
    <div class="yd_scrollbar-thumb"></div>
  </div>
</div>
<p style="font-size: 14px; font-weight: 500; color: #dc3545;">Contains: Loop, Drag-Free, Autoplay, Keyboard, Wheel, Custom Physics, Custom Delays, and full Plugin Stack.</p>