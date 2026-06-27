<div class="g-6 flex-y gap-xxs">
  <span class="fs-14 fw-600 clr-g8">Visible vs Hidden</span>

  <!-- SWITCH -->
  <div class="flex-x gap-xs f-center">
    <span class="fs-12">Visible</span>

    <div onclick="toggleOverflow1()"
      class="bg-g3 w-50px h-20px ra-max pn-relative"
      style="cursor:pointer">

      <div id="ofSwitch1"
        class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
        style="transition: all 0.2s ease;">
      </div>
    </div>

    <span class="fs-12">Hidden</span>
  </div>

  <!-- DEMO -->
  <div class="bg-g1 pa-md ra-md">

    <div id="ofBox1"
      class="of-visible h-70px bg-main-h pa-xs ra-sm clr-g9">

      <div class="fw-600 mb-xs">overflow: visible</div>
      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit nesciunt, dolorem dolor ipsum consequuntur nobis dignissimos qui quae, tempora adipisci omnis consectetur saepe iste. Veritatis nihil exercitationem tenetur ab magnam. (overflow)
    </div>

  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>visible</b> → content flows outside container.<br>
    🟢 <b>hidden</b> → extra content is clipped.<br>
  </p>
</div>

<script>
  function toggleOverflow1() {
    const el = document.getElementById("ofBox1");
    const knob = document.getElementById("ofSwitch1");

    el.classList.toggle("of-hidden");
    el.classList.toggle("of-visible");

    el.innerHTML = el.classList.contains("of-hidden") ?
      '<div class="fw-600 mb-xs">overflow: hidden</div>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit nesciunt, dolorem dolor ipsum consequuntur nobis dignissimos qui quae, tempora adipisci omnis consectetur saepe iste. Veritatis nihil exercitationem tenetur ab magnam. (overflow)' :
      '<div class="fw-600 mb-xs">overflow: visible</div>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit nesciunt, dolorem dolor ipsum consequuntur nobis dignissimos qui quae, tempora adipisci omnis consectetur saepe iste. Veritatis nihil exercitationem tenetur ab magnam. (overflow)';

    knob.style.left = el.classList.contains("of-hidden") ? "30px" : "0";
  }
</script>

<div class="g-6 flex-y gap-xxs">
  <span class="fs-14 fw-600 clr-g8">Vertical Overflow</span>

  <!-- SWITCH -->
  <div class="flex-x gap-xs f-center">
    <span class="fs-12">Hidden</span>

    <div onclick="toggleOfY()"
      class="bg-g3 w-50px h-20px ra-max pn-relative">

      <div id="ofSwitchY"
        class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
        style="transition: all 0.2s ease;"></div>
    </div>

    <span class="fs-12">Scroll</span>
  </div>

  <!-- DEMO -->
  <div class="bg-g1 pa-md ra-md">

    <div id="ofBoxY"
      class="of-y-hidden h-100px bg-main-h pa-sm ra-sm clr-white">

      <div id="ofLabelY" class="fw-600 mb-xs">
        overflow-y: hidden
      </div>

      Line 1<br>Line 2<br>Line 3<br>Line 4<br>Line 5

    </div>

  </div>
</div>

<div class="g-6 flex-y gap-xxs">
  <span class="fs-14 fw-600 clr-g8">Both Directions</span>

  <!-- SWITCH -->
  <div class="flex-x gap-xs f-center">
    <span class="fs-12">Hidden</span>

    <div onclick="toggleOfBoth()"
      class="bg-g3 w-50px h-20px ra-max pn-relative">

      <div id="ofSwitchBoth"
        class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
        style="transition: all 0.2s ease;"></div>
    </div>

    <span class="fs-12">Scroll</span>
  </div>

  <!-- DEMO -->
  <div class="bg-g1 pa-md ra-md">

    <div id="ofBoxBoth"
      class="of-hidden w-200px h-100px bg-sub pa-sm ra-sm clr-white">

      <div id="ofLabelBoth" class="fw-600 mb-xs">
        overflow: hidden
      </div>

      <div class="w-500px h-200px bg-acnt pa-sm">
        Big content → scroll both ways →
      </div>

    </div>

  </div>
</div>

<script>
  function toggleOfX() {
    const el = document.getElementById("ofBoxX");
    const label = document.getElementById("ofLabelX");
    const knob = document.getElementById("ofSwitchX");

    el.classList.toggle("of-x-auto");
    el.classList.toggle("of-x-hidden");

    const isAuto = el.classList.contains("of-x-auto");

    label.innerText = isAuto ? "overflow-x: auto" : "overflow-x: hidden";
    knob.style.left = isAuto ? "30px" : "0";
  }

  function toggleOfY() {
    const el = document.getElementById("ofBoxY");
    const label = document.getElementById("ofLabelY");
    const knob = document.getElementById("ofSwitchY");

    el.classList.toggle("of-y-auto");
    el.classList.toggle("of-y-hidden");

    const isAuto = el.classList.contains("of-y-auto");

    label.innerText = isAuto ? "overflow-y: auto" : "overflow-y: hidden";
    knob.style.left = isAuto ? "30px" : "0";
  }

  function toggleOfBoth() {
    const el = document.getElementById("ofBoxBoth");
    const label = document.getElementById("ofLabelBoth");
    const knob = document.getElementById("ofSwitchBoth");

    el.classList.toggle("of-auto");
    el.classList.toggle("of-hidden");

    const isAuto = el.classList.contains("of-auto");

    label.innerText = isAuto ? "overflow: auto" : "overflow: hidden";
    knob.style.left = isAuto ? "30px" : "0";
  }
</script>