<div class="grid gap-lg">

  <div class="g-12 flex-x pn-relative f-spread gap-md bg-white ra-md pa-md">

    <span class="fs-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Simulated scaling (Demo)
    </span>

    <div class="bg-main-h clr-white flex-y gap-xs sw-xl ra-lg pa-md w-auto">
      <span class="fs-12 clr-g1">
        fs-xxl(48 → 32 → 26) · fw-700 · lh-12
      </span>
      <p class="fs-48 fw-700 lh-12">Display Heading</p>
      <p class="fs-32 fw-700 lh-12">Display Heading</p>
      <p class="fs-26 fw-700 lh-12">Display Heading</p>
    </div>

    <div class="bg-main-h clr-white flex-y gap-xs sw-xl ra-lg pa-md w-auto">
      <span class="fs-12 clr-g1">
        fs-xl(32 → 26 → 22) · fw-600 · lh-13
      </span>
      <p class="fs-32 fw-600 lh-13">Section Heading</p>
      <p class="fs-26 fw-600 lh-13">Section Heading</p>
      <p class="fs-22 fw-600 lh-13">Section Heading</p>
    </div>

    <div class="bg-main-h clr-white flex-y gap-xs sw-xl ra-lg pa-md w-auto">
      <span class="fs-12 clr-g1">
        fs-md(20 → 17 → 16) · fw-500 · lh-14
      </span>
      <p class="fs-20 fw-500 lh-14">Sub Heading</p>
      <p class="fs-17 fw-500 lh-14">Sub Heading</p>
      <p class="fs-16 fw-500 lh-14">Sub Heading</p>
    </div>

    <div class="bg-main-h clr-white flex-y gap-xs sw-xl ra-lg pa-md w-auto">
      <span class="fs-12 clr-g1">
        fs-sm(16 → 15 → 14) · fw-400 · lh-12
      </span>
      <p class="fs-16 fw-400 lh-12">Body text (Desktop)</p>
      <p class="fs-15 fw-400 lh-12">Body text (Tablet)</p>
      <p class="fs-14 fw-400 lh-12">Body text (Mobile)</p>
    </div>

  </div>

</div>

<div class="grid gap-md bg-white ra-md pa-md">

  <div class="g-2"></div>
  <div class="g-8 pn-relative bg-main-h clr-white sw-sm pa-sm ra-xs">

    <span class="fs-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Desktop (Demo)
    </span>

    <p class="fs-48 fw-700 lh-12">Display Heading</p>
    <p class="fs-32 fw-600 lh-13">Section Heading</p>
    <p class="fs-20 fw-500 lh-14">Sub Heading</p>
    <p class="fs-16 fw-400 lh-12">Body text for large screens.</p>

  </div>

  <div class="g-2"></div>
  <div class="g-2"></div>

  <div class="g-5 pn-relative bg-main-h clr-white sw-sm pa-sm ra-xs">

    <span class="fs-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Tablet (Demo)
    </span>

    <p class="fs-32 fw-700 lh-12">Display Heading</p>
    <p class="fs-26 fw-600 lh-13">Section Heading</p>
    <p class="fs-17 fw-500 lh-14">Sub Heading</p>
    <p class="fs-15 fw-400 lh-12">Body text for medium screens.</p>

  </div>

  <div class="g-3 pn-relative bg-main-h clr-white sw-sm pa-sm ra-xs">

    <span class="fs-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Mobile (Demo)
    </span>

    <p class="fs-26 fw-700 lh-12">Display Heading</p>
    <p class="fs-22 fw-600 lh-13">Section Heading</p>
    <p class="fs-16 fw-500 lh-14">Sub Heading</p>
    <p class="fs-14 fw-400 lh-12">Body text for small screens.</p>

  </div>

</div>

<p class="g-12 fs-14 clr-g5 lh-16 ml-md">
  🟢 This demo shows <b>visual size differences across breakpoints</b>.<br>
  🟡 Values are manually adjusted [e.g., fs-xxl<b>(48 → 32 → 26)</b>] to simulate scaling.<br>
  🟢 In real usage, use a <b>single semantic class (fs-xxs → fs-xxl)</b> — sizes adapt automatically.<br>
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

<div id="typoWrapper" class="h-400px w-300px ma-auto tr-2 tr-ease">

  <div class="bg-main-h clr-white pa-md mt-xl ra-md pn-relative">

    <span class="fs-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-acnt">
      Real Responsive Behavior
    </span>

    <div class="mt-sm flex-y">
      <p class="tr-3 fs-xxl fw-700 lh-12">Display Heading</p>
      <p class="tr-3 fs-xl fw-600 lh-13">Section Heading</p>
      <p class="tr-3 fs-lg fw-500 lh-14">Sub Heading</p>
      <p class="tr-3 fs-sm fw-400 lh-12">
        Body text scales naturally with container width.
      </p>
    </div>

  </div>

</div>

<p class="fs-14 clr-g5 lh-16 ml-md">
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
        root.style.setProperty("--fs-xxs", "12px");
        root.style.setProperty("--fs-xs", "14px");
        root.style.setProperty("--fs-sm", "16px");
        root.style.setProperty("--fs-md", "20px");
        root.style.setProperty("--fs-lg", "24px");
        root.style.setProperty("--fs-xl", "32px");
        root.style.setProperty("--fs-xxl", "48px");
      }

      if (mode === "tablet") {
        root.style.setProperty("--fs-xxs", "12px");
        root.style.setProperty("--fs-xs", "14px");
        root.style.setProperty("--fs-sm", "15px");
        root.style.setProperty("--fs-md", "17px");
        root.style.setProperty("--fs-lg", "20px");
        root.style.setProperty("--fs-xl", "26px");
        root.style.setProperty("--fs-xxl", "32px");
      }

      if (mode === "mobile") {
        root.style.setProperty("--fs-xxs", "11px");
        root.style.setProperty("--fs-xs", "13px");
        root.style.setProperty("--fs-sm", "14px");
        root.style.setProperty("--fs-md", "16px");
        root.style.setProperty("--fs-lg", "18px");
        root.style.setProperty("--fs-xl", "22px");
        root.style.setProperty("--fs-xxl", "26px");
      }
    }
  })();
</script>