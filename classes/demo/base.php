<h3 class="d-h3 demo">Universal Class Order (Mental Model)</h3>
<p class="fz-14 clr-g5 lh-16 ml-md">
  🟢 <b>Correct</b> · 🟡 <b>Caution</b> · 🔴 <b>Wrong</b>
<p class="fz-14 clr-g5 lh-16 ml-md">
  🟡 Demos are for <b>concept understanding</b>, not exact implementation.<br>
  🟡 Values and layout may be simplified for clarity.<br>
  🔴 Always adapt code to real use cases.
<h3 class="d-h3 demo">Interactive State (Mental Model)</h3>
<p class="fz-14 clr-g5 lh-16 ml-md">
  🟢 <b>s-</b> represents a <b>state</b> — meaning the style applies only when something happens (hover, focus, active).<br>
  🟢 Examples: <b>hs-</b> = hover state, <b>fs-</b> = focus state, <b>as-</b> = active state.<br>
  🟢 Child variants: <b>chs-, cfs-, cas-</b> apply the state from a parent to its children.<br>
  🟢 These are <b>interactive styles</b> — they activate only during user interaction.<br>
  🟡 Without <b>s</b>, utilities are applied <b>always (default/static state)</b>.<br>
  🔴 Do not use state prefixes for normal styling — use base utilities for consistent layout and design.
<h3 class="d-h3 demo">Framework Capability Matrix</h3>
<section class="stack-y-sm">
  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Provides a high-level overview of every system in the framework.<br>
    🟢 Use this table to quickly determine which capabilities a system supports.<br>
    🟢 Sticky header and sticky first column make large matrices easier to navigate.<br>
    🟢 In table _ = not applicable.<br>
    🟡 Detailed behavior, scales, and examples remain documented within each system page.<br>
    🔴 Capability support does not imply identical implementation patterns across systems.
  </p>
  <div class="of-auto bsw-sm bg-white">
    <style>
      :root {
        --table-sort: "↕";
        --table-asc: "↑";
        --table-des: "↓";
        --table-icon-op: .3;
      }

      .table-sort {
        --table-icon: var(--table-sort);
        position: relative;
        cursor: pointer;
        user-select: none;
        white-space: nowrap;
        padding-right: 1.5rem;
      }

      .table-asc {
        --table-icon: var(--table-asc);
        --table-icon-op: 1;
      }

      .table-des {
        --table-icon: var(--table-des);
        --table-icon-op: 1;
      }

      .table-sort::after {
        content: var(--table-icon);
        opacity: var(--table-icon-op);
        position: absolute;
        right: .5rem;
        top: 50%;
        transform: translateY(-50%);
      }
    </style>
    <table class="w-100p">
      <thead>
        <tr class="txt-left">
          <th class="table-sort table-asc pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Family
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Property
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Prefix
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Example
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Scale
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Modifiers
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Helpers
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            State
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Breakpoint
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Utilities
          </th>
          <th class="table-sort pn-sticky t-0 z-2 bg-g2 pa-xs dbsw-xs">
            Variable
          </th>
        </tr>
      </thead>
      <tbody class="txt-top">

        <tr class="clr-g7">
          <td class="pn-sticky fw-600 l-0 z-1 bg-g2 pa-xs dbsw-xs">
            Aspect Ratio
          </td>
          <td class="pa-xs ba-xxs">
            aspect-ratio
          </td>
          <td class="pa-xs ba-xxs">
            ar-*
          </td>
          <td class="pa-xs ba-xxs">
            ar-1x1
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            ar-auto
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>ar-1x1 
ar-2x3 
ar-3x2 
ar-4x3 
ar-9x16
ar-16x9
ar-21x9</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
        </tr>

        <tr class="clr-g7">
          <td class="pn-sticky fw-600 l-0 z-1 bg-g2 pa-xs dbsw-xs">
            Border
          </td>
          <td class="pa-xs ba-xxs">
            border-width
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>ba-*
bt-*
br-*
bb-*
bl-*</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>ba-sm</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>xxs - xxl</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>ba-0, ba-xxs - ba-xxl
bt-0, bt-xxs - bt-xxl
br-0, br-xxs - br-xxl
bb-0, bb-xxs - bb-xxl
bl-0, bl-xxs - bl-xxl</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>--ba-xxs
--ba-xs
--ba-sm
--ba-md
--ba-lg
--ba-xl
--ba-xxl</code></pre>
          </td>
        </tr>

        <tr class="clr-g7">
          <td class="pn-sticky fw-600 l-0 z-1 bg-g2 pa-xs dbsw-xs">
            Border
          </td>
          <td class="pa-xs ba-xxs">
            border-style
          </td>
          <td class="pa-xs ba-xxs">
            bstyle-*
          </td>
          <td class="pa-xs ba-xxs">
            bstyle-dotted
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>bstyle-solid
bstyle-dashed
bstyle-dotted
bstyle-double
bstyle-none</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
        </tr>

        <tr>
          <td class="pn-sticky fw-600 l-0 z-1 bg-g2 pa-xs dbsw-xs">
            Color
          </td>
          <td class="pa-xs ba-xxs">
            color
          </td>
          <td class="pa-xs ba-xxs">
            clr-*
          </td>
          <td class="pa-xs ba-xxs">
            clr-main
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>hs-clr-*
chs-clr-*</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>clr-main
clr-main-h
clr-sub
clr-sub-h
clr-acnt
clr-acnt-h
clr-black
clr-g9
clr-g8
clr-g7
clr-g6
clr-g5
clr-g4
clr-g3
clr-g2
clr-g1
clr-white
clr-0</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>--color-main
--color-main-h
--color-sub
--color-sub-h
--color-acnt
--color-acnt-h
--color-black
--color-g9
--color-g8
--color-g7
--color-g6
--color-g5
--color-g4
--color-g3
--color-g2
--color-g1
--color-white
--color-0</code></pre>
          </td>
        </tr>

        <tr class="clr-g7">
          <td class="pn-sticky fw-600 l-0 z-1 bg-g2 pa-xs dbsw-xs">
            Height
          </td>
          <td class="pa-xs ba-xxs">
            height
          </td>
          <td class="pa-xs ba-xxs">
            h-*
          </td>
          <td class="pa-xs ba-xxs">
            h-100p
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>0 - 1400
0 - 100</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>h-add-1px
h-add-1vh
h-add-1p
h-add-1min
h-add-1max</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>h-auto
h-fit</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>h-0px  - h-1400px
h-0vh  - h-100vh
h-0p   - h-100p
h-0min - h-1400min
h-0max - h-1400max</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>--h-a-px
--h-a-vh
--h-a-p
--h-a-min
--h-a-max</code></pre>
          </td>
        </tr>

        <tr class="clr-g7">
          <td class="pn-sticky fw-600 l-0 z-1 bg-g2 pa-xs dbsw-xs">
            Width
          </td>
          <td class="pa-xs ba-xxs">
            width
          </td>
          <td class="pa-xs ba-xxs">
            w-*
          </td>
          <td class="pa-xs ba-xxs">
            w-100p
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>0 - 1400
0 - 100</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>w-add-1px
w-add-1vw
w-add-1p
w-add-1min
w-add-1max</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>w-auto
w-fit</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>_</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>w-0px  - w-1400px
w-0vw  - w-100vw
w-0p   - w-100p
w-0min - w-1400min
w-0max - w-1400max</code></pre>
          </td>
          <td class="pa-xs ba-xxs">
            <pre><code>--w-a-px
