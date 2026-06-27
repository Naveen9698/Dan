<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="states-class-interactions">States - class Interaction</h2>

<section class="px-md stack-y-md">

  <!-- INTRO -->
  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>State classes</b> define <b>persistent UI states</b> controlled by the application.<br>
    🟢 Unlike pseudo states, these remain active until explicitly changed.<br>
    🟢 Typically managed through <b>JavaScript or interactions</b> (e.g., Webflow).<br>
    🟡 Always combine state classes with <b>[data-ut]</b> for proper scoping.<br>
    🔴 Do not rely on pseudo states (hover, focus) to represent UI state.
  </p>


  <!-- STATES LIST -->
  <h3>Available State Classes</h3>

  <div class="d-cols">
    <pre><code>🟢 <b>.active</b>   – indicates the currently active or focused item (nav, tab, etc.).
🟢 <b>.open</b>     – used for expandable elements (dropdowns, accordions).
🟢 <b>.selected</b> – marks chosen items (filters, options).
🟢 <b>.disabled</b> – prevents interaction and visually indicates inactivity.</code></pre>

    <pre><code>[data-ut].active    { ... }
[data-ut].open      { ... }
[data-ut].selected  { ... }
[data-ut].disabled  { ... }</code></pre>
  </div>

  <h3>Active State – Scroll Demo</h3>

  <style>
    [data-ut="active-area"] a.active {
      background: var(--color-main);
      color: #fff;
      font-weight: 600;
    }
  </style>

  <div class="bg-white pa-sm stack-y-md ra-sm sw-sm">

    <div
      data-ut="active-area"
      class="flex-x h-400px of-hidden">

      <!-- ✅ NAV -->
      <div class="w-20p of-y-auto pa-xs">
        <a href="#demo-base" class="dis-block pa-xxs ra-xxs clr-g7 active">Base</a>
        <a href="#demo-color" class="dis-block pa-xxs ra-xxs clr-g7">Color</a>
        <a href="#demo-spacing" class="dis-block pa-xxs ra-xxs clr-g7">Spacing</a>
        <a href="#demo-typography" class="dis-block pa-xxs ra-xxs clr-g7">Typography</a>
      </div>

      <!-- ✅ SCROLL CONTAINER -->
      <aside class="w-80p of-y-auto pa-sm bg-g1">

        <section id="demo-base" class="h-300px ba-xxs mb-sm pa-sm">
          <h4>Base</h4>
        </section>

        <section id="demo-color" class="h-300px ba-xxs mb-sm pa-sm">
          <h4>Color</h4>
        </section>

        <section id="demo-spacing" class="h-300px ba-xxs mb-sm pa-sm">
          <h4>Spacing</h4>
        </section>

        <section id="demo-typography" class="h-300px ba-xxs mb-sm pa-sm">
          <h4>Typography</h4>
        </section>

      </aside>

    </div>

    <!-- ✅ EXPLANATION -->
    <p class="fs-14 clr-g5">
      🟢 <b>.active</b> updates based on scroll position.<br>
      🟢 Clicking navigation scrolls inside the container.<br>
      🔴 Uses relative positioning for accurate scroll detection.
    </p>


    <div class="d-cols">
      <pre><code>/* CSS */
        
  [data-ut="active-area"] a.active {
    background: var(--color-main);
    color: #fff;
    font-weight: 600;
  }</code></pre>
      <pre><code> /* HTML */

