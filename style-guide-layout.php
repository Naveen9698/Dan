<style>
  [data-ut="guide-nav"] a.active {
    color: hsl(245, 100%, 68%);
    font-weight: 600;
    background: hsl(221 83% 95%);
  }
</style>

<aside class="w-10p w-add-5p bg-white of-y-auto h-100vh pn-sticky t-0" data-ut="guide-nav">
  <h2 class="fz-18 fw-700 clr-g9 py-xxs bg-g1 txt-center">System Guide</h2>

  <div class="pa-xs flex-y">
    <a class="fz-16 mb-xxs px-xs py-xxs ra-xxs fw-500 active" href="#slider">Slider</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Getting Started</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#default">Default Carousel</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#previous-next-buttons">Previous / Next</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#pagination-dots">Pagination Dots</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#snap-counter">Snap Counter (1 / 5)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#scrollbar">Scrollbar</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#progress-indicators">Progress Indicators</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Navigation</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#click-to-scroll-api">Click-to-scroll API</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#keyboard-navigation">Keyboard Navigation</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#focus-navigation">Focus Navigation</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#tab-navigation">Tab Navigation</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Interaction</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#mouse-dragging">Mouse Dragging</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#touch-swiping">Touch Swiping</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#trackpad-gestures">Trackpad Gestures</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#disable-drag-gesture">Disable Drag / Gesture Control (watchDrag)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#drag-free-scrolling">Drag-Free Scrolling</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#drag-threshold">Drag Threshold</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#scrollbar-interaction">Scrollbar Interaction</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Layout</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#vertical-axis">Vertical Axis (axis: 'y')</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#right-to-left">Right-to-Left (RTL) Direction</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#alignment">Alignment (start / center / end)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#variable-slide-widths">Variable Slide Widths</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#slides-per-view">Slides Per View (Responsive Simulation)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#breakpoint">Breakpoint-Based Configuration</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#responsive-resizing">Responsive Resizing Support</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#auto-height-adjustment">Auto Height Adjustment</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Behavior</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#looping">Looping (Infinite Scroll)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#start-index">Start Index</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#slides-per-scroll">Slides per Scroll</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#skip-snaps">Skip Snaps</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#contain-scroll-trimsnaps">Contain Scroll — trimSnaps</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#contain-scroll-keepsnaps">Contain Scroll — keepSnaps</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#contain-scroll-off">Contain Scroll — off</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Autoplay</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#autoplay">Autoplay</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#autoplay-looped">Autoplay looped</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#play-pause-autoplay">Play / Pause Autoplay Controls</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#autoplay-behavior">Autoplay Behavior Controls</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#stop-on-hover">Stop on Hover</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#marquee">Marquee / Continuous Scrolling Mode (CSS)</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Components</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#pagination-dots-looped">Pagination Dots Looped</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#section-controlled-navigation">Section-controlled Navigation</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#progress-bar-indicator">Progress Bar Indicator</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Effects</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#fade-transitions">Fade Transitions</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#scale-active-slide">Scale Active Slide</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#opacity-emphasis">Opacity Emphasis</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#parallax-effects">Parallax Effects</a>

    <a class="fz-14 clr-g8 px-xs py-xxs ra-xxs cur-auto">Advanced</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#class-based-state-styling">Class-based State Styling</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#custom-animation-timing">Custom Animation Timing</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#hardware-accelerated-transforms">Hardware-accelerated Transforms</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs ml-xs" href="#reduced-motion-friendly-behavior">Reduced Motion Friendly Behavior</a>




    <a class="fz-16 mb-xxs px-xs py-xxs ra-xxs fw-500 clr-g4" href="#base">Base</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#aspect-ratio-system">Aspect Ratio</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#border-system">Border</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#color-system">Color</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#cursor-system">Cursor</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#display-system">Display</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#flex-system">Flex(Display)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#grid-system">Grid(Display)</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#filter-system">Filter</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#height-system">Height</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#list-system">List</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#margin-auto-system">Margin Auto</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#object-system">Object</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#offset-system">Offset</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#opacity-system">Opacity</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#order-system">Order</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#overflow-system">Overflow</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#pointer-events-system">Pointer Events</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#position-system">Position</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#radius-system">Radius</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#resize-system">Resize</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#shadow-system">Shadow</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#space-system">Space</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#text-system">Text</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#transform-system">Transform</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#transition-system">Transition</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#typography-system">Typography</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#user-select-system">User Select</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#visibility-system">Visibility</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#width-system">Width</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#z-index-system">Z-Index</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#backdrop-filter-system">Animate</a>
  </div>
  <div class="pa-xs flex-y">
    <a class="fz-18 mb-xxs ml-xxs fw-500 clr-g4 px-xs cur-pointer py-xxs ra-xxs" href="#interactions">Inter</a>
    <a class="fz-16 mb-xxs ml-xs fw-500 clr-g4 px-xs cur-pointer py-xxs ra-xxs" href="#states-interactions">states</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#states-pseudo-interactions">Pseudo</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#states-class-interactions">Class</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#toggle-popup">Popup</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#toggle-dropdown">Dropdown</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#toggle-accordion">Accordion</a>
    <a class="fz-12 mb-xxs ml-xs fw-500 clr-g4">Hover</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#hover-tooltip">Tooltip</a>
    <a class="fz-12 mb-xxs ml-xs fw-500 clr-g4">Navigation</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#navigation-scroll">Scroll</a>
    <a class="fz-12 clr-g8 px-xs py-xxs ra-xxs" href="#navigation-scrollspy">Scroll Spy</a>
  </div>
</aside>