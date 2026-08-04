<div class="grid gap-lg">

  <div class="g-12 flex-x pn-relative f-spread gap-md bg-white ra-md pa-md">

    <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Simulated scaling (Demo)
    </span>

    <div class="bg-main-h clr-white flex-y gap-xs bsw-xl ra-lg pa-md w-auto">
      <span class="fz-12 clr-g1">
        fz-xxl(48 → 32 → 26) · fw-700 · lh-12
      </span>
      <p class="fz-48 fw-700 lh-12">Display Heading</p>
      <p class="fz-32 fw-700 lh-12">Display Heading</p>
      <p class="fz-26 fw-700 lh-12">Display Heading</p>
    </div>

    <div class="bg-main-h clr-white flex-y gap-xs bsw-xl ra-lg pa-md w-auto">
      <span class="fz-12 clr-g1">
        fz-xl(32 → 26 → 22) · fw-600 · lh-13
      </span>
      <p class="fz-32 fw-600 lh-13">Section Heading</p>
      <p class="fz-26 fw-600 lh-13">Section Heading</p>
      <p class="fz-22 fw-600 lh-13">Section Heading</p>
    </div>

    <div class="bg-main-h clr-white flex-y gap-xs bsw-xl ra-lg pa-md w-auto">
      <span class="fz-12 clr-g1">
        fz-md(20 → 17 → 16) · fw-500 · lh-14
      </span>
      <p class="fz-20 fw-500 lh-14">Sub Heading</p>
      <p class="fz-17 fw-500 lh-14">Sub Heading</p>
      <p class="fz-16 fw-500 lh-14">Sub Heading</p>
    </div>

    <div class="bg-main-h clr-white flex-y gap-xs bsw-xl ra-lg pa-md w-auto">
      <span class="fz-12 clr-g1">
        fz-sm(16 → 15 → 14) · fw-400 · lh-12
      </span>
      <p class="fz-16 fw-400 lh-12">Body text (Desktop)</p>
      <p class="fz-15 fw-400 lh-12">Body text (Tablet)</p>
      <p class="fz-14 fw-400 lh-12">Body text (Mobile)</p>
    </div>

  </div>

</div>

<div class="grid gap-md bg-white ra-md pa-md">

  <div class="g-2"></div>
  <div class="g-8 pn-relative bg-main-h clr-white bsw-sm pa-sm ra-xs">

    <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Desktop (Demo)
    </span>

    <p class="fz-48 fw-700 lh-12">Display Heading</p>
    <p class="fz-32 fw-600 lh-13">Section Heading</p>
    <p class="fz-20 fw-500 lh-14">Sub Heading</p>
    <p class="fz-16 fw-400 lh-12">Body text for large screens.</p>

  </div>

  <div class="g-2"></div>
  <div class="g-2"></div>

  <div class="g-5 pn-relative bg-main-h clr-white bsw-sm pa-sm ra-xs">

    <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Tablet (Demo)
    </span>

    <p class="fz-32 fw-700 lh-12">Display Heading</p>
    <p class="fz-26 fw-600 lh-13">Section Heading</p>
    <p class="fz-17 fw-500 lh-14">Sub Heading</p>
    <p class="fz-15 fw-400 lh-12">Body text for medium screens.</p>

  </div>

  <div class="g-3 pn-relative bg-main-h clr-white bsw-sm pa-sm ra-xs">

    <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Mobile (Demo)
    </span>

    <p class="fz-26 fw-700 lh-12">Display Heading</p>
    <p class="fz-22 fw-600 lh-13">Section Heading</p>
    <p class="fz-16 fw-500 lh-14">Sub Heading</p>
    <p class="fz-14 fw-400 lh-12">Body text for small screens.</p>

  </div>

</div>

<p class="g-12 fz-14 clr-g5 lh-16 ml-md">
  🟢 This demo shows <b>visual size differences across breakpoints</b>.<br>
  🟡 Values are manually adjusted [e.g., fz-xxl<b>(48 → 32 → 26)</b>] to simulate scaling.<br>
  🟢 In real usage, use a <b>single semantic class (fz-xxs → fz-xxl)</b> — sizes adapt automatically.<br>
  🔴 Do not change font-size classes per breakpoint in production.
</p>

<div class="mt-sm">

  <label>
    Responsive Simulator:
    <span id="typoLabel">Mobile</span>
  </label>

  <input
    class="w-100p"
    type="range"
    id="typoRange"
    min="300"
    max="1200"
    value="300" />

</div>

<div id="typoWrapper" class="h-400px w-300px ma-auto ts-2 ts-ease">

  <div class="bg-main-h clr-white pa-md mt-xl ra-md pn-relative">

    <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Real Responsive Behavior
    </span>

    <div class="mt-sm flex-y">
      <p class="ts-3 fz-xxl fw-700 lh-12">Display Heading</p>
      <p class="ts-3 fz-xl fw-600 lh-13">Section Heading</p>
      <p class="ts-3 fz-lg fw-500 lh-14">Sub Heading</p>
      <p class="ts-3 fz-sm fw-400 lh-12">
        Body text scales naturally with container width.
      </p>
    </div>

  </div>

</div>

<p class="fz-14 clr-g5 lh-16 ml-md">
  🟢 This simulator shrinks the <b>container width</b> to mimic real responsive layouts.<br>
  🟢 Typography tokens update automatically based on breakpoint ranges.<br>
  🟢 Layout and text scale together for realistic behavior.<br>
</p>

<script>
  (function() {
    const range = document.getElementById("typoRange");
    const label = document.getElementById("typoLabel");
    const wrapper = document.getElementById("typoWrapper");

    if (!range || !label || !wrapper) return;

    function updateUI() {
      const width = parseInt(range.value, 10);

      wrapper.style.width = width + "px";

      let mode;

      if (width < 770) {
        mode = "mobile";
        label.textContent = "Mobile · " + width + "px";
      } else if (width < 990) {
        mode = "tablet";
        label.textContent = "Tablet · " + width + "px";
      } else {
        mode = "desktop";
        label.textContent = "Desktop · " + width + "px";
      }

      applyTypography(mode);
    }

    range.addEventListener("input", updateUI);

    updateUI();

    function applyTypography(mode) {
      const root = document.documentElement;

      if (mode === "desktop") {
        root.style.setProperty("--fz-xxs", "12px");
        root.style.setProperty("--fz-xs", "14px");
        root.style.setProperty("--fz-sm", "16px");
        root.style.setProperty("--fz-md", "20px");
        root.style.setProperty("--fz-lg", "24px");
        root.style.setProperty("--fz-xl", "32px");
        root.style.setProperty("--fz-xxl", "48px");
      }

      if (mode === "tablet") {
        root.style.setProperty("--fz-xxs", "12px");
        root.style.setProperty("--fz-xs", "14px");
        root.style.setProperty("--fz-sm", "15px");
        root.style.setProperty("--fz-md", "17px");
        root.style.setProperty("--fz-lg", "20px");
        root.style.setProperty("--fz-xl", "26px");
        root.style.setProperty("--fz-xxl", "32px");
      }

      if (mode === "mobile") {
        root.style.setProperty("--fz-xxs", "11px");
        root.style.setProperty("--fz-xs", "13px");
        root.style.setProperty("--fz-sm", "14px");
        root.style.setProperty("--fz-md", "16px");
        root.style.setProperty("--fz-lg", "18px");
        root.style.setProperty("--fz-xl", "22px");
        root.style.setProperty("--fz-xxl", "26px");
      }
    }
  })();
</script>