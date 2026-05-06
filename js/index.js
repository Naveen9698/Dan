const navItems = document.querySelectorAll('.d-nav-item');
const sections = Array.from(navItems).map(item =>
  document.getElementById(item.dataset.target)
);

function onScroll() {
  const scrollPos = window.scrollY + 120;

  let activeIndex = sections.findIndex((section, index) => {
    const current = section.offsetTop;
    const next = sections[index + 1]?.offsetTop ?? Infinity;
    return scrollPos >= current && scrollPos < next;
  });

  if (activeIndex === -1) activeIndex = 0;

  navItems.forEach(item => item.classList.remove('d-active'));
  navItems[activeIndex].classList.add('d-active');
}

window.addEventListener('scroll', onScroll);
onScroll(); // run once on load

navItems.forEach(item => {
  item.addEventListener('click', () => {
    document
      .getElementById(item.dataset.target)
      .scrollIntoView({ behavior: 'smooth' });
  });
});