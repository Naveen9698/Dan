<div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">

  <h3>Static vs Relative (Visual bswitch)</h3>

  <div class="flex-y gap-xxs">

    <!-- bswITCH -->
    <div class="flex-x gap-xs f-center">

      <h3 class="fz-12">Static</h3>

      <div onclick="togglePosition()"
        class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

        <!-- knob -->
        <div id="bswitchKnob"
          class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0 bsw-xs"
          style="transition: all 0.2s ease;">
        </div>

      </div>

      <h3 class="fz-12">Relative</h3>

    </div>

    <!-- OUTER CONTAINER -->
    <div class="pn-relative h-260px bg-g1 ra-md pa-md mb-sm">

      <div class="fz-12 mb-sm clr-g6">
        Viewport reference (fallback anchor)
      </div>

      <!-- PARENT BOX -->
      <div id="parentBox" class="bg-g7 h-200px w-500px ra-md pa-xs">

        <div id="stateLabel" class="fz-20 clr-white mb-xs">
          Parent: static
        </div>

        <!-- ABSOLUTE CHILD -->
        <div class="pn-absolute clr-white t-20px r-20px bg-sub pa-xs ra-xs bsw-sm fz-20">
          absolute
        </div>

      </div>

    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>pn-static</b> and <b>pn-relative</b> appear <b>identical visually</b> — both follow normal document flow.<br>
      🟢 The difference is <b>behavioral</b>: only <b>pn-relative creates a positioning context</b>.<br>
      🟢 <b>pn-absolute</b> children anchor to the nearest <b>pn-relative</b> parent.<br>
      🔴 With <b>pn-static</b>, absolute elements fall back to the nearest positioned ancestor (or viewport).<br>
      🟡 This behavior cannot be understood visually without an <b>absolute child</b> reacting to it.<br>
      🔴 Does not affect spacing — use margin/padding for layout spacing, not positioning.
    </p>
  </div>

</div>

<div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">

  <h3>Absolute vs Fixed (Visual bswitch)</h3>

  <div class="flex-y gap-xxs">

    <!-- bswITCH -->
    <div class="flex-x gap-xs f-center">

      <h3 class="fz-12">Absolute</h3>

      <div onclick="toggleFixed()"
        class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

        <!-- knob -->
        <div id="bswitchKnobFixed"
          class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0 bsw-xs"
          style="transition: all 0.2s ease;">
        </div>

      </div>

      <h3 class="fz-12">Fixed</h3>

    </div>

    <!-- VIEWPORT SIMULATION -->
    <div class="h-260px bg-g1 ra-md pa-md of-auto mb-sm">

      <div class="fz-12 mb-sm clr-g6">
        Viewport reference
      </div>

      <!-- CONTENT -->
      <div class="pn-relative h-200px w-500px bg-main-h ra-md pa-sm">

        <div class="fz-20 clr-white mb-xs">
          Parent: relative
        </div>

        <!-- TARGET BOX -->
        <div id="targetBox"
          class="pn-absolute t-20px r-20px bg-sub pa-xs ra-xs bsw-md fz-12">

          <div id="stateLabelFixed" class="fz-20 clr-white">
            absolute
          </div>

        </div>

      </div>

    </div>

    <!-- NOTE -->
    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>pn-absolute</b> positions relative to a <b>parent container</b>.<br>
      🟢 <b>pn-fixed</b> positions relative to the <b>viewport</b>.<br>
      🟡 Scroll to observe: absolute moves, fixed stays pinned.<br>
      🔴 Fixed ignores parent layout completely.
    </p>
  </div>

</div>

