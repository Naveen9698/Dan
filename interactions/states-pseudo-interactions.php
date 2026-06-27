<h2 class="fs-36 fw-700 clr-white bg-g6 ta-center pa-xs" id="interactions">Interactions</h2>

<section class="px-md stack-y-xs">

  <!-- INTRO -->
  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 All interactions must be scoped using <b>[data-ut]</b>.<br>
    🟢 Each <b>[data-ut]</b> acts as an independent component.<br>
    🔴 Never run JavaScript globally across the entire page.<br>
  </p>

  <!-- UNIVERSAL PATTERN -->
  <h3>Universal Pattern</h3>
  <div class="d-cols">
  <pre><code>// ✅ Step 1: Find each component
document.querySelectorAll('[data-ut]').forEach(scope => {

  // ✅ Step 2: Get items inside the component
  const items = scope.querySelectorAll(':scope > *');

  // ✅ Step 3: Apply interaction inside this component only
  items.forEach(item => {
    item.onclick = () => {

      // Example behavior (replace as needed)
      items.forEach(i => i.classList.remove('active'));
      item.classList.add('active');

    };
  });

});
</code></pre></div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟡 This pattern does not define behavior.<br>
    🟡 It only ensures interactions stay inside the component.<br>
    🟢 You replace the logic depending on the use-case.<br>
  </p>


  <!-- COMMON VARIATIONS -->
  <h3>Behavior Examples</h3>

  <div class="d-cols">

<pre><code>// Active (navigation, tabs)
// Only one item can be active
items.forEach(i => i.classList.remove('active'));
item.classList.add('active');</code></pre>

<pre><code>// Toggle (dropdown, accordion)
// Click to open/close
item.classList.toggle('open');</code></pre>

<pre><code>// Single selection (filters)
// Choose one option
items.forEach(i => i.classList.remove('selected'));
item.classList.add('selected');</code></pre>

<pre><code>// Multi selection (tags, filters)
// Toggle multiple options
item.classList.toggle('selected');</code></pre>

  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 The <b>selection pattern</b> stays the same.<br>
    🟢 Only the <b>state logic changes</b> (active, open, selected).<br>
  </p>

</section>






<h2 class="fs-36 fw-700 clr-white bg-g4 ta-center pa-xs" id="states-interactions">States</h2>

<section class="px-md stack-y-sm">
  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>Interaction system</b> controls <b>user behavior & feedback</b>, not layout or spacing.<br>
    🟢 Uses <b>Pseudo classes - :active, :hover, :focus</b> for temporary interaction states.<br>
    🟢 Uses <b>State classes - active, open, disabled, selected</b> for persistent states.<br>
    🟡 <b>State classes</b> are controlled via <b>JavaScript</b>.<br>
    🟡 Works together with utility classes (spacing, colors, layout).<br>
  </p>
</section>

<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="states-pseudo-interactions">States - Pseudo Interaction</h2>

<section class="px-md stack-y-md">

  <!-- INTRO -->
  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>Pseudo states</b> define <b>temporary interaction behavior</b> controlled by the browser.<br>
    🟢 They respond to user actions like hover, click, and keyboard navigation.<br>
    🟢 Always scope pseudo states using <b>[data-ut]</b> to avoid styling conflicts.<br>
    🟡 Pseudo states are <b>short-lived</b> and should not replace persistent state classes.<br>
    🔴 Do not rely on pseudo states for application logic or state management.
  </p>


  <!-- ALL STATES -->
  <h3>Available Pseudo States</h3>

  <div class="d-cols">
    <pre><code>🟢 <b>:hover</b>         – triggered when a pointer is over an element.
🟢 <b>:active</b>        – active during click/press interaction.
🟢 <b>:focus</b>         – triggered when element receives focus (mouse or keyboard).
🟢 <b>:focus-visible</b> – shows focus only when needed (keyboard navigation).
🟡 <b>:checked</b>       – works for form inputs (checkbox, radio).
🔴 <b>:link/:visited</b> – apply only to anchor links.</code></pre>

    <pre><code>[data-ut]:hover         { ... }