&lt;div data-ut="active-area" class="flex-x h-400px of-hidden"&gt;

  &lt;!-- ✅ NAV --&gt;
  &lt;div class="w-20p of-y-auto pa-xs"&gt;
    &lt;a class="dis-block pa-xxs ra-xxs clr-g7 active" href="#demo-base"&gt;
      Base
    &lt;/a&gt;
    &lt;a class="dis-block pa-xxs ra-xxs clr-g7" href="#demo-color"&gt;
      Color
    &lt;/a&gt;
    &lt;a class="dis-block pa-xxs ra-xxs clr-g7" href="#demo-spacing"&gt;
      Spacing
    &lt;/a&gt;
    &lt;a class="dis-block pa-xxs ra-xxs clr-g7" href="#demo-typography"&gt;
      Typography
    &lt;/a&gt;
  &lt;/div&gt;

  &lt;!-- ✅ SCROLL CONTAINER --&gt;
  &lt;aside class="w-80p of-y-auto pa-sm bg-g1"&gt;

    &lt;section id="demo-base" class="h-300px ba-xxs mb-sm pa-sm"&gt;
      &lt;h4&gt;Base&lt;/h4&gt;
    &lt;/section&gt;

    &lt;section id="demo-color" class="h-300px ba-xxs mb-sm pa-sm"&gt;
      &lt;h4&gt;Color&lt;/h4&gt;
    &lt;/section&gt;

    &lt;section id="demo-spacing" class="h-300px ba-xxs mb-sm pa-sm"&gt;
      &lt;h4&gt;Spacing&lt;/h4&gt;
    &lt;/section&gt;

    &lt;section id="demo-typography" class="h-300px ba-xxs mb-sm pa-sm"&gt;
      &lt;h4&gt;Typography&lt;/h4&gt;
    &lt;/section&gt;

  &lt;/aside&gt;

&lt;/div&gt;    
  </code></pre>
      <pre><code> /* JS */
    
document.querySelectorAll('[data-ut="active-area"]').forEach(scope => {

  const items = scope.querySelectorAll('a');
  const scrollBox = scope.querySelector('aside');

  const sections = Array.from(items).map(item =>
    scrollBox.querySelector(item.getAttribute('href'))
  );

  function onScroll() {

    const scrollPos = scrollBox.scrollTop + 120;
    let activeIndex = 0;

    sections.forEach((section, index) => {
      if (!section) return;

      const sectionTop = section.offsetTop - scrollBox.offsetTop;

      if (scrollPos >= sectionTop) {
        activeIndex = index;
      }
    });

    items.forEach(i => i.classList.remove('active'));
    if (items[activeIndex]) {
      items[activeIndex].classList.add('active');
    }
  }

  scrollBox.addEventListener('scroll', onScroll);
  onScroll();

  items.forEach(item => {
    item.addEventListener('click', e => {

      e.preventDefault();

      const target = scrollBox.querySelector(item.getAttribute('href'));
      if (!target) return;

      scrollBox.scrollTo({
        top: target.offsetTop - scrollBox.offsetTop,
        behavior: 'smooth'
      });

    });
  });

});    
  </code></pre>
    </div>

  </div>


  <script>
    document.querySelectorAll('[data-ut="active-area"]').forEach(scope => {

      const items = scope.querySelectorAll('a');
      const scrollBox = scope.querySelector('aside');

      const sections = Array.from(items).map(item =>
        scrollBox.querySelector(item.getAttribute('href'))
      );

      function onScroll() {

        const scrollPos = scrollBox.scrollTop + 120;
        let activeIndex = 0;

        sections.forEach((section, index) => {
          if (!section) return;

          const sectionTop = section.offsetTop - scrollBox.offsetTop;

          if (scrollPos >= sectionTop) {
            activeIndex = index;
          }
        });

        items.forEach(i => i.classList.remove('active'));
        if (items[activeIndex]) {
          items[activeIndex].classList.add('active');
        }
      }

      scrollBox.addEventListener('scroll', onScroll);
      onScroll();

      items.forEach(item => {
        item.addEventListener('click', e => {

          e.preventDefault();

          const target = scrollBox.querySelector(item.getAttribute('href'));
          if (!target) return;

          scrollBox.scrollTo({
            top: target.offsetTop - scrollBox.offsetTop,
            behavior: 'smooth'
          });

        });
      });

    });
  </script>

  <h3>Open State – Accordion Demo</h3>

  <style>
    /* ✅ OPEN STATE */
    [data-ut="open-area"] article>section {
      display: none;
    }

    [data-ut="open-area"] article.open>section {
      display: block;
    }

    [data-ut="open-area"] article.open>button {
      background: var(--color-main);
      color: #fff;
    }
  </style>

  <div class="bg-white pa-sm stack-y-md ra-sm sw-sm">

    <div data-ut="open-area" class="stack-y-xs">

      <!-- ✅ ITEM -->
      <article class="sw-sm ra-xs">
        <button class="pa-xxs w-100p ta-left cur-pointer bg-g1">Base</button>
        <section class="pa-xxs">Base content...</section>
      </article>

      <article class="sw-sm ra-xs">
        <button class="pa-xxs w-100p ta-left cur-pointer bg-g1">Color</button>
        <section class="pa-xxs">Color content...</section>
      </article>

      <article class="sw-sm ra-xs">
        <button class="pa-xxs w-100p ta-left cur-pointer bg-g1">Spacing</button>
        <section class="pa-xxs">Spacing content...</section>
      </article>

      <article class="sw-sm ra-xs">
        <button class="pa-xxs w-100p ta-left cur-pointer bg-g1">Typography</button>
        <section class="pa-xxs">Typography content...</section>
      </article>

    </div>

    <!-- ✅ INFO -->
    <p class="fs-14 clr-g5">
      🟢 <b>.open</b> controls visibility.<br>
      🟢 Uses semantic elements (article, button, section).<br>
      🟡 No generic div targeting.<br>
      🔴 Structure defines behavior.
    </p>

    <script>
      document.querySelectorAll('[data-ut="open-area"]').forEach(scope => {

        const items = scope.querySelectorAll(':scope > article');

        items.forEach(item => {

          const trigger = item.querySelector('button');

          trigger.onclick = () => {

            items.forEach(i => i.classList.remove('open'));
            item.classList.add('open');

          };

        });

      });
    </script>

    <div class="d-cols">
      <pre><code>/* CSS */
    
