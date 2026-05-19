  <h3 class="d-h3 demo">Universal Class Order (Mental Model)</h3>

  <div class="grid gap-sm">
    <div class="g-6 bg-white bw-2 ra-xxs clr-g1 of-hidden fs-12px">


      <div class="grid bg-g2 fw-600 p-xs">
        <div class="g-1 clr-white">#</div>
        <div class="g-3 clr-white">Concept</div>
        <div class="g-4 clr-white">Meaning</div>
        <div class="g-4 clr-white">Classes</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">1</div>
        <div class="g-3 fw-600">Display & Layout</div>
        <div class="g-4">HOW it behaves</div>
        <div class="g-4 clr-g5">dis-*, grid, flex-*</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">2</div>
        <div class="g-3 fw-600">Positioning</div>
        <div class="g-4">WHERE it sits</div>
        <div class="g-4 clr-g5">pn-*, inset-0</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">3</div>
        <div class="g-3 fw-600">Size</div>
        <div class="g-4">HOW big it is</div>
        <div class="g-4 clr-g5">w-*, mw-*, ar-*, img-</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">4</div>
        <div class="g-3 fw-600">Spacing</div>
        <div class="g-4">HOW spaced</div>
        <div class="g-4 clr-g5">m-*, p-*, gap-*, m-auto</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">5</div>
        <div class="g-3 fw-600">Structure</div>
        <div class="g-4">HOW arranged</div>
        <div class="g-4 clr-g5">flex-*, f-*</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">6</div>
        <div class="g-3 fw-600">Visual</div>
        <div class="g-4">HOW it looks</div>
        <div class="g-4 clr-g5">bg-*, bw-*, ra-*, of-*</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">7</div>
        <div class="g-3 fw-600">Typography</div>
        <div class="g-4">HOW text looks</div>
        <div class="g-4 clr-g5">clr-*, fs-*, fw-*, lh-*, ta-*</div>
      </div>


      <div class="grid p-xs clr-g4">
        <div class="g-1">8</div>
        <div class="g-3 fw-600">Effects</div>
        <div class="g-4">Extras</div>
        <div class="g-4 clr-g5">z-*, op-*</div>
      </div>

    </div>
    <div class="g-6 bg-g1 px-lg py-md ra-sm">
      <div class="flex-y gap-xs fs-12px w-300px">

        <div class="bg-g2 px-sm py-xxs ra-sm">

          <!-- SECTION -->
          <p class="fw-600 ml-md clr-g7">
            <b>Section</b>&nbsp;→&nbsp;bg-&nbsp;(Background&nbsp;/&nbsp;page&nbsp;surface)
          </p>

          <div class="bg-g3 px-sm py-xxs ra-sm mt-xs">

            <!-- POSITION -->
            <p class="fw-600 ml-md clr-g7">
              <b>Positioning</b>&nbsp;→&nbsp;pn-,&nbsp;inset-&nbsp;(relative&nbsp;/&nbsp;absolute)
            </p>

            <div class="bg-g4 px-sm py-xxs ra-sm mt-xs clr-white">

              <!-- SIZE -->
              <p class="fw-600 ml-md clr-g7">
                <b>Size</b>&nbsp;→&nbsp;w-,&nbsp;mw-,&nbsp;ar-,&nbsp;img-&nbsp;(width&nbsp;/&nbsp;ratio)
              </p>

              <div class="bg-g5 px-sm py-xxs ra-sm mt-xs clr-g1">

                <!-- SPACING -->
                <p class="fw-600 ml-md clr-g7">
                  <b>Spacing</b>&nbsp;→&nbsp;m-,&nbsp;p-,&nbsp;gap-&nbsp;(outside&nbsp;/&nbsp;inside&nbsp;space)
                </p>

                <div class="bg-g6 px-sm py-xxs ra-sm mt-xs">

                  <!-- STRUCTURE -->
                  <p class="fw-600 ml-md clr-g7">
                    <b>Structure</b>&nbsp;→&nbsp;flex-,&nbsp;f-&nbsp;(direction&nbsp;/&nbsp;alignment)
                  </p>

                  <div class="bg-g7 px-sm py-xxs ra-sm mt-xs">

                    <!-- VISUAL -->
                    <p class="fw-600 ml-md clr-g7">
                      <b>Visual</b>&nbsp;→&nbsp;bg-,&nbsp;bw-,&nbsp;ra-,&nbsp;of-&nbsp;(style&nbsp;/&nbsp;shape)
                    </p>

                    <div class="bg-g8 px-sm py-xxs ra-sm mt-xs">

                      <!-- TYPOGRAPHY -->
                      <p class="fw-600 ml-md clr-g7">
                        <b>Typography</b>&nbsp;→&nbsp;clr-,&nbsp;fs-,&nbsp;fw-,&nbsp;lh-,&nbsp;ta-&nbsp;(text)
                      </p>

                      <div class="bg-g9 px-sm py-xxs ra-sm mt-xs">

                        <!-- EFFECTS -->
                        <p class="fw-600 ml-md clr-g7">
                          <b>Effects</b>&nbsp;→&nbsp;z-,&nbsp;op-&nbsp;(layering&nbsp;/&nbsp;depth)
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <h3 class="d-h3 demo"> How a Component is Built <small>Place → Shape → Align → Content</small></h3>

  <div class="grid gap-lg p-lg bg-g1">
    <div class="g-12">
      <div class="grid gap-md">

        <div class="g-3 flex-y gap-xs">
          <p class="fs-13px fw-700">1. PLACE</p>
          <div class=" ar-1 flex-y f-center f-middle bg-g2 ">
            <p class="fs-12px">Img Name Role</p>
          </div>
          <p class="fs-10px clr-g5"> 📍 Only position on page (grid, g-*) </p>
          <pre><code>&lt;div class="grid"&gt;
  &lt;div class="g-3"&gt;
    Img Name Role
  &lt;/div&gt;
