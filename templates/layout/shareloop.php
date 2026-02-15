<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= $this->fetch('title') ?? 'ShareLoop - Knihy' ?></title>
    <meta property="og:title" content="<?= $this->fetch('title') ?? 'ShareLoop - Knihy' ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta property="twitter:card" content="summary_large_image" />

    <style data-tag="reset-style-sheet">
      html {  line-height: 1.15;}body {  margin: 0;}* {  box-sizing: border-box;  border-width: 0;  border-style: solid;  -webkit-font-smoothing: antialiased;}p,li,ul,pre,div,h1,h2,h3,h4,h5,h6,figure,blockquote,figcaption {  margin: 0;  padding: 0;}button {  background-color: transparent;}button,input,optgroup,select,textarea {  font-family: inherit;  font-size: 100%;  line-height: 1.15;  margin: 0;}button,select {  text-transform: none;}button,[type="button"],[type="reset"],[type="submit"] {  -webkit-appearance: button;  color: inherit;}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner {  border-style: none;  padding: 0;}button:-moz-focus,[type="button"]:-moz-focus,[type="reset"]:-moz-focus,[type="submit"]:-moz-focus {  outline: 1px dotted ButtonText;}a {  color: inherit;  text-decoration: inherit;}pre {  white-space: normal;}input {  padding: 2px 4px;}img {  display: block;}details {  display: block;  margin: 0;  padding: 0;}summary::-webkit-details-marker {  display: none;}[data-thq="accordion"] [data-thq="accordion-content"] {  max-height: 0;  overflow: hidden;  transition: max-height 0.3s ease-in-out;  padding: 0;}[data-thq="accordion"] details[data-thq="accordion-trigger"][open] + [data-thq="accordion-content"] {  max-height: 1000vh;}details[data-thq="accordion-trigger"][open] summary [data-thq="accordion-icon"] {  transform: rotate(180deg);}html { scroll-behavior: smooth  }
    </style>

    <style data-tag="default-style-sheet">
      html {
        font-family: "Open Sans";
        font-size: 1rem;
      }

      body {
        font-weight: 400;
        font-style:normal;
        text-decoration: undefined;
        text-transform: undefined;
        letter-spacing: 0.03em;
        line-height: 1.65;
        color: var(--color-on-surface);
        background: var(--color-surface);
        fill: var(--color-on-surface);
      }
    </style>

    <link
      rel="stylesheet"
      href="https://unpkg.com/animate.css@4.1.1/animate.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=STIX+Two+Text:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
      data-tag="font"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/@teleporthq/teleport-custom-scripts/dist/style.css"
    />

    <link rel="stylesheet" href="/css/shareloop.css" />
    <?= $this->fetch('css') ?>
  </head>

  <body>
    <div>
      <div class="shareloop-container">
        <!-- Navigation -->
        <nav class="shareloop-navigation">
          <div class="nav-container">
            <a href="/" class="nav-logo">
              <div class="nav-logo-icon">
                <svg width="24" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24">
                  <path
                    d="M12 7v14m-9-3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4a4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3a3 3 0 0 0-3-3z"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></path>
                </svg>
              </div>
              <span class="nav-brand">ShareLoop</span>
            </a>
            <div class="nav-menu">
              <a href="/" class="nav-link">Domov</a>
              <a href="/shareloop-books" class="nav-link">Knižnica</a>
              <a href="#" class="nav-link">Pôžičky</a>
              <a href="#" class="nav-link">Trhom</a>
            </div>
          </div>
        </nav>

        <!-- Main Content -->
        <main class="shareloop-main">
          <div class="shareloop-content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
          </div>
        </main>

        <!-- Footer -->
        <footer class="shareloop-footer">
          <div class="footer-content">
            <div class="footer-section">
              <h3 class="footer-title">ShareLoop</h3>
              <p class="footer-description">
                Katalogujte svoje knihy, hry a puzzle jednoducho a zdieľajte ich s komunitou.
              </p>
            </div>
            <div class="footer-section">
              <h4 class="footer-subtitle">Navigácia</h4>
              <ul class="footer-links">
                <li><a href="/">Domov</a></li>
                <li><a href="/shareloop-books">Knižnica</a></li>
                <li><a href="#">O nás</a></li>
                <li><a href="#">Kontakt</a></li>
              </ul>
            </div>
            <div class="footer-section">
              <h4 class="footer-subtitle">Právne</h4>
              <ul class="footer-links">
                <li><a href="#">Ochrana osobných údajov</a></li>
                <li><a href="#">Podmienky používania</a></li>
                <li><a href="#">Nastavenia cookies</a></li>
              </ul>
            </div>
          </div>
          <div class="footer-bottom">
            <p>&copy; 2026 ShareLoop. Všetky práva vyhradené.</p>
          </div>
        </footer>
      </div>
    </div>

    <?= $this->fetch('script') ?>
  </body>
</html>
