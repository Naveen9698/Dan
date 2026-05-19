 <style>
   .img-system-demo {
     display: grid;
     gap: 40px;
     max-width: 1300px;
   }

   .img-system-demo .demo-row {
     display: grid;
     gap: 20px;
   }

   .img-system-demo .demo-row-title {
     font-size: 14px;
     font-weight: 600;
     color: #111827;
   }

   .img-system-demo .demo-row-desc {
     font-size: 13px;
     color: #6b7280;
     max-width: 800px;
   }

   .img-system-demo .demo-grid {
     display: grid;
     grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
     gap: 20px;
   }

   .img-system-demo .demo-card {
     background: #ffffff;
   }

   .img-system-demo .demo-label {
     display: flex;
     flex-direction: column;
     padding: 10px 14px;
     font-size: 12px;
     color: #374151;
     gap: 10px;
     border-top: 1px solid #e5e7eb;
     background: #fafafa;
   }

   .img-system-demo .demo-label b {
     color: #111827;
   }
 </style>

 <div class="img-system-demo">

   <div class="demo-row">
     <div class="demo-row-title">1. Direct image vs Background image</div>
     <div class="demo-row-desc">
       Same image source placed in two different systems.
       One participates in document flow, the other becomes a visual layer.
     </div>

     <div class="demo-grid bg-g1 p-sm ra-sm">

       <div class="demo-card" style="max-width:260px;">
         <img
           src="http://localhost/StyleGuide/img/1000x15000.jpg"
           alt="">
         <div class="demo-label">
           <b>Direct image</b>
           <pre><code>&lt;img src="" alt=""&gt;</code></pre>
           Natural flow · intrinsic size · no overlap
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-16x9">
           <img
             src="http://localhost/StyleGuide/img/1000x15000.jpg"
             class="bg-img"
             alt="">
         </div>
         <div class="demo-label">
           <b>Background like image</b>
           <pre><code>&lt;div class="bg-container ar-16x9"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
           Detached from flow · layered · clipped
         </div>
       </div>

     </div>
   </div>

   <div class="demo-row">
     <div class="demo-row-title">
       2. Anchoring controls focal point, not size
     </div>

     <div class="demo-row-desc">
       Same image. Same container. Same aspect ratio.
       <b>Only the anchor changes.</b>
       This demonstrates how <code>object-position</code> preserves different
       focal points without resizing or stretching the image.
     </div>

     <div class="demo-grid bg-g1 p-sm ra-sm" style="grid-template-columns:repeat(3, minmax(260px, 1fr))">

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-tl" style="height: 500px;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-tl</b> Top · Left
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-tl"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-t" style="height: 500px;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-t</b> Top
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-t"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-tr" style="height: 500px;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-tr</b> Top · Right
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-tr"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-l" style="height: 500px;top: -50%;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-l</b> Left
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-l"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img" style="height: 500px;top: -50%;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>Center (default)</b> object-position: center
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-r" style="height: 500px;top: -50%;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-r</b> Right
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-r"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-bl" style="height: 500px; top: -100%;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-bl</b> Bottom · Left
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-bl"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <!-- Center -->

       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-b" style="height: 500px; top: -100%;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-b</b> Bottom
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-b"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

       <!-- RIGHT -->


       <div class="demo-card">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/1200x800.jpg"
             class="bg-img bg-br" style="height: 500px; top: -100%;"
             alt="" />
         </div>
         <div class="demo-label">
           <b>.bg-br</b> Bottom · Right
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-br"&gt;
&lt;/div&gt;</code></pre>
         </div>
       </div>

     </div>
   </div>

   <!-- ===================================================== -->
   <!-- ROW 3: ASPECT RATIO CONTROL -->
   <!-- ===================================================== -->

   <div class="demo-row">
     <div class="demo-row-title">3. Aspect ratio defines layout before image load</div>
     <div class="demo-row-desc">
       Aspect ratio is applied to containers, not images.
       This stabilizes layout and makes media predictable.
     </div>

     <div class="demo-grid bg-g1 p-sm ra-sm">

       <div class="demo-card flex-y f-spread">
         <div class="bg-container ar-1">
           <img
             src="http://localhost/StyleGuide/img/800x1200.jpg"
             class="bg-img"
             alt="">
         </div>
         <div class="demo-label">
           <b>1 : 1</b>
           <pre><code>&lt;div class="bg-container ar-1"&gt;
  &lt;img class="bg-img"&gt;
&lt;/div&gt;</code></pre>
           Avatar / thumbnail
         </div>
       </div>

       <div class="demo-card flex-y f-spread">
         <div class="bg-container ar-4x3">
           <img
             src="http://localhost/StyleGuide/img/800x1200.jpg"
             class="bg-img"
             alt="">
         </div>
         <div class="demo-label">
           <b>4 : 3</b>
           <pre><code>&lt;div class="bg-container ar-4x3"&gt;
  &lt;img class="bg-img"&gt;
&lt;/div&gt;</code></pre>
           Editorial image
         </div>
       </div>

       <div class="demo-card flex-y f-spread">
         <div class="bg-container ar-3x2">
           <img
             src="http://localhost/StyleGuide/img/800x1200.jpg"
             class="bg-img"
             alt="">
         </div>
         <div class="demo-label">
           <b>3 : 2</b>
           <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img"&gt;
&lt;/div&gt;</code></pre>
           Cards / Featured stories
         </div>
       </div>

       <div class="demo-card flex-y f-spread">
         <div class="bg-container ar-16x9">
           <img
             src="http://localhost/StyleGuide/img/800x1200.jpg"
             class="bg-img"
             alt="">
         </div>
         <div class="demo-label">
           <b>16 : 9</b>
           <pre><code>&lt;div class="bg-container ar-16x9"&gt;
  &lt;img class="bg-img"&gt;
&lt;/div&gt;</code></pre>
           Hero / media banner
         </div>
       </div>

     </div>
   </div>

   <!-- ===================================================== -->
   <!-- ROW 4: LAYERING & Z-INDEX -->
   <!-- ===================================================== -->

   <div class="demo-row">
     <div class="demo-row-title">4. Layered media with overlay and content</div>
     <div class="demo-row-desc">
       Background image, overlay, and content are stacked explicitly
       using position and z-index utilities.
     </div>

     <div class="demo-grid bg-g1 p-sm ra-sm">

       <div class="demo-card">
         <div class="bg-container ar-16x9 pn-relative">
           <img
             src="http://localhost/StyleGuide/img/3000x3000.jpg"
             class="bg-img z-1"
             alt="">
           <div class="bg-overlay z-2"
             style="background:rgba(0,0,0,.45)"></div>
           <div class="pn-relative z-3 clr-white p-xs">
             <b>Layered content</b><br>
             <span class="fs-12px">
               image · overlay · text
             </span>
           </div>
         </div>
         <div class="demo-label">
           <b>Explicit layering</b>
           <pre><code>&lt;div class="bg-container ar-16x9 pn-relative"&gt;

  &lt;img src="3000x3000.jpg" class="bg-img z-1" alt=""&gt;

  &lt;div class="bg-overlay z-2" style="background:rgba(0,0,0,.45)"&gt;&lt;/div&gt;

  &lt;div class="pn-relative z-3 clr-white p-xs"&gt;
    &lt;b&gt;Layered content&lt;/b&gt;&lt;br&gt;
    &lt;span class="fs-12"&gt;
      image · overlay · text
    &lt;/span&gt;
  &lt;/div&gt;
  
&lt;/div&gt;</code></pre>
           No implicit stacking
         </div>
       </div>

     </div>
   </div>

 </div>