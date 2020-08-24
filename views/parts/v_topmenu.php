<li>
  <a class="main-menu__item <?= $_SERVER['REQUEST_URI'] == "/" ? 'active' : '' ?>"
   href="/">Главная</a>
</li>
<li>
  <a class="main-menu__item <?= $_SERVER['REQUEST_URI'] == "/?new=on" ? 'active' : '' ?>"
   href="/?new=on">Новинки</a>
</li>
<li>
  <a class="main-menu__item <?= $_SERVER['REQUEST_URI'] == "/?sale=on" ? 'active' : '' ?>"
   href="/?sale=on">Sale</a>
</li>
<li>
  <a class="main-menu__item <?= $_SERVER['REQUEST_URI'] == "/delivery/" ? 'active' : '' ?>"
   href="/delivery/">Доставка</a>
</li>