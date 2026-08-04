<div class="grid gap-sm">
  <div class="g-12 flex-y bg-white gap-xxs bsw-sm ra-sm pa-sm fz-12">
    <span class="fz-18 fw-600 clr-g8 mb-xs">px Width (Fixed)</span>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1px"></div>
      1px = w-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-10px"></div>
      10px = w-10px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-10px w-add-1px"></div>
      11px = w-10px w-add-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-100px"></div>
      100px = w-100px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-100px w-add-1px"></div>
      101px = w-100px w-add-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-110px"></div>
      110px = w-110px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-110px w-add-1px"></div>
      111px = w-110px w-add-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1000px"></div>
      1000px = w-1000px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1000px w-add-1px"></div>
      1001px = w-1000px w-add-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1010px"></div>
      1010px = w-1010px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1010px w-add-1px"></div>
      1011px = w-1010px w-add-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1100px"></div>
      1100px = w-1100px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1110px"></div>
      1110px = w-1110px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1110px w-add-1px"></div>
      1111px = w-1110px w-add-1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1400px"></div>
      1400px = w-1400px (Max)
    </div>
    <p>
    </p>
  </div>
  <div class="g-12 bg-white flex-y gap-xxs bsw-sm ra-sm pa-sm fz-12">
    <span class="fz-14 fw-600 clr-g8">vw Width (Based on viewport)</span>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-1vw"></div>
      1vw = w-1vw
    </div>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-10vw"></div>
      10vw = w-10vw
    </div>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-10vw w-add-1vw"></div>
      11vw = w-10vw w-add-1vw
    </div>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-100vw"></div>
      100vw = w-100vw
    </div>
  </div>

  <div class="g-12 bg-white flex-y gap-xxs bsw-sm ra-sm pa-sm fz-12">
    <span class="fz-14 fw-600 clr-g8">% Width (Based on container)</span>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-1p"></div>
      1% = w-1p
    </div>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-10p"></div>
      10% = w-10p
    </div>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-10p w-add-1p"></div>
      11% = w-10p w-add-1p
    </div>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-100p"></div>
      100% = w-100p
    </div>
  </div>
</div>

<div class="mt-sm">
  <label>
    Container Width: <span id="rangeVal">100%</span>
  </label>
  <input class="w-100p" type="range" id="widthRange" min="10" max="100" value="100" />
</div>

<div id="demoWrapper" class="w-100p mb-md">

  <div class="grid gap-xxs bg-white bsw-md pa-sm fz-12px" id="demoWrapper">

    <div class="g-12 flex-y fz-12 gap-xxs mb-xs">
      <span class="fz-14 fw-600 clr-g8">Full Combination</span>

      <div class="bg-g8 py-xxs
                  w-80p w-add-4p
                  w-220min w-add-2min
                  w-550max w-add-5max"></div>
      <p>
        width: 84% | min: 222px | max: 555px <br> <br>
        84% = w-80p w-add-4p <br>
        222px = w-220min w-add-2min <br>
        555px = w-550max w-add-5max <br>
      </p>
    </div>


    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fz-14px fw-600 clr-g8">Width (px)</span>

      <div class="flex-y gap-xxs">
        <div class="bg-main clr-white pa-xxs fz-12 w-500px">
          500px = w-500px
        </div>

        <div class="bg-main clr-white pa-xxs fz-12 w-500px w-add-5px">
          505px = w-500px + w-add-5px
        </div>

        <div class="bg-main clr-white pa-xxs fz-12 w-500px w-add-5px">
          555px = w-550px + w-add-5px
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fz-14px fw-600 clr-g8">Width (%)</span>

      <div class="flex-y gap-xxs">
        <div class="bg-acnt clr-white pa-xxs fz-12 w-50p">
          50% = w-50p
        </div>

        <div class="bg-acnt clr-white pa-xxs fz-12 w-50p w-add-5p">
          55% = w-50p + w-add-5p
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fz-14px fw-600 clr-g8">Width (vw)</span>

      <div class="flex-y gap-xxs">
        <div class="bg-sub clr-white pa-xxs fz-12 w-50vw">
          50vw = w-50vw
        </div>

        <div class="bg-sub clr-white pa-xxs fz-12 w-50vw w-add-5vw">
          55vw = w-50vw + w-add-5vw
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fz-14px fw-600 clr-g8">Min Width</span>
      <div class="flex-y gap-xxs">
        <div class="bg-main-h clr-g8 pa-xxs fz-12 w-500px w-200min">
          px min => w-500px w-200min
        </div>
        <div class="bg-sub-h clr-g8 pa-xxs fz-12 w-50vw w-200min">
          vw min => w-50vw w-200min
        </div>
        <div class="bg-acnt-h clr-g8 pa-xxs fz-12 w-50p w-200min">
          % min => w-50p w-200min
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fz-14px fw-600 clr-g8">Max Width</span>
      <div class="flex-y gap-xxs">
        <div class="bg-main-h clr-g8 pa-xxs fz-12 w-500px w-600max">
          px max => w-500px w-600max
        </div>
        <div class="bg-sub-h clr-g8 pa-xxs fz-12 w-50vw w-500max">
          vw max => w-50vw w-500max
        </div>
        <div class="bg-acnt-h clr-g8 pa-xxs fz-12 w-50p w-500max">
          % max => w-50p w-500max
        </div>
      </div>
    </div>

  </div>

</div>

<script>
  const range = document.getElementById("widthRange");
  const wrapper = document.getElementById("demoWrapper");
  const label = document.getElementById("rangeVal");

  range.addEventListener("input", function() {
    const value = range.value + "%";
    wrapper.style.width = value;
    label.textContent = value;
  });
</script>