[data-ut="open-area"] article>section {
  display: none;
}

[data-ut="open-area"] article.open>section {
  display: block;
}

[data-ut="open-area"] article.open>button {
  background: var(--color-main);
  color: #fff;
}</code></pre>
      <pre><code>/* HTML */
    
&lt;div data-ut="open-area" class="stack-y-xs"&gt;

  &lt;!-- ✅ ITEM --&gt;
  &lt;article class="sw-sm ra-xs"&gt;
    &lt;button class="pa-xxs w-100p ta-left cur-pointer bg-g1"&gt;Base&lt;/button&gt;
    &lt;section class="pa-xxs"&gt;Base content...&lt;/section&gt;
  &lt;/article&gt;

&lt;/div&gt;</code></pre>
      <pre><code>/* JS */
        
document.querySelectorAll('[data-ut="open-area"]').forEach(scope => {

  const items = scope.querySelectorAll(':scope > article');

  items.forEach(item => {

    const trigger = item.querySelector('button');

    trigger.onclick = () => {

      items.forEach(i => i.classList.remove('open'));
      item.classList.add('open');

    };

  });

});</code></pre>
    </div>

  </div>
  
  <h3>Selected State – Filter Demo</h3>

  <style>
    /* ✅ SELECTED STATE */
    [data-ut="selected-area"] label.selected {
      background: var(--color-main);
      color: #fff;
      border-color: var(--color-main);
    }
  </style>

  <div class="bg-white pa-sm stack-y-md ra-sm sw-sm">

    <!-- ✅ DEMO AREA -->
    <div data-ut="selected-area" class="flex-x gap-xs fw-wrap">

      <label class="ba-xxs ra-xs pa-xxs cur-pointer">
        <input type="checkbox" hidden>
        Base
      </label>

      <label class="ba-xxs ra-xs pa-xxs cur-pointer">
        <input type="checkbox" hidden>
        Color
      </label>

      <label class="ba-xxs ra-xs pa-xxs cur-pointer">
        <input type="checkbox" hidden>
        Spacing
      </label>

      <label class="ba-xxs ra-xs pa-xxs cur-pointer">
        <input type="checkbox" hidden>
        Typography
      </label>

    </div>

    <!-- ✅ EXPLANATION -->
    <p class="fs-14 clr-g5">
      🟢 <b>.selected</b> represents chosen options.<br>
      🟢 Click to toggle selection on/off.<br>
      🟡 Multiple selections allowed.<br>
      🔴 Uses semantic inputs (checkbox) for state.
    </p>

    <!-- ✅ CODE -->
    <div class="d-cols">

      <pre><code>/* CSS */

