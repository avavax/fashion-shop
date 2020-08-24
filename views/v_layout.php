<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>

  <meta name="description" content="Fashion - интернет-магазин">
  <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">

  <meta name="theme-color" content="#393939">

  <link rel="preload" href="/public/img/intro/coats-2018.jpg" as="image">
  <link rel="preload" href="/public/fonts/opensans-400-normal.woff2" as="font">
  <link rel="preload" href="/public/fonts/roboto-400-normal.woff2" as="font">
  <link rel="preload" href="/public/fonts/roboto-700-normal.woff2" as="font">

  <link rel="icon" href="/public/img/favicon.png">
  <link rel="stylesheet" href="/public/css/style.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/public/js/scripts.js" defer=""></script>
</head>
<body>
<header class="page-header">
  <a class="page-header__logo" href="/">
    <img src="/public/img/logo.svg" alt="Fashion">
  </a>
  <nav class="page-header__menu">
    <ul class="main-menu main-menu--header">

        <?= $topmenu ?>

    </ul>
  </nav>
</header>

<?= $pageContent ?>

<footer class="page-footer">
  <div class="container">
    <a class="page-footer__logo" href="#">
      <img src="/public/img/logo--footer.svg" alt="Fashion">
    </a>
    <nav class="page-footer__menu">
      <ul class="main-menu main-menu--footer">
        <li>
          <a class="main-menu__item" href="/">Главная</a>
        </li>
        <li>
          <a class="main-menu__item" href="/?new=on">Новинки</a>
        </li>
        <li>
          <a class="main-menu__item" href="/?sale=on">Sale</a>
        </li>
        <li>
          <a class="main-menu__item" href="/delivery/">Доставка</a>
        </li>
      </ul>
    </nav>
    <address class="page-footer__copyright">
      © Все права защищены
    </address>
  </div>
</footer>
</body>
</html>