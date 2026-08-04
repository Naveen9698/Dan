<div class="grid gap-md bg-white ra-lg pa-sm">

  <h3 class="g-12">Cursor Types</h3>

  <div class="g-12 flex-y gap-xxs">

    <div class="grid gap-sm mb-sm">

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-auto">
          cur-auto
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-default">
          cur-default
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-pointer">
          cur-pointer
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-text">
          cur-text
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-grab">
          cur-grab
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-grabbing">
          cur-grabbing
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-na">
          cur-na
        </div>
      </div>

      <div class="g-2 txt-center">
        <div class="pa-md bg-main-h clr-white ra-sm bsw-sm cur-wait">
          cur-wait
        </div>
      </div>

      <div class="g-2 txt-center">
        <button class="pa-md bg-main-h clr-white ra-sm bsw-sm ba-0 w-100p cur-progress">
          cur-progress
        </button>
      </div>

      <div class="g-2 txt-center">
        <button class="pa-md bg-main-h clr-white ra-sm bsw-sm ba-0 w-100p cur-zoom-in">
          cur-zoom-in
        </button>
      </div>

      <div class="g-2 txt-center">
        <button class="pa-md bg-main-h clr-white ra-sm bsw-sm ba-0 w-100p cur-zoom-out">
          cur-zoom-out
        </button>
      </div>

      <div class="g-2 txt-center">
        <button class="pa-md bg-main-h clr-white ra-sm bsw-sm ba-0 w-100p cur-none">
          cur-none
        </button>
      </div>

    </div>
  </div>

  <h3 class="g-12">Interactive States</h3>

  <div class="g-12 flex-y gap-xxs">

    <div class="grid gap-lg mb-sm">

      <div class="g-6">
        <div
          class="pa-md bg-main-h clr-white ra-md bsw-sm cur-grab"
          onmousedown="this.classList.replace('cur-grab','cur-grabbing')"
          onmouseup="this.classList.replace('cur-grabbing','cur-grab')"
          onmouseleave="this.classList.replace('cur-grabbing','cur-grab')">
          Drag (hold click) - grab / grabbing
        </div>
      </div>

      <div class="g-6">
        <button class="pa-md bg-main-h clr-white ra-md bsw-sm w-100p op-50" disabled>
          Disabled Button (op-50: Added for clarity)
        </button>
      </div>

    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 Cursor reflects interaction type (click, edit, drag) <br>
      🟡 Use pointer only on clickable elements <br>
      🟢 Buttons and links already use pointer by default <br>
      🟢 Add cursor only when behavior is not obvious <br>
      🟢 <b>cur-grab</b> indicates draggable elements <br>
      🟢 <b>cur-grabbing</b> appears while actively dragging (mousedown) <br>
      🟢 <b>disabled</b> automatically applies not-allowed + reduced opacity Added for clarity<br>
      🔴 Do not fake drag or disabled states — must reflect real behavior
    </p>
  </div>

</div>