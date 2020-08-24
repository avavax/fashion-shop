<li>
  <a class="main-menu__item" href="/">Главная</a>
</li>
<?php if ($userRole == 'admin') : ?>
<li>
  <a class="main-menu__item <?= $currentPage == 'products' ? 'active' : '' ?> "
   href="/admin/products/">Товары</a>
</li>
<?php endif ?>
<li>
  <a class="main-menu__item <?= $currentPage == 'orders' ? 'active' : '' ?> "
    href="/admin/">Заказы</a>
</li>
<li>
  <a class="main-menu__item" href="/admin/?logout=yes">Выйти</a>
</li>