--w-a-vw
--w-a-p
--w-a-min
--w-a-max</code></pre>
          </td>
        </tr>
      </tbody>
    </table>






















    <script>
      (() => {
        const compareOptions = {
          numeric: true,
          sensitivity: "base"

        };
        [...new Set(
          [...document.querySelectorAll(".table-sort")]
          .map(th => th.closest("table"))
          .filter(Boolean)
        )].forEach(table => {
          const headers = [...table.querySelectorAll("thead .table-sort")];
          const tbody =
            table.querySelector("tbody");
          if (!headers.length || !tbody) return;
          headers.forEach(th => {
            th._col = [...th.parentElement.children]
              .indexOf(th);

          });
          const sortTable = (col, asc) => {
            const rows = [...tbody.rows];
            rows.sort((a, b) => {
              const av =
                a.children[col]
                ?.textContent
                .trim() || "";
              const bv =
                b.children[col]
                ?.textContent
                .trim() || "";
              return asc ?
                av.localeCompare(
                  bv,
                  undefined,
                  compareOptions

                ) :
                bv.localeCompare(
                  av,
                  undefined,
                  compareOptions

                );

            });
            tbody.append(...rows);
          };
          headers.forEach(th => {
            th.addEventListener("click", () => {
              const asc = !th.classList.contains(
                "table-asc"

              );
              headers.forEach(h =>
                h.classList.remove(
                  "table-asc",
                  "table-des"

                )
              );
              th.classList.add(
                asc ?
                "table-asc" :
                "table-des"

              );
              sortTable(
                th._col,
                asc

              );

            });
          });
          let active =
            table.querySelector(
              "thead .table-asc, thead .table-des"

            );
          if (!active) {
            active =
              headers[0];
            active.classList.add(
              "table-asc"

            );

          }
          sortTable(
            active._col,
            !active.classList.contains(
              "table-des"

            )
          );
        });
      })();
    </script>


  </div>
</section>