<div class="grid gap-lg">

  <!-- ===================================================== -->
  <!-- ACTIVE STATE TESTING -->
  <!-- ===================================================== -->

  <div class="g-12 pn-relative bg-white ra-lg pa-lg">

    <span class="fz-16 py-xxs px-xs ra-md pn-absolute t-0 l-0 bg-g1 clr-g5">
      Active System Test (ac-group)
    </span>

    <p class="mt-lg mb-sm fz-14 clr-g6">
      Clicking a card should move <b>.active</b> to that card only.
      Tests ac-group, ac:, cac:, and active isolation.
    </p>

    <div class="ac-group grid gap-md">

      <div class="g-4 ba-xs pa-sm">
        <img src="img/roses.png" class="mx-auto ts-3 ac:blur-sm">
        <p class="txt-center mt-sm">
          ac:blur-sm
        </p>
      </div>

      <div class="g-4 ba-xs pa-sm">
        <img src="img/roses.png" class="mx-auto ts-3 ac:blur-lg">
        <p class="txt-center mt-sm">
          ac:blur-lg
        </p>
      </div>

      <div class="g-4 ba-xs pa-sm">
        <img src="img/roses.png" class="mx-auto ts-3 ac:blur-md">
        <p class="txt-center mt-sm">
          ac:blur-md
        </p>
      </div>

    </div>

  </div>



  <!-- ===================================================== -->
  <!-- ACTIVE GROUP ISOLATION -->
  <!-- ===================================================== -->

  <div class="g-12 pn-relative bg-white ra-lg pa-lg">

    <span class="fz-16 py-xxs px-xs ra-md pn-absolute t-0 l-0 bg-g1 clr-g5">
      Active Group Isolation
    </span>

    <p class="mt-lg mb-sm fz-14 clr-g6">
      Group A and Group B should not affect each other.
    </p>

    <div class="grid gap-md">

      <div class="g-6">

        <p class="mb-xs fw-600">
          Group A
        </p>

        <div class="ac-group flex-x gap-sm">

          <div class="ba-xs pa-xs ac:blur-sm">
            A1
          </div>

          <div class="ba-xs pa-xs ac:blur-sm">
            A2
          </div>

          <div class="ba-xs pa-xs ac:blur-sm">
            A3
          </div>

        </div>

      </div>

      <div class="g-6">

        <p class="mb-xs fw-600">
          Group B
        </p>

        <div class="ac-group flex-x gap-sm">

          <div class="ba-xs pa-xs ac:blur-sm">
            B1
          </div>

          <div class="ba-xs pa-xs ac:blur-sm">
            B2
          </div>

          <div class="ba-xs pa-xs ac:blur-sm">
            B3
          </div>

        </div>

      </div>

    </div>

  </div>



  <!-- ===================================================== -->
  <!-- SELECT STATE TESTING -->
  <!-- ===================================================== -->

  <div class="g-12 pn-relative bg-white ra-lg pa-lg">

    <span class="fz-16 py-xxs px-xs ra-md pn-absolute t-0 l-0 bg-g1 clr-g5">
      Select System Test (sl-group)
    </span>

    <p class="mt-lg mb-sm fz-14 clr-g6">
      Multiple items should remain selected simultaneously.
    </p>

    <div class="sl-group grid gap-md">

      <div class="g-3 ba-xs pa-sm txt-center">
        <img src="img/roses.png" class="mx-auto ts-3 sl:blur-sm">
        <p class=" mt-sm">
          sl:blur-sm
        </p>
      </div>

      <div class="g-3 ba-xs pa-sm txt-center">
        <img src="img/roses.png" class="mx-auto ts-3 sl:blur-lg">
        <p class="mt-sm">
          sl:blur-lg
        </p>
      </div>

      <div class="g-3 ba-xs pa-sm txt-center">
        <img src="img/roses.png" class="mx-auto ts-3 sl:blur-md">
        <p class=" mt-sm">
          sl:blur-md
        </p>
      </div>

      <div class="g-3 ba-xs pa-sm txt-center">
        <img src="img/roses.png" class="mx-auto ts-3 sl:blur-xl">
        <p class=" mt-sm">
          sl:blur-xl
        </p>
      </div>

    </div>

  </div>


  <!-- ===================================================== -->
  <!-- SELECT TOOLS TEST -->
  <!-- ===================================================== -->

  <div class="g-6 pn-relative bg-white ra-lg pa-lg">

    <span class="fz-16 py-xxs px-xs ra-md pn-absolute t-0 l-0 bg-g1 clr-g5">
      Select Group Isolation
    </span>

    <div
      class="sl-group mt-lg grid gap-md">

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 1
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 2
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 3
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 4
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 5
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 6
      </div>

    </div>

  </div>

  <div class="g-6 pn-relative bg-white ra-lg pa-lg">

    <span class="fz-16 py-xxs px-xs ra-md pn-absolute t-0 l-0 bg-g1 clr-g5">
      Select All / Clear Test
    </span>

    <div
      class="sl-group mt-lg grid gap-md"
      data-select="gallery"
      data-max="3">

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 1
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 2
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 3
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 4
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 5
      </div>

      <div class="g-2 ba-xs pa-sm txt-center sl:blur-md">
        Item 6
      </div>

    </div>

    <div class="flex-x gap-sm mt-md">

      <button
        onclick="
          StateEngine.selectAll(
            document.querySelector('[data-select=gallery]')
          )
        ">
        Select All
      </button>

      <button
        onclick="
          StateEngine.clearSelect(
            document.querySelector('[data-select=gallery]')
          )
        ">
        Clear
      </button>

    </div>

    <p class="mt-sm fz-12 clr-g6">
      data-max='3' should prevent selecting more than 3 items.
    </p>

  </div>


</div>

