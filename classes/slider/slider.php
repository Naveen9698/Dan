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


<!-- REQUIRED CSS FOR THUMBNAIL HIGHLIGHTING -->
<style>
  .yd_carousel-thumbnail-mode .yd_slide { transition: opacity 0.2s; opacity: 0.4; cursor: pointer; }
  .yd_carousel-thumbnail-mode .yd_slide:hover { opacity: 0.8; }
  .yd_carousel-thumbnail-mode .yd_slide.active { opacity: 1; transform: scale(1.02); transition: transform 0.2s; }
  .yd_carousel-thumbnail-mode .yd_slide.active .slide { border-color: currentColor; background-color: #f0f0f0; }
</style>

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
  <div class="yd_controles mt-sm flex-x">
    <button onclick="document.getElementById('test-034').__ydCarousel.autoplayApi.play()">Play</button>
    <button onclick="document.getElementById('test-034').__ydCarousel.autoplayApi.pause()">Pause</button>
    <button onclick="document.getElementById('test-034').__ydCarousel.autoplayApi.stop()">Stop</button>
  </div>
</div>


<h2 class="section-title">SECTION 07: Plugins</h2>

<h3 class="test-title">TEST-035: Controls</h3>
<div class="yd_carousel" id="test-035">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-036: Dots</h3>
<div class="yd_carousel" id="test-036">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm"><div class="yd_dots flex-x"></div></div>
</div>

<h3 class="test-title">TEST-037: Counter</h3>
<div class="yd_carousel" id="test-037">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm"><div class="yd_counter"><span class="yd_current"></span> / <span class="yd_total"></span></div></div>
</div>

<h3 class="test-title">TEST-038: Progress</h3>
<div class="yd_carousel" id="test-038">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm">
    <div class="yd_progress" style="width: 100%; height: 4px; background: #eee;">
      <div class="yd_progress-fill" style="height: 100%; background: #333; width: var(--progress);"></div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-039: Interactive Scrollbar</h3>
<div class="yd_carousel" id="test-039">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
  <div class="yd_controles mt-sm">
    <div class="yd_scrollbar" style="width: 100%; height: 8px; background: #eee; border-radius: 4px; position:relative; cursor:pointer;">
      <div class="yd_scrollbar-thumb" style="height: 100%; background: #666; border-radius: 4px; position:absolute; top:0; left:0; cursor:grab;"></div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-040: Full Plugin Stack</h3>
<div class="yd_carousel" id="test-040">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="6"></div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button class="yd_prev">Prev</button><button class="yd_next">Next</button>
    <div class="yd_dots flex-x ml-sm"></div>
    <div class="yd_counter ml-sm"><span class="yd_current"></span> / <span class="yd_total"></span></div>
  </div>
  <div class="yd_controles mt-sm">
    <div class="yd_progress" style="width: 100%; height: 4px; background: #eee;"><div class="yd_progress-fill" style="height: 100%; background: #333; width: var(--progress);"></div></div>
  </div>
  <div class="yd_controles mt-sm">
    <div class="yd_scrollbar" style="width: 100%; height: 8px; background: #eee; border-radius: 4px; position:relative; cursor:pointer;">
      <div class="yd_scrollbar-thumb" style="height: 100%; background: #666; border-radius: 4px; position:absolute; top:0; left:0;"></div>
    </div>
  </div>
</div>


<h2 class="section-title">SECTION 08: Hash</h2>

<h3 class="test-title">TEST-041: Hash Basic</h3>
<div class="yd_carousel hash" id="test-041">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md" data-hash="h1"><h2 class="slide">#h1</h2></div>
      <div class="yd_slide ac:blur-md" data-hash="h2"><h2 class="slide">#h2</h2></div>
      <div class="yd_slide ac:blur-md" data-hash="h3"><h2 class="slide">#h3</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-042: Hash Groups</h3>
<div class="yd_carousel hash" data-hash-group="gallery" id="test-042">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md" data-hash="img1"><h2 class="slide">#gallery:img1</h2></div>
      <div class="yd_slide ac:blur-md" data-hash="img2"><h2 class="slide">#gallery:img2</h2></div>
      <div class="yd_slide ac:blur-md" data-hash="img3"><h2 class="slide">#gallery:img3</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>


<h2 class="section-title">SECTION 09: Sync (Microkernel Architecture)</h2>

<h3 class="test-title" id="test-043">TEST-043: Swiper-Style Thumbnail Gallery (Bidirectional)</h3>
<!-- MASTER HERO -->
<div class="yd_carousel sync loop drag-free keyboard" data-sync-group="qa-gallery-1">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">Hero 1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">Hero 2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">Hero 3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">Hero 4</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">Hero 5</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">Hero 6</h2></div>
    </div>
  </div>
</div>

<!-- THUMBNAIL SLAVE -->
<div class="yd_carousel sync loop align-center mt-sm" data-sync-group="qa-gallery-1" data-sync-role="thumbnail">
  <div class="yd_viewport">
    <div class="yd_container slides-4 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide fz-14">Thumb 1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide fz-14">Thumb 2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide fz-14">Thumb 3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide fz-14">Thumb 4</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide fz-14">Thumb 5</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide fz-14">Thumb 6</h2></div>
    </div>
  </div>
</div>

<br>

<h3 class="test-title" id="test-044">TEST-044: Standard Slide Sync (1:1 Bidirectional)</h3>
<div id="master-slide" class="yd_carousel loop keyboard sync" data-sync="#slave-slide" data-sync-by="slide">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">4</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">5</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">6</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm">
    <button class="yd_prev">Prev</button>
    <button class="yd_next">Next</button>
    <div class="yd_counter"><span class="yd_current"></span> / <span class="yd_total"></span></div>
  </div>
</div>

<div id="slave-slide" class="yd_carousel loop sync mt-sm" data-sync="#master-slide" data-sync-by="slide">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">4</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">5</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">6</h2></div>
    </div>
  </div>
</div>

<br>

<h3 class="test-title" id="test-045">TEST-045: Group Sync (Cross-Layout)</h3>
<div id="master-group" class="yd_carousel loop keyboard sync" data-sync="#slave-group" data-sync-by="group">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm" data-inject-slides="9"></div>
  </div>
  <div class="yd_controles mt-sm">
    <button class="yd_prev">Prev</button>
    <button class="yd_next">Next</button>
  </div>
</div>

<div id="slave-group" class="yd_carousel loop sync group-snap mt-sm" data-sync="#master-group">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="9"></div>
  </div>
</div>

<br>

<h3 class="test-title" id="test-046">TEST-046: Global Sync Group</h3>
<div class="yd_carousel loop sync keyboard" data-sync-group="global-gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">A1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">A2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">A3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">A4</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<div class="yd_carousel loop sync mt-sm" data-sync-group="global-gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">B1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">B2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">B3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">B4</h2></div>
    </div>
  </div>
</div>

<div class="yd_carousel loop sync mt-sm" data-sync-group="global-gallery">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">C1</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">C2</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">C3</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide">C4</h2></div>
    </div>
  </div>
</div>


<h2 class="section-title">SECTION 10: Dynamic API</h2>

<h3 class="test-title" id="test-dynamic">TEST-048 to 054: addSlide, remove, batch</h3>
<div class="yd_carousel loop" id="test-dynamic-target">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">Start</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button onclick="document.getElementById('test-dynamic-target').__ydCarousel.addSlide(`<div class='yd_slide ac:blur-md'><h2 class='slide'>Add</h2></div>`)">Add</button>
    <button onclick="document.getElementById('test-dynamic-target').__ydCarousel.removeSlide(0)">Remove Idx 0</button>
    <button onclick="document.getElementById('test-dynamic-target').__ydCarousel.removeAllSlides()">Clear</button>
    <button onclick="const api = document.getElementById('test-dynamic-target').__ydCarousel; api.batch(() => { api.addSlide(`<div class='yd_slide ac:blur-md'><h2 class='slide'>B1</h2></div>`); api.addSlide(`<div class='yd_slide ac:blur-md'><h2 class='slide'>B2</h2></div>`); })">Batch 2</button>
  </div>
</div>


<h2 class="section-title">SECTION 11: Lifecycle</h2>

<h3 class="test-title">TEST-055 to 060: Pause, Resume, Freeze</h3>
<div class="yd_carousel autoplay loop" id="test-lifecycle" data-auto-visibility="true">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.pause()">Pause</button>
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.resume()">Resume</button>
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.freeze()">Freeze</button>
    <button onclick="document.getElementById('test-lifecycle').__ydCarousel.unfreeze()">Unfreeze</button>
  </div>
</div>


<h2 class="section-title">SECTION 12: Diagnostics</h2>

<h3 class="test-title" id="test-diag">TEST-061 to 069: Console Prints</h3>
<div class="yd_carousel" id="test-diag-target">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="3"></div>
  </div>
  <div class="yd_controles mt-sm flex-x f-wrap">
    <button onclick="console.log(document.getElementById('test-diag-target').__ydCarousel.health())">Health</button>
    <button onclick="console.log(document.getElementById('test-diag-target').__ydCarousel.state())">State</button>
    <button onclick="console.log(document.getElementById('test-diag-target').__ydCarousel.performanceStats())">Perf</button>
    <button onclick="console.log(document.getElementById('test-diag-target').__ydCarousel.dependencyReport())">Deps</button>
    <button onclick="console.log(document.getElementById('test-diag-target').__ydCarousel.xray())">X-Ray (Check Console)</button>
  </div>
</div>


<h2 class="section-title">SECTION 13: Destroy</h2>

<h3 class="test-title">TEST-070 to 073: Destroy & Cleanup</h3>
<div class="yd_carousel loop autoplay drag-free" id="test-destroy">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm">
    <button onclick="document.getElementById('test-destroy').__ydCarousel.destroy(); this.innerText='Destroyed!'">Destroy Engine</button>
  </div>
</div>


<h2 class="section-title">SECTION 14: State APIs</h2>

<h3 class="test-title">TEST-074 to 077: Export/Import/ReInit</h3>
<div class="yd_carousel" id="test-state-api">
  <div class="yd_viewport">
    <div class="yd_container slides-1 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button class="yd_prev">Prev</button> <button class="yd_next">Next</button>
    <button onclick="window.ydTmpState = document.getElementById('test-state-api').__ydCarousel.stateData(); alert('Exported Idx: ' + window.ydTmpState.currentIndex)">Export</button>
    <button onclick="document.getElementById('test-state-api').__ydCarousel.goToSlide(window.ydTmpState.currentIndex, true)">Import (Go To)</button>
    <button onclick="document.getElementById('test-state-api').__ydCarousel.refresh(true)">reInit (Refresh)</button>
  </div>
</div>


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
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height: 100px;">100px</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height: 250px;">250px</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height: 150px;">150px</h2></div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-082: Loop + Autoplay + FocusOnChange + Keyboard</h3>
<div class="yd_carousel loop autoplay focus-on-change keyboard" id="test-082">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide ac:blur-md"><button class="slide" style="width:100%">1</button></div>
      <div class="yd_slide ac:blur-md"><button class="slide" style="width:100%">2</button></div>
      <div class="yd_slide ac:blur-md"><button class="slide" style="width:100%">3</button></div>
      <div class="yd_slide ac:blur-md"><button class="slide" style="width:100%">4</button></div>
    </div>
  </div>
</div>


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
      <div class="yd_slide ac:blur-md"><h2 class="slide">Solo</h2></div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-087: Single Slide + Loop</h3>
<div class="yd_carousel loop" id="test-087">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide">Solo</h2></div>
    </div>
  </div>
</div>


<h2 class="section-title">SECTION 17: Auto Height</h2>

<h3 class="test-title">TEST-090: Auto Height Basic</h3>
<div class="yd_carousel auto-height" id="test-090">
  <div class="yd_viewport" style="transition: height 0.3s">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height:100px;">100</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height:200px;">200</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-091: Auto Height + Loop</h3>
<div class="yd_carousel loop auto-height" id="test-091">
  <div class="yd_viewport" style="transition: height 0.3s">
    <div class="yd_container slides-1 gap-sm">
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height:150px;">150</h2></div>
      <div class="yd_slide ac:blur-md"><h2 class="slide" style="height:300px;">300</h2></div>
    </div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_next">Next</button></div>
</div>


<h2 class="section-title">SECTION 18: Multiple Instances</h2>

<h3 class="test-title">TEST-094 to 096: Grid Rendering Stability</h3>
<div class="of-x-scroll">
  <div id="multiple-instances-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;"></div>
</div>


<h2 class="section-title">SECTION 19: Virtual Renderer</h2>

<h3 class="test-title" id="test-097">TEST-097: Virtual Renderer (100,000 Slides)</h3>
<div class="yd_carousel loop drag-free" data-renderer="virtual" data-virtual-total="100000" data-virtual-render="qaVirtualRender">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm"></div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button class="yd_prev">Prev</button> <button class="yd_next">Next</button>
    <div class="yd_scrollbar ml-xs" style="width: 100px; height: 8px; background: #eee; border-radius: 4px; position:relative; cursor:pointer;">
      <div class="yd_scrollbar-thumb" style="height: 100%; background: #666; border-radius: 4px; position:absolute; top:0; left:0; cursor:grab;"></div>
    </div>
  </div>
</div>

<h3 class="test-title">TEST-098: Virtual Renderer (1000 Slides)</h3>
<div class="yd_carousel" data-renderer="virtual" data-virtual-total="1000" data-virtual-render="qaVirtualRender">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm"></div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h3 class="test-title">TEST-099: Virtual Renderer + Loop (1000 Slides)</h3>
<div class="yd_carousel loop" data-renderer="virtual" data-virtual-total="1000" data-virtual-render="qaVirtualRender">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm"></div>
  </div>
</div>


<h2 class="section-title">SECTION 20: DOM Stress Tests</h2>

<h3 class="test-title" id="test-stress-dom">TEST-103 to 105: Native DOM Overload</h3>
<div class="yd_carousel drag-free">
  <div class="yd_viewport">
    <div class="yd_container slides-5 gap-sm" data-inject-slides="500"></div>
  </div>
</div>
<p style="font-size:13px; color:#6c757d;">Note: Injected 500 nodes physically into the DOM to test mutation and event stability.</p>


<h2 class="section-title">SECTION 21: Registry Tests</h2>

<div class="yd_controles mt-sm flex-x f-wrap">
  <button onclick="alert('Instances: ' + CarouselRegistry._instances.size)">Check Active Instances</button>
  <button onclick="alert('Keyboard Target: ' + (CarouselRegistry.activeCarousel && CarouselRegistry.activeCarousel.root.id ? CarouselRegistry.activeCarousel.root.id : 'None'))">Check Keyboard Target</button>
</div>


<h2 class="section-title">SECTION 22: Observer Tests</h2>

<h3 class="test-title">TEST-113 to 117: Resize, Hide/Show & Freezing</h3>
<div class="yd_carousel autoplay drag-free" id="test-obs">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="8"></div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button onclick="document.getElementById('test-obs').style.width = '50%' ">Shrink Width</button>
    <button onclick="document.getElementById('test-obs').style.width = '100%' ">Reset Width</button>
  </div>
</div>


<h2 class="section-title">SECTION 23: Event System</h2>

<h3 class="test-title">TEST-118 to 123: Wildcard & Stats</h3>
<div class="yd_carousel loop">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm" data-inject-slides="4"></div>
  </div>
  <div class="yd_controles mt-sm flex-x">
    <button class="yd_prev">Prev</button> <button class="yd_next">Next</button>
  </div>
</div>


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
</div>
<p style="font-size: 13px; color: #6c757d;" id="test-125-status">Direction: forward</p>
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


<h2 class="section-title">SECTION 25: Physics & Animation Speed</h2>

<h3 class="test-title">TEST-126: Animation Speed (Duration)</h3>
<h4>Instant-ish (data-duration="0.8")</h4>
<div class="yd_carousel" data-duration="0.8">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
</div>

<h4>Slow Cinematic (data-duration="0.03")</h4>
<div class="yd_carousel" data-duration="0.03">
  <div class="yd_viewport">
    <div class="yd_container slides-3 gap-sm" data-inject-slides="5"></div>
  </div>
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
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


<h2 class="section-title">SECTION 27: Extreme QA Profiles</h2>

<h3 class="test-title">TEST-132: Arcade Mode</h3>
<div class="yd_carousel drag-free autoplay loop" data-delay="500" data-duration="0.5" data-drag-inertia="150" data-friction="0.98">
  <div class="yd_viewport">
    <div class="yd_container slides-4 gap-sm" data-inject-slides="12"></div>
  </div>
  <div class="yd_controles mt-sm">
    <div class="yd_progress" style="width: 100%; height: 4px; background: #eee;">
      <div class="yd_progress-fill" style="height: 100%; background: #333; width: var(--progress);"></div>
    </div>
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
  <div class="yd_controles mt-sm"><button class="yd_prev">Prev</button> <button class="yd_next">Next</button></div>
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
  <div class="yd_controles mt-sm flex-x">
    <button class="yd_prev">Prev</button><button class="yd_next">Next</button>
    <div class="yd_dots flex-x ml-sm"></div>
  </div>
  <div class="yd_controles mt-sm">
    <div class="yd_scrollbar" style="width: 100%; height: 8px; background: #eee; border-radius: 4px; position:relative; cursor:pointer;">
      <div class="yd_scrollbar-thumb" style="height: 100%; background: #666; border-radius: 4px; position:absolute; top:0; left:0; cursor:grab;"></div>
    </div>
  </div>
</div>
<p style="font-size: 14px; font-weight: 500; color: #dc3545;">Contains: Loop, Drag-Free, Autoplay, Keyboard, Wheel, Custom Physics, Custom Delays, and full Plugin Stack.</p>


<!-- ==========================================
     DOM INJECTION SCRIPTS
========================================== -->
<script>
  // 1. Virtual Renderer Callback
  window.qaVirtualRender = function(idx) {
    const hue = (idx * 25) % 360;
    return `<h2 class="slide" style="background-color: hsl(${hue}, 70%, 85%); color: #333; border-color: hsl(${hue}, 70%, 60%)">${idx + 1}</h2>`;
  };

  // 2. Stress Test DOM Populator
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-inject-slides]').forEach(el => {
      const count = parseInt(el.getAttribute('data-inject-slides'), 10);
      let html = '';
      for (let i = 0; i < count; i++) {
        html += `<div class="yd_slide ac:blur-md"><h2 class="slide">${i+1}</h2></div>`;
      }
      el.innerHTML = html;
    });

    // 3. Render Multiple Instances Grid (Section 18)
    const multiContainer = document.getElementById('multiple-instances-container');
    if (multiContainer) {
      let multiHtml = '';
      for (let i = 0; i < 4; i++) {
        const isLoop = i % 2 === 0 ? 'loop' : '';
        const isAuto = i % 3 === 0 ? 'autoplay' : '';
        multiHtml += `
          <div class="yd_carousel ${isLoop} ${isAuto} slide-snap">
            <div class="yd_viewport"><div class="yd_container slides-2 gap-sm">
              <div class="yd_slide ac:blur-md"><h2 class="slide">1</h2></div>
              <div class="yd_slide ac:blur-md"><h2 class="slide">2</h2></div>
              <div class="yd_slide ac:blur-md"><h2 class="slide">3</h2></div>
            </div></div>
          </div>`;
      }
      multiContainer.innerHTML = multiHtml;
    }
    
    // Auto-init the carousels after injecting DOM
    if (typeof ydCarousel !== 'undefined') {
      ydCarousel.startAutoInit();
    }
  });
</script>

