document.querySelectorAll('[data-ut="guide-nav"]').forEach(scope => {

  const items = scope.querySelectorAll(':scope a');

  const sections = Array.from(items).map(item =>
    document.querySelector(item.getAttribute('href'))
  );

  function onScroll() {

    const scrollPos = window.scrollY + 120;
    let activeIndex = 0;

    sections.forEach((section, index) => {
      if (section && scrollPos >= section.offsetTop) {
        activeIndex = index;
      }
    });

    items.forEach(i => i.classList.remove('active'));
    if (items[activeIndex]) {
      items[activeIndex].classList.add('active');
    }
  }

  window.addEventListener('scroll', onScroll);
  onScroll();

  items.forEach(item => {
    item.addEventListener('click', e => {

      e.preventDefault();

      const target = document.querySelector(item.getAttribute('href'));
      if (!target) return;

      target.scrollIntoView({
        behavior: 'smooth'
      });

    });
  });

});