[data-ut="selected-area"] label.selected {
  background: var(--color-main);
  color: #fff;
  border-color: var(--color-main);
}</code></pre>

      <pre><code>/* HTML */

&lt;div data-ut="selected-area"&gt;

  &lt;label&gt;
    &lt;input type="checkbox" hidden&gt;
    Base
  &lt;/label&gt;

&lt;/div&gt;</code></pre>

      <pre><code>/* JS */

document.querySelectorAll('[data-ut="selected-area"]').forEach(scope =&gt; {

  const items = scope.querySelectorAll('label');

  items.forEach(item =&gt; {

    const input = item.querySelector('input');

    item.onclick = () =&gt; {

      input.checked = !input.checked;

      item.classList.toggle('selected', input.checked);

    };

  });

});</code></pre>

    </div>

  </div>


  <script>
    document.querySelectorAll('[data-ut="selected-area"]').forEach(scope => {

      const items = scope.querySelectorAll('label');

      items.forEach(item => {

        const input = item.querySelector('input');

        item.onclick = () => {

          input.checked = !input.checked;
          item.classList.toggle('selected', input.checked);

        };

      });

    });
  </script>

  <h3>Disabled State – Form Demo</h3>

  <style>
    /* ✅ DISABLED STATE */
    [data-ut="disabled-area"] button.disabled {
      background: var(--color-g1);
      color: var(--color-g3);
      cursor: not-allowed;
      pointer-events: none;
    }
  </style>

  <div class="bg-white pa-sm stack-y-md ra-sm sw-sm">

    <!-- ✅ FORM -->
    <form data-ut="disabled-area" class="flex-x w-fit gap-md">

      <input
        type="text"
        placeholder="Enter name"
        class="pa-sm ba-0 sw-sm ra-xs w-100p">

      <button
        type="button"
        class="pa-sm ra-xs sw-sm ba-0 bg-sub clr-white disabled">
        Submit
      </button>

    </form>

    <!-- ✅ EXPLANATION -->
    <p class="fs-14 clr-g5">
      🟢 <b>.disabled</b> prevents interaction.<br>
      🟢 Button enables when input has value.<br>
      🟡 State reflects input condition.<br>
      🔴 Interaction is blocked using CSS (pointer-events).
    </p>

    <!-- ✅ CODE -->
    <div class="d-cols">

      <pre><code>/* CSS */

[data-ut="disabled-area"] button.disabled {
  pointer-events: none;
  cursor: not-allowed;
}</code></pre>

      <pre><code>/* HTML */

&lt;form data-ut="disabled-area"&gt;

  &lt;input type="text" placeholder="Enter name"&gt;

  &lt;button class="disabled"&gt;
    Submit
  &lt;/button&gt;

&lt;/form&gt;</code></pre>

      <pre><code>/* JS */

document.querySelectorAll('[data-ut="disabled-area"]').forEach(scope =&gt; {

  const input = scope.querySelector('input');
  const button = scope.querySelector('button');

  input.oninput = () =&gt; {

    if (input.value.trim() !== '') {
      button.classList.remove('disabled');
    } else {
      button.classList.add('disabled');
    }

  };

});</code></pre>

    </div>

  </div>


  <script>
    document.querySelectorAll('[data-ut="disabled-area"]').forEach(scope => {

      const input = scope.querySelector('input');
      const button = scope.querySelector('button');

      input.oninput = () => {

        if (input.value.trim() !== '') {
          button.classList.remove('disabled');
        } else {
          button.classList.add('disabled');
        }

      };

    });
  </script>

</section>