[data-ut]:active        { ... }
[data-ut]:focus         { ... }
[data-ut]:focus-visible { ... }</code></pre>
  </div>

  <!-- LIVE DEMO -->
  <h3>Live Demo</h3>

  <!-- EMBED STYLE -->
  <style>
    /* Hover */
    [data-ut="one"]:hover {
      background: var(--color-sub);
    }

    /* Active (press feedback) */
    [data-ut="two"]:active {
      transform: scale(0.95);
      background: var(--color-main-h);
      color: white;
    }

    /* Focus */
    [data-ut="three"]:focus {
      outline: 3px solid var(--color-main);
      outline-offset: 2px;
    }
  </style>

  <div class="bg-white ra-sm pa-md sw-sm">

    <div class="grid gap-md">

      <div class="g-4 stack-y-xs">
        <div data-ut="one" tabindex="0" class="pa-md bg-white ra-sm sw-sm ta-center">
          Hover (move mouse)
        </div>
        <pre><code>[data-ut="one"]:hover {
  background: var(--color-sub);
}</code></pre>
        <p class="fs-14 clr-g5 lh-16 ml-md">
          🟢 <b>:hover</b> → pointer interaction feedback.
        </p>
      </div>

      <div class="g-4 stack-y-xs">
        <button data-ut="two" class="pa-md w-100p bg-white ba-0 ra-sm sw-sm">
          Active (hold click)
        </button>
        <pre><code>[data-ut="two"]:active {
  transform: scale(0.95);
}</code></pre>
        <p class="fs-14 clr-g5 lh-16 ml-md">
          🟢 <b>:active</b> → press/click feedback (very short duration).
        </p>
      </div>

      <div class="g-4 stack-y-xs">
        <button data-ut="three" class="pa-md w-100p bg-white ba-0 ra-sm sw-sm">
          Focus (click / tab)
        </button>

        <pre><code>[data-ut="three"]:focus {
  outline: 3px solid var(--color-main);
}</code></pre>

        <p class="fs-14 clr-g5 lh-16 ml-md">
          🟢 <b>:focus</b> → triggered when element is selected (click or tab).<br>
          🟡 Stays visible until focus moves away.
        </p>
      </div>

    </div>

  </div>


  <h3>Focus-visible Demo</h3>

  <style>
    /* Remove default focus */
    [data-demo="focus-area"] button:focus {
      outline: none;
    }

    /* Focus-visible only */
    [data-demo="focus-area"] button:focus-visible {
      outline: 3px solid var(--color-acnt);
      outline-offset: 3px;
      background: var(--color-sub);
      border: none;
    }
  </style>

  <div class="bg-white pa-sm stack-y-md ra-sm sw-sm">

    <div
      data-demo="focus-area"
      class="grid gap-sm bg-white ra-lg pa-md pb-0">

      <div class="g-4">
        <button class="pa-md w-100p bg-white ra-sm ba-xxs">
          Item 1
        </button>
      </div>

      <div class="g-4">
        <button class="pa-md w-100p bg-white ra-sm ba-xxs">
          Item 2
        </button>
      </div>

      <div class="g-4">
        <button class="pa-md w-100p bg-white ra-sm ba-xxs">
          Item 3
        </button>
      </div>

      <div class="g-12">
        <p class="fs-14 clr-g5">
          🟢 <b>:focus-visible</b> → shown during keyboard navigation (Tab).<br>
          🟡 Use <b>Tab key</b> to navigate. Focus will remain inside this area using js. <br>
          🟡 Hidden on mouse click for cleaner UI.<br>
          🔴 Use Tab key to see this behavior.
        </p>
      </div>
      <div class="g-12">
        <p class="fs-14 clr-g5">
        <pre><code>[data-demo="focus-area"] button:focus {
  outline: none;
}

[data-demo="focus-area"] button:focus-visible {
  outline: 3px solid var(--color-acnt);
  outline-offset: 3px;
  background: var(--color-sub);
  border: none;
}</code></pre>
        </p>
      </div>
    </div>

  </div>
  <script>
    const container = document.querySelector('[data-demo="focus-area"]');
    const items = container.querySelectorAll('button');

    container.addEventListener('keydown', function(e) {
      if (e.key !== 'Tab') return;

      const first = items[0];
      const last = items[items.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  </script>

</section>