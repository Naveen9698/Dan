  <style>
    /* ---------- Demo visuals only ---------- */
    .flex_system .flex-ref {
      font-family: system-ui, sans-serif;
      background: #fafafa;
      padding: 28px;
      border: 1px solid #e5e7eb;
      border-radius: 20px;
      max-width: 100%;
      gap: 20px;
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }

    .flex_system .ref-title {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 14px;
    }

    .flex_system .ref-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 10px;
      text-align: -webkit-center;
    }

    .flex_system .ref-grid-5 {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
      text-align: -webkit-center;
    }

    .flex_system .ref-box {
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      padding: 14px;
    }

    .flex_system .ref-label {
      margin-top: 10px;
      font-size: 12px;
      color: #6b7280;
      text-align: center;
    }

    .flex_system .ref-items {
      gap: 10px;
      height: 200px;
      width: 200px;
    }

    .flex_system .item {
      background: #ef4444;
      border-radius: 6px;
      width: 20px;
    }

    .flex_system .item.small {
      height: 13px;
    }

    .flex_system .item.mid {
      height: 25px;
    }

    .flex_system .item.tall {
      height: 50px;
    }

    .flex_system .item-y {
      background: #ef4444;
      border-radius: 6px;
      height: 20px;
    }

    .flex_system .item-y.small {
      width: 13px;
    }

    .flex_system .item-y.mid {
      width: 25px;
    }

    .flex_system .item-y.tall {
      width: 50px;
    }

    .flex_system .text-item {
      font-family: system-ui, sans-serif;
      color: #ef4444;
      padding: 4px 6px;
      border-radius: 6px;
      font-weight: 600;
    }

    .flex_system .text-item.small {
      font-size: 8px;
    }

    .flex_system .text-item.mid {
      font-size: 14px;
    }

    .flex_system .text-item.tall {
      font-size: 30px;
    }
  </style>

  <div class="flex-ref">

    <div class="ref-section">
      <div class="ref-title">Flex Direction</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box flex-x ref-items">
            <div class="item mid"></div>
            <div class="item tall"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">flex-x</div>
        </div>

        <div>
          <div class="ref-box flex-y ref-items">
            <div class="item-y mid"></div>
            <div class="item-y tall"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">flex-y</div>
        </div>

      </div>
    </div>
  </div>

  <div class="flex-ref">

    <div class="ref-section">

      <div class="ref-title">Align Items flex-x</div>

      <div class="ref-grid-5">

        <div>
          <div class="ref-box flex-x f-left ref-items">
            <div class="item tall"></div>
            <div class="item mid"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">f-left</div>
        </div>

        <div>
          <div class="ref-box flex-x f-center ref-items">
            <div class="item tall"></div>
            <div class="item mid"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">f-center</div>
        </div>

        <div>
          <div class="ref-box flex-x f-right ref-items">
            <div class="item tall"></div>
            <div class="item mid"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">f-right</div>
        </div>

        <div>
          <div class="ref-box flex-x f-stretch ref-items">
            <div class="item"></div>
            <div class="item"></div>
            <div class="item"></div>
          </div>
          <div class="ref-label">f-stretch</div>
        </div>

        <div>
          <div class="ref-box flex-x f-baseline ref-items">
            <span class="text-item tall">Aa</span>
            <span class="text-item mid">Aa</span>
            <span class="text-item small">Aa</span>
          </div>
          <div class="ref-label">f-baseline</div>
        </div>
      </div>
    </div>

    <div class="ref-section">

      <div class="ref-title">Align Items flex-y</div>
      <div class="ref-grid-5">

        <div>
          <div class="ref-box flex-y f-left ref-items">
            <div class="item-y tall"></div>
            <div class="item-y mid"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">f-left</div>
        </div>

        <div>
          <div class="ref-box flex-y f-center ref-items">
            <div class="item-y tall"></div>
            <div class="item-y mid"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">f-center</div>
        </div>

        <div>
          <div class="ref-box flex-y f-right ref-items">
            <div class="item-y tall"></div>
            <div class="item-y mid"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">f-right</div>
        </div>

        <div>
          <div class="ref-box flex-y f-stretch ref-items">
            <div class="item-y"></div>
            <div class="item-y"></div>
            <div class="item-y"></div>
          </div>
          <div class="ref-label">f-stretch</div>
        </div>

        <div>
          <div class="ref-box flex-y f-baseline ref-items">
            <span class="text-item tall">Aa</span>
            <span class="text-item mid">Aa</span>
            <span class="text-item small">Aa</span>
          </div>
          <div class="ref-label">f-baseline</div>
        </div>

      </div>

    </div>
  </div>

  <div class="flex-ref">

    <div class="ref-section">

      <div class="ref-title">Justiflex-y Content flex-x</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box flex-x f-top ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-top</div>
        </div>

        <div>
          <div class="ref-box flex-x f-middle ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-middle</div>
        </div>

        <div>
          <div class="ref-box flex-x f-bottom ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-bottom</div>
        </div>

        <div>
          <div class="ref-box flex-x f-spread ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-spread</div>
        </div>

        <div>
          <div class="ref-box flex-x f-around ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-around</div>
        </div>

        <div>
          <div class="ref-box flex-x f-even ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-even</div>
        </div>

      </div>
    </div>
    <div class="ref-section">

      <div class="ref-title">Justiflex-y Content flex-y</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box flex-y f-top ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-top</div>
        </div>

        <div>
          <div class="ref-box flex-y f-middle ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-middle</div>
        </div>

        <div>
          <div class="ref-box flex-y f-bottom ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-bottom</div>
        </div>

        <div>
          <div class="ref-box flex-y f-spread ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-spread</div>
        </div>

        <div>
          <div class="ref-box flex-y f-around ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-around</div>
        </div>

        <div>
          <div class="ref-box flex-y f-even ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-even</div>
        </div>

      </div>

    </div>
  </div>

  <div class="flex-ref">

    <div class="ref-section">
      <div class="ref-title">Align Content flex-x</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box flex-x f-lines-top f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-top <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-x f-lines-middle f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-middle <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-x f-lines-bottom f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-bottom <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-x f-lines-spread f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-spread <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-x f-lines-around f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-around <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-x f-lines-even f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-even <br> f-wrap</div>
        </div>

      </div>
    </div>

    <div class="ref-section">
      <div class="ref-title">Align Content flex-y</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box flex-y f-lines-top f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lin f-wrapes-top</div>
        </div>

        <div>
          <div class="ref-box flex-y f-lines-middle f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-middle <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-y f-lines-bottom f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-bottom <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-y f-lines-spread f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-spread <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-y f-lines-around f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-around <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box flex-y f-lines-even f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-even <br> f-wrap</div>
        </div>

      </div>
    </div>
  </div>
