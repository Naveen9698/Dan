<style>
  .d-app {
    display: flex;
    min-height: 100vh;
    background: #f5f6f8;
  }

  .d-sidebar {
    width: 260px;
    background: #ffffff;
    border-right: 1px solid #e5e7eb;
    padding: 24px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
  }

  .d-sidebar {
    scrollbar-width: thin;
  }

  .d-sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .d-sidebar::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
  }


  .d-sidebar .d-h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #111;
  }

  .d-nav-group {
    margin-bottom: 28px;
  }

  .d-nav-group .d-h3 {
    font-size: 13px;
    letter-spacing: 0.5em;
    text-transform: uppercase;
    color: #6b7280;
    margin-bottom: 12px;
  }

  .d-h2.demo {
    font-size: 28px;
    font-weight: 600;
    color: #111827;
    background: #bdbdbd;
    text-align: center;
    padding: 10px 0 15px;
  }

  .d-h3.demo {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
  }

  .d-nav-group .d-h4 {
    font-size: 11px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #6b7280;
    margin-top: 15px;
    margin-bottom: 12px;
    margin-left: 10px;
  }

  .d-nav-item {
    font-size: 14px;
    padding: 6px 4px;
    color: #374151;
    cursor: pointer;
    margin-left: 20px;
    border-radius: 6px;
  }

  .d-nav-item.d-active {
    color: hsl(245, 100%, 68%);
    font-weight: 600;
    background: hsl(221 83% 95%);
  }

  .d-main {
    flex: 1;
  }

  .d-main .d-section {
    padding: 48px 50px;
  }

  .d-main .d-section>*+* {
    margin-top: 20px;
  }

  .d-note {
    max-width: 900px;
    font-size: 14px;
    line-height: 1.6;
    color: #4b5563;
    margin-left: 50px;
  }

  .d-cols {
    display: flex;
    justify-content: flex-start;
    gap: 30px;
    width: 100%;
    flex-wrap: wrap;
    max-width: 1440px;
  }

  pre {
    background: #0f172a;
    color: #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    font-size: 12px;
    overflow-x: auto;
    line-height: 1.65;
  }

  code {
    font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
  }
</style>

<aside class="d-sidebar">
  <h2 class="d-h2">Style Guide</h2>

  <div class="d-nav-group">
    <h3 class="d-h3">Systems</h3>
    <div class="d-nav-item d-active" data-target="base">Base</div>
    <div class="d-nav-item" data-target="color-system">Color</div>
    <div class="d-nav-item" data-target="space-system">Space</div>
    <div class="d-nav-item" data-target="margin-auto-system">Margin Auto</div>
    <div class="d-nav-item" data-target="typography-system">Typography</div>
    <div class="d-nav-item" data-target="text-align-system">Text Align</div>
    <div class="d-nav-item" data-target="border-radius-system">Border & Radius</div>
    <div class="d-nav-item" data-target="width-system">Width</div>
    <div class="d-nav-item" data-target="max-width-system">Max Width</div>
    <div class="d-nav-item" data-target="image-system">Image</div>
    <h4 class="d-h4">Display</h4>
    <div class="d-nav-item" data-target="grid-system">Grid</div>
    <div class="d-nav-item" data-target="flex-system">Flex</div>
    <h4 class="d-h4">Position</h4>

  </div>
  <div class="d-nav-group">
    <h3 class="d-h3">Interaction</h3>
    <h4 class="d-h4">Toggle</h4>
    <div class="d-nav-item" data-target="toggle-popup">Popup</div>
    <div class="d-nav-item" data-target="toggle-dropdown">Dropdown</div>
    <div class="d-nav-item" data-target="toggle-accordion">Accordion</div>
    <h4 class="d-h4">Hover</h4>
    <div class="d-nav-item" data-target="hover-tooltip">Tooltip</div>
    <h4 class="d-h4">Navigation</h4>
    <div class="d-nav-item" data-target="navigation-scroll">Scroll</div>
    <div class="d-nav-item" data-target="navigation-scrollspy">Scroll Spy</div>
  </div>
</aside>