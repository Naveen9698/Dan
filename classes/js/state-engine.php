(() => {

  const ACTIVE_SELECTOR =
    '[class*="ac:"], .cac-parent';

  const SELECT_SELECTOR =
    '[class*="sl:"], .csl-parent';

  /* =========================
     ACTIVE
  ========================= */

  function getActiveCandidates(group) {
    return [...group.querySelectorAll(ACTIVE_SELECTOR)]
      .filter(el => el.closest('.ac-group') === group);
  }

  function setActive(target) {

    const group = target.closest('.ac-group');

    if (!group) return;

    const candidates =
      getActiveCandidates(group);

    if (target.classList.contains('active')) {

      if (!group.dataset.required) {
        target.classList.remove('active');
        return;
      }

    }

    candidates.forEach(el =>
      el.classList.remove('active')
    );

    target.classList.add('active');

    group.dispatchEvent(
      new CustomEvent('ac-change', {
        detail: {
          active: target
        }
      })
    );
  }

  document.addEventListener('click', e => {

    const target =
      e.target.closest(ACTIVE_SELECTOR);

    if (!target) return;

    const group =
      target.closest('.ac-group');

    if (!group) return;

    setActive(target);

  });

  /* =========================
     SELECT
  ========================= */

  function selectCount(group) {
    return group.querySelectorAll('.select').length;
  }

  function toggleSelect(target) {

    const group =
      target.closest('.sl-group');

    if (!group) return;

    const max =
      Number(group.dataset.max || Infinity);

    const min =
      Number(group.dataset.min || 0);

    const selected =
      target.classList.contains('select');

    const count =
      selectCount(group);

    if (!selected) {

      if (count >= max) return;

      target.classList.add('select');

    } else {

      if (count <= min) return;

      target.classList.remove('select');

    }

    group.dispatchEvent(
      new CustomEvent('sl-change', {
        detail: {
          count: selectCount(group)
        }
      })
    );
  }

  document.addEventListener('click', e => {

    const target =
      e.target.closest(SELECT_SELECTOR);

    if (!target) return;

    const group =
      target.closest('.sl-group');

    if (!group) return;

    toggleSelect(target);

  });

  /* =========================
     API
  ========================= */

window.StateEngine = {

  selectAll(group) {

    const max =
      Number(group.dataset.max || Infinity);

    const selectedCount =
      group.querySelectorAll('.select').length;

    const available =
      max - selectedCount;

    if (available <= 0) return;

    const candidates =
      [...group.querySelectorAll(SELECT_SELECTOR)]
        .filter(el =>
          !el.classList.contains('select')
        );

    candidates
      .slice(0, available)
      .forEach(el =>
        el.classList.add('select')
      );

    group.dispatchEvent(
      new CustomEvent('sl-change', {
        detail: {
          count:
            group.querySelectorAll('.select').length
        }
      })
    );

  },

  clearSelect(group) {

    const min =
      Number(group.dataset.min || 0);

    [...group.querySelectorAll('.select')]
      .slice(min)
      .forEach(el =>
        el.classList.remove('select')
      );

    group.dispatchEvent(
      new CustomEvent('sl-change', {
        detail: {
          count:
            group.querySelectorAll('.select').length
        }
      })
    );

  }

};

})();