&lt;/div&gt;</code></pre>
        </div>

        <div class="g-3 flex-y gap-xs">
          <p class="fs-13px fw-700">2. + SHAPE</p>
          <div class=" ar-1 flex-y f-center f-middle bg-white bw-2 ra-md clr-g5 p-sm">
            <p class="fs-12px">Img Name Role</p>
          </div>
          <p class="fs-10px clr-g5"> 🧱 Now it becomes a block (+ background + border + radius) </p>
          <pre><code>&lt;div class="grid"&gt;
  &lt;div class="g-3"&gt;
  
    &lt;div class="bg-white bw-2 ra-md"&gt;
      Img Name Role
    &lt;/div&gt;

&lt;/div&gt;</code></pre>
        </div>

        <div class="g-3 flex-y gap-xs">
          <p class="fs-13px fw-700">3. + ALIGN</p>
          <div class=" ar-1 flex-y f-center bg-white bw-2 ra-md clr-g5 p-sm">
            <div class="ar-1 bg-g3 ra-max clr-g3"> 0 </div>
            <div class="flex-y f-center gap-xxs mt-sm">
              <p class="fs-12px">Name</p>
              <p class="fs-10px clr-g5">Role</p>
            </div>
          </div>
          <p class="fs-10px clr-g5"> 📐 Structured layout inside (+ flex + spacing) </p>
          <pre><code>&lt;div class="grid"&gt;
  &lt;div class="g-3"&gt;
    &lt;div class="bg-white bw-2 ra-md"&gt;

      &lt;div class="ar-1 ra-max"&gt; 
        Img 
      &lt;/div&gt;
      &lt;div class="flex-y f-center gap-xxs"&gt;
        &lt;p&gt; Name &lt;/p&gt;
        &lt;p&gt; Role &lt;/p&gt;
      &lt;/div&gt;
    
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
        </div>

        <div class="g-3 flex-y gap-xs">
          <p class="fs-13px fw-700">4. + CONTENT</p>
          <div class=" ar-1 flex-y bg-white bw-2 ra-md clr-g5 p-md ">
            <div class="ar-1 ra-max of-hidden bg-g2 flex-y f-center f-middle mw-100 mw-add-30 m-auto">
              <img src="img/800x1200.jpg" alt="">
            </div>
            <div class="flex-y f-center gap-xs mt-sm">
              <p class="ta-center fs-16px fw-600 lh-12 clr-g8"> John Doe </p>
              <p class="ta-center fs-14px lh-12 clr-g5"> Software Engineer </p>
            </div>
          </div>
          <p class="fs-10px clr-g5"> ✅ Final usable UI component (+ real content + typography)</p>
          <pre><code>&lt;div class="grid"&gt;
  &lt;div class="g-3"&gt;
    &lt;div class="bg-white bw-2 ra-md"&gt;

      &lt;div class="ar-1 ra-max m-auto"&gt; 
        &lt;img src="" alt=""&gt;
      &lt;/div&gt;
      &lt;div class="flex-y f-center gap-xxs"&gt;
        
        &lt;p class="fs-16px lh-12 clr-g8"&gt; 
          Name 
        &lt;/p&gt;
        &lt;p class="fs-14px lh-12 clr-g5"&gt; 
          Role 
        &lt;/p&gt;
      
      &lt;/div&gt;
    
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
        </div>

      </div>
    </div>

  </div>