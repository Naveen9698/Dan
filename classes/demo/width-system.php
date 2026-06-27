<div class="grid gap-sm">
  <div class="g-12 flex-y bg-white gap-xxs sw-sm ra-sm pa-sm fs-12">
    <span class="fs-14 fw-600 clr-g8">px Width (Fixed)</span>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1px"></div>
      1px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-10px"></div>
      10px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-10px w-add-1px"></div>
      11px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-100px"></div>
      100px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-100px w-add-1px"></div>
      101px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-100px w-add-10px"></div>
      110px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-100px w-add-10px w-add-1px"></div>
      111px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1000px"></div>
      1000px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1000px w-add-1px"></div>
      1001px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1000px w-add-10px"></div>
      1010px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1000px w-add-10px w-add-1px"></div>
      1011px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1100px"></div>
      1100px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1100px w-add-10px"></div>
      1110px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1100px w-add-10px w-add-1px"></div>
      1111px
    </div>
    <div class="gap-y-xxs">
      <div class="bg-main py-xxs mr-xxs w-1400px w-add-90px w-add-9px"></div>
      1499px
    </div>
    <p>
      1px &nbsp;&nbsp;&nbsp;= w-1px <br>
      10px &nbsp;&nbsp;= w-10px <br>
      11px &nbsp;&nbsp;= w-10px w-add-1px <br>
      100px &nbsp;= w-100px <br>
      101px &nbsp;= w-100px w-add-1px <br>
      110px &nbsp;= w-100px w-add-10px <br>
      111px &nbsp;= w-100px w-add-10px w-add-1px <br>
      1000px = w-1000px <br>
      1001px = w-1000px w-add-1px <br>
      1010px = w-1000px w-add-10px <br>
      1011px = w-1000px w-add-10px w-add-1px <br>
      1100px = w-1100px <br>
      1110px = w-1100px w-add-10px <br>
      1111px = w-1100px w-add-10px w-add-1px <br>
      1499px = w-1400px w-add-90px w-add-9px (Max)
    </p>
  </div>
  <div class="g-12 bg-white flex-y gap-xxs sw-sm ra-sm pa-sm fs-12">
    <span class="fs-14 fw-600 clr-g8">vw Width (Based on viewport)</span>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-1vw"></div>
      1vw
    </div>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-10vw"></div>
      10vw
    </div>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-10vw w-add-1vw"></div>
      11vw
    </div>
    <div class="gap-y-xxs">
      <div class="bg-sub py-xxs mr-xxs w-100vw"></div>
      100vw
    </div>
    <p>
      1vw &nbsp;&nbsp;= w-1vw<br>
      10vw &nbsp;= w-10vw<br>
      11vw &nbsp;= w-10vw w-add-1vw <br>
      100vw = w-100vw<br>
    </p>
  </div>

  <div class="g-12 bg-white flex-y gap-xxs sw-sm ra-sm pa-sm fs-12">
    <span class="fs-14 fw-600 clr-g8">% Width (Based on container)</span>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-1p"></div>
      1%
    </div>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-10p"></div>
      10%
    </div>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-10p w-add-1p"></div>
      11%
    </div>
    <div class="gap-y-xxs">
      <div class="bg-acnt py-xxs mr-xxs w-100p"></div>
      100%
    </div>
    <p>
      1% &nbsp;= w-1p<br>
      10% = w-10p<br>
      11% = w-10p w-add-1p <br>
      100% = w-100p<br>
    </p>
  </div>
</div>

<div class="mt-sm">
  <label>
    Container Width: <span id="rangeVal">100%</span>
  </label>
  <input class="w-100p" type="range" id="widthRange" min="10" max="100" value="100" />
</div>

<div id="demoWrapper" class="w-100p mb-md">

  <div class="grid gap-xxs bg-white sw-md pa-sm fs-12px" id="demoWrapper">

    <div class="g-12 flex-y fs-12 gap-xxs mb-xs">
      <span class="fs-14 fw-600 clr-g8">Full Combination</span>

      <div class="bg-g8 py-xxs
                  w-80p w-add-4p
                  w-200min w-add-20min w-add-2min
                  w-500max w-add-50max w-add-5max"></div>
      <p>
        width: 84% | min: 222px | max: 555px <br> <br>
        84% &nbsp;&nbsp;= w-80p w-add-4p <br>
        222px = w-200min w-add-20min w-add-2min <br>
        555px = w-500max w-add-50max w-add-5max <br>
      </p>
    </div>


    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fs-14px fw-600 clr-g8">Width (px)</span>

      <div class="flex-y gap-xxs">
        <div class="bg-main clr-white pa-xxs fs-12 w-500px">
          500px = w-500px
        </div>

        <div class="bg-main clr-white pa-xxs fs-12 w-500px w-add-5px">
          505px = w-500px + w-add-5px
        </div>

        <div class="bg-main clr-white pa-xxs fs-12 w-500px w-add-50px w-add-5px">
          555px = w-500px + w-add-50px + w-add-5px
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fs-14px fw-600 clr-g8">Width (vw)</span>

      <div class="flex-y gap-xxs">
        <div class="bg-sub clr-white pa-xxs fs-12 w-50vw">
          50vw = w-50vw
        </div>

        <div class="bg-sub clr-white pa-xxs fs-12 w-50vw w-add-5vw">
          55vw = w-50vw + w-add-5vw
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fs-14px fw-600 clr-g8">Width (%)</span>

      <div class="flex-y gap-xxs">
        <div class="bg-acnt clr-white pa-xxs fs-12 w-50p">
          50% = w-50p
        </div>

        <div class="bg-acnt clr-white pa-xxs fs-12 w-50p w-add-5p">
          55% = w-50p + w-add-5p
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fs-14px fw-600 clr-g8">Max Width</span>
      <div class="flex-y gap-xxs">
        <div class="bg-main-h clr-g8 pa-xxs fs-12 w-500px w-600max">
          vw max 500px = w-500px w-600max
        </div>
        <div class="bg-sub-h clr-g8 pa-xxs fs-12 w-50vw w-500max">
          vw max 500px = w-50vw w-500max
        </div>
        <div class="bg-acnt-h clr-g8 pa-xxs fs-12 w-50p w-500max">
          % max 500px = w-50p w-500max
        </div>
      </div>
    </div>

    <div class="g-12 flex-y gap-xxs mb-xs">
      <span class="fs-14px fw-600 clr-g8">Min Width</span>
      <div class="flex-y gap-xxs">
        <div class="bg-main-h clr-g8 pa-xxs fs-12 w-500px w-200min">
          px min 500px = w-500px w-200min
        </div>
        <div class="bg-sub-h clr-g8 pa-xxs fs-12 w-50vw w-200min">
          vw min 50vw = w-50vw w-200min
        </div>
        <div class="bg-acnt-h clr-g8 pa-xxs fs-12 w-50p w-200min">
          % min 50% = w-50p w-200min
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