<div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">

  <h3>Relative vs Sticky (Real Layout)</h3>

  <div class="flex-y gap-xxs">

    <!-- bswITCH -->
    <div class="flex-x gap-xs f-center">
      <h3 class="fz-12">Relative</h3>

      <div onclick="toggleSticky()"
        class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

        <div id="bswitchKnobSticky"
          class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0 bsw-xs"
          style="transition: all 0.2s ease;">
        </div>

      </div>

      <h3 class="fz-12">Sticky</h3>
    </div>

    <!-- VIEWPORT -->
    <div class="h-300px bg-g1 ra-md of-auto mb-sm">

      <!-- ✅ FIXED: Navbar directly controlled -->
      <div id="navbar"
        class="pn-relative bg-main-h clr-white w-80p ma-auto mt-lg pa-sm z-2 mb-md">
        <h3 id="navbarLabel">Navbar - position: relative</h3>
      </div>

      <!-- CONTENT -->
      <div class="grid w-80p ma-auto gap-md pa-md">

        <!-- LEFT SIDEBAR -->
        <div class="g-4">

          <div id="sidebar"
            class="pn-relative bg-main-h clr-white pa-md ra-md">

            <div id="stateLabelSticky" class="fz-14 fw-700 mb-xs">
              relative
            </div>

            <p class="fz-12">
              Sidebar block<br>
              sticks when enabled
            </p>

          </div>

        </div>

        <!-- RIGHT CONTENT -->
        <div class="g-8">

          <div class="bg-g2 pa-md ra-md">

            <div class="mb-md">Scroll content</div>

            <div class="bg-g3 h-100px mb-sm"></div>
            <div class="bg-g3 h-100px mb-sm"></div>
            <div class="bg-g3 h-100px mb-sm"></div>
            <div class="bg-g3 h-100px mb-sm"></div>
            <div class="bg-g3 h-100px mb-sm"></div>
            <div class="bg-g3 h-100px mb-sm"></div>

          </div>

        </div>

      </div>

      <div class="w-80p ma-auto">

        <div class="bg-g2 pa-md ra-md">

          <div class="mb-md">Scroll content</div>

          <div class="bg-g3 h-100px mb-sm"></div>
          <div class="bg-g3 h-100px mb-sm"></div>
          <div class="bg-g3 h-100px mb-sm"></div>
          <div class="bg-g3 h-100px mb-sm"></div>
          <div class="bg-g3 h-100px mb-sm"></div>
          <div class="bg-g3 h-100px mb-sm"></div>

        </div>

      </div>

    </div>

    <!-- NOTE -->
    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>pn-relative</b> scrolls normally with content and does not stick.<br>
      🟢 <b>pn-sticky</b> behaves like relative until it reaches an offset (e.g. <b>t-0</b>), then sticks in place.<br>
      🟢 Works for both <b>navbar (top)</b> and <b>sidebar (within layout)</b> in this demo.<br>
      🟡 Sticky only works inside its <b>scroll container</b> and requires a defined offset.<br>
      🟡 Parent layout and spacing (e.g. navbar height) must be considered to avoid overlap.<br>
      🔴 <b>overflow: hidden / auto / scroll</b> on parent elements can break or limit sticky behavior.<br>
      🔴 Sticky = <b>relative → then locks during scroll</b>, not a global fixed position.
    </p>

  </div>

</div>

<script>
  // ===== STATIC vs RELATIVE =====
  let isRelative = false;

  function togglePosition() {
    const parent = document.getElementById("parentBox");
    const label = document.getElementById("stateLabel");
    const knob = document.getElementById("bswitchKnob");

    if (isRelative) {
      // STATIC
      parent.classList.remove("pn-relative", "bg-main-h");
      parent.classList.add("bg-g7");

      label.innerText = "Parent: static";
      knob.style.left = "0";
    } else {
      // RELATIVE
      parent.classList.add("pn-relative", "bg-main-h");
      parent.classList.remove("bg-g7");

      label.innerText = "Parent: relative";
      knob.style.left = "30px";
    }

    isRelative = !isRelative;
  }

  // ===== ABSOLUTE vs FIXED =====
  let isFixed = false;

  function toggleFixed() {
    const box = document.getElementById("targetBox");
    const knob = document.getElementById("bswitchKnobFixed");
    const label = document.getElementById("stateLabelFixed");

    if (isFixed) {
      // ABSOLUTE
      box.classList.remove("pn-fixed", "bg-acnt");
      box.classList.add("pn-absolute", "bg-sub");

      knob.style.left = "0";
      label.innerText = "absolute";
    } else {
      // FIXED
      box.classList.remove("pn-absolute", "bg-sub");
      box.classList.add("pn-fixed", "bg-acnt");

      knob.style.left = "30px";
      label.innerText = "fixed";
    }

    isFixed = !isFixed;
  }

  // ===== RELATIVE vs STICKY =====

  let isSticky = false;

  function toggleSticky() {
    const sidebar = document.getElementById("sidebar");
    const navbar = document.getElementById("navbar");
    const knob = document.getElementById("bswitchKnobSticky");
    const label = document.getElementById("stateLabelSticky");
    const navbarLabel = document.getElementById("navbarLabel");

    if (isSticky) {
      // ===== RELATIVE =====
      sidebar.classList.remove(
        "pn-sticky",
        "t-0",
        "t-60px", // ✅ reset ALL offsets
        "bg-acnt"
      );

      navbar.classList.remove(
        "pn-sticky",
        "t-0",
        "bg-acnt"
      );

      // restore base state
      sidebar.classList.add("pn-relative", "bg-main-h");
      navbar.classList.add("pn-relative", "bg-main-h");

      // UI updates
      knob.style.left = "0";
      label.innerText = "relative";
      navbarLabel.innerText = "Navbar - position: relative";

    } else {
      // ===== STICKY =====
      sidebar.classList.remove("pn-relative", "bg-main");
      navbar.classList.remove("pn-relative", "bg-main");

      // ✅ apply sticky + offset BELOW navbar
      sidebar.classList.add("pn-sticky", "t-60px", "bg-acnt");
      navbar.classList.add("pn-sticky", "t-0", "bg-acnt");

      // UI updates
      knob.style.left = "30px";
      label.innerText = "sticky";
      navbarLabel.innerText = "Navbar - position: sticky";
    }

    isSticky = !isSticky;
  }
</script>