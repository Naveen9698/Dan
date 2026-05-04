<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>True Infinite dMarquee (Glitch‑Free)</title>

<style>
  .dmarquee {
    width: 100%;
    overflow: hidden;
    border: 1px solid #ddd;
    background: #fff;
    padding: 10px 0;
    position: relative;
  }

  .dmarquee-dtrack {
    display: flex;
    white-space: nowrap;
    will-change: transform;
  }

  .dmarquee-item {
    padding: 0 40px;
    font-size: 22px;
    font-weight: 600;
    white-space: nowrap;
  }
</style>
</head>

<body>

<div class="dmarquee" id="dmarquee">
  <div class="dmarquee-dtrack" id="dtrack">
    
    <div class="dmarquee-item">🔥 1</div>
    <div class="dmarquee-item">🔥 2</div>
    <div class="dmarquee-item">🔥 3</div>
  </div>
</div>

<script>
(function() {

  const dmarquee = document.getElementById("dmarquee");
  const dtrack = document.getElementById("dtrack");

  // SPEED IN PIXELS/SECOND
  const SPEED = 60;

  // 1. DUPLICATE CONTENT until dtrack width > 2× container
  function fill() {
    const containerWidth = dmarquee.clientWidth;

    // Collect initial items
    const originals = Array.from(dtrack.children);
    if (originals.length === 0) return;

    let safety = 50;
    while (dtrack.scrollWidth < containerWidth * 2 && safety-- > 0) {
      originals.forEach(item => {
        dtrack.appendChild(item.cloneNode(true));
      });
    }
  }

  fill();

  // 2. EXACT width of first content cycle
  let groupWidth = 0;
  function measure() {
    // width of first cycle (original items only)
    groupWidth = 0;
    const children = Array.from(dtrack.children);
    for (let i = 0; i < children.length; i++) {
      // sum width of originals only
      if (i >= children.length / 2) break;
      groupWidth += children[i].offsetWidth;
    }
  }

  measure();

  let offset = 0;
  let lastTime = performance.now();

  function tick(now) {
    const dt = (now - lastTime) / 1000;
    lastTime = now;

    offset -= SPEED * dt;

    // Wrap mathematically — **never resets visually**
    if (offset <= -groupWidth) {
      offset += groupWidth;
    }

    // Apply transform
    dtrack.style.transform = `translateX(${offset}px)`;

    requestAnimationFrame(tick);
  }

  requestAnimationFrame(tick);

})();
</script>

</body>
</html>