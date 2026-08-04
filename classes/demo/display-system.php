    <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
      <h3>Block vs Inline</h3>
      <div class="flex-y gap-xxs">

        <!-- bswITCH -->
        <div class="flex-x gap-xs f-center">
          <h3 class="fz-12">Block</h3>

          <div onclick="toggleBlockInline()"
            class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

            <div id="bswitchBlockInline"
              class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
              style="transition: all 0.2s ease;">
            </div>
          </div>

          <h3 class="fz-12">Inline</h3>
        </div>

        <!-- DEMO -->
        <div class="bg-g1 ra-md pa-md mb-sm">
          <div id="blockInlineBox" class="dis-block bg-main-h pa-sm ra-sm clr-white">
            Box 1
          </div>
          <div class="bg-sub pa-sm ra-sm clr-white">Box 2</div>
        </div>

        <p class="fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>dis-block</b> → element takes full width and moves to next line.<br>
          🟢 <b>dis-inline</b> → elements stay on the same line like text.
        </p>
      </div>
    </div>
    <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
      <h3>Inline vs Inline-block</h3>
      <div class="flex-y gap-xxs">

        <!-- bswITCH -->
        <div class="flex-x gap-xs f-center">
          <h3 class="fz-12">Inline</h3>

          <div onclick="toggleInlineBlock()"
            class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

            <div id="bswitchInlineBlock"
              class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
              style="transition: all 0.2s ease;">
            </div>
          </div>

          <h3 class="fz-12">Inline-block</h3>
        </div>

        <!-- DEMO -->
        <div class="bg-g1 ra-md pa-md mb-sm">
          <div id="inlineBox"
            class="dis-inline bg-main-h pa-md ra-sm clr-white">
            width matters
          </div>
        </div>

        <p class="fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>dis-inline</b> ignores width/height.<br>
          🟢 <b>dis-inline-block</b> allows width/height while staying inline.
        </p>
      </div>
    </div>
    <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
      <h3>Block vs Flex</h3>
      <div class="flex-y gap-xxs">

        <!-- bswITCH -->
        <div class="flex-x gap-xs f-center">
          <h3 class="fz-12">Block</h3>

          <div onclick="toggleFlex()"
            class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

            <div id="bswitchFlex"
              class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
              style="transition: all 0.2s ease;">
            </div>
          </div>

          <h3 class="fz-12">Flex</h3>
        </div>

        <!-- DEMO -->
        <div id="flexBox" class="dis-block bg-g1 ra-md pa-md mb-sm">

          <div class="bg-main pa-sm clr-white">1</div>
          <div class="bg-sub pa-sm clr-white">2</div>
          <div class="bg-acnt pa-sm clr-white">3</div>

        </div>

        <p class="fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>dis-block</b> stacks elements vertically.<br>
          🟢 <b>dis-flex</b> arranges elements in a row by default.
        </p>
      </div>
    </div>
    <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
      <h3>Flex vs Grid</h3>
      <div class="flex-y gap-xxs">

        <!-- bswITCH -->
        <div class="flex-x gap-xs f-center">
          <h3 class="fz-12">Flex</h3>

          <div onclick="toggleGrid()"
            class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

            <div id="bswitchGrid"
              class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
              style="transition: all 0.2s ease;">
            </div>
          </div>

          <h3 class="fz-12">Grid</h3>
        </div>

        <!-- DEMO -->
        <div id="gridBox" class="dis-flex gap-sm bg-g1 ra-md pa-md mb-sm">

          <div class="bg-main pa-sm clr-white">1</div>
          <div class="bg-sub pa-sm clr-white">2</div>
          <div class="bg-acnt pa-sm clr-white">3</div>
          <div class="bg-main-h pa-sm clr-white">4</div>

        </div>

        <p class="fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>dis-flex</b> is one-directional (row/column).<br>
          🟢 <b>dis-grid</b> creates a 2D layout (rows + columns).
        </p>
      </div>
    </div>
    <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
      <h3>Display None</h3>
      <div class="flex-y gap-xxs">

        <!-- bswITCH -->
        <div class="flex-x gap-xs f-center">
          <h3 class="fz-12">Block</h3>

          <div onclick="toggleNone()"
            class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

            <div id="bswitchNone"
              class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
              style="transition: all 0.2s ease;">
            </div>
          </div>

          <h3 class="fz-12">None</h3>
        </div>

        <!-- DEMO -->
        <div class="bg-g1 ra-md pa-md mb-sm">
          <div id="noneBox" class="bg-acnt pa-md clr-white">
            I disappear completely
          </div>
        </div>

        <p class="fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>dis-none</b> removes the element completely.<br>
          🔴 No space is reserved in layout.
        </p>
      </div>
    </div>
    <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
      <h3>Block vs Contents</h3>
      <div class="flex-y gap-xxs">

        <!-- bswITCH -->
        <div class="flex-x gap-xs f-center">
          <h3 class="fz-12">Block</h3>

          <div onclick="toggleContents()"
            class="bg-g3 w-50px h-20px ra-max pn-relative cur-pointer">

            <div id="bswitchContents"
              class="bg-white w-20px h-20px ra-max pn-absolute t-0 l-0"
              style="transition: all 0.2s ease;">
            </div>
          </div>

          <h3 class="fz-12">Contents</h3>
        </div>

        <!-- DEMO -->
        <div class="bg-g1 ra-md pa-md mb-sm">

          <!-- OUTER CONTAINER -->
          <div class="bg-g7 pa-sm ra-sm">

            <!-- WRAPPER (THIS WILL DISAPPEAR) -->
            <div id="contentbswrapper" class="dis-block bg-main-h pa-sm ra-sm">

              <h3 class="clr-white fz-12">Wrapper</h3>

              <div class="bg-sub pa-sm mt-xs clr-white">Child 1</div>
              <div class="bg-acnt pa-sm mt-xs clr-white">Child 2</div>

            </div>

          </div>

        </div>

        <!-- NOTE -->
        <p class="fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>dis-block</b> → wrapper exists and controls layout.<br>
          🟢 <b>dis-contents</b> → wrapper disappears, only children remain.<br>
          🟡 Children behave as if they moved to the parent level.<br>
          🔴 Wrapper styles (background, padding, border) are lost.
        </p>
      </div>
    </div>

    <script>
      function toggleBlockInline() {
        const el = document.getElementById("blockInlineBox");
        const knob = document.getElementById("bswitchBlockInline");

        el.classList.toggle("dis-inline");
        el.classList.toggle("dis-block");

        knob.style.left = el.classList.contains("dis-inline") ? "30px" : "0";
      }

      function toggleInlineBlock() {
        const el = document.getElementById("inlineBox");
        const knob = document.getElementById("bswitchInlineBlock");

        el.classList.toggle("dis-inline-block");
        el.classList.toggle("dis-inline");

        knob.style.left = el.classList.contains("dis-inline-block") ? "30px" : "0";
      }

      function toggleFlex() {
        const el = document.getElementById("flexBox");
        const knob = document.getElementById("bswitchFlex");

        el.classList.toggle("dis-flex");
        el.classList.toggle("dis-block");

        knob.style.left = el.classList.contains("dis-flex") ? "30px" : "0";
      }

      function toggleGrid() {
        const el = document.getElementById("gridBox");
        const knob = document.getElementById("bswitchGrid");

        el.classList.toggle("dis-grid");
        el.classList.toggle("dis-flex");

        knob.style.left = el.classList.contains("dis-grid") ? "30px" : "0";
      }

      function toggleNone() {
        const el = document.getElementById("noneBox");
        const knob = document.getElementById("bswitchNone");

        el.classList.toggle("dis-none");

        knob.style.left = el.classList.contains("dis-none") ? "30px" : "0";
      }


      function toggleContents() {
        const el = document.getElementById("contentbswrapper");
        const knob = document.getElementById("bswitchContents");

        el.classList.toggle("dis-contents");
        el.classList.toggle("dis-block");

        knob.style.left = el.classList.contains("dis-contents") ? "30px" : "0";
      }
    </script>