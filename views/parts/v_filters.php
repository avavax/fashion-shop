<section class="shop__filter filter">
  <form method="GET" action="<?= "/catalog/{$currentCategorySlug}/" ?>">
  <input type="hidden" name="sort" class="order-input"
    value="<?= $request['filters']['sort'] ?? 'title' ?>">
  <input type="hidden" name="order" class="order-input"
    value="<?= isset($request['filters']['order']) && $request['filters']['order'] == SORT_DESC ? 'desc' : 'asc' ?>">
  <div class="filter__wrapper">
    <b class="filter__title">Категории</b>
    <ul class="filter__list">
      <li>
        <a class="filter__list-item
          <?= $currentCategorySlug == 'all' ? 'active' : '' ?>"
          href="/catalog/all/">Все</a>
      </li>

      <?php foreach ($categories as $cat) : ?>
        <li>
          <a class="filter__list-item
            <?= $currentCategorySlug == $cat['slug'] ? 'active' : '' ?>"
            href="/catalog/<?= $cat['slug'] ?>/">
            <?= $cat['title'] ?>
          </a>
        </li>
      <?php endforeach; ?>

    </ul>
  </div>
    <div class="filter__wrapper">
      <b class="filter__title">Фильтры</b>
      <div class="filter__range range">
        <span class="range__info">Цена</span>
        <div class="range__line" aria-label="Range Line"></div>
        <div class="range__res">
          <span class="range__res-item min-price" data-price="<?= $products['minPrice'] ?>">
            <?= $request['filters']['minPrice'] ?? $products['minPrice'] ?> руб.
          </span>
          <span class="range__res-item max-price" data-price="<?= $products['maxPrice'] ?>">
            <?= $request['filters']['maxPrice'] ?? $products['maxPrice'] ?> руб.
          </span>
        </div>
        <input type="hidden" name="min_price" class="min-price-input"
          value="<?= $request['filters']['minPrice'] ?? $products['minPrice'] ?>">
        <input type="hidden" name="max_price" class="max-price-input"
          value="<?= $request['filters']['maxPrice'] ?? $products['maxPrice'] ?>" >
      </div>
    </div>

    <fieldset class="custom-form__group">
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox"
        <?= isset($request['filters']) && $request['filters']['new'] ? 'checked' : '' ?>>
      <label for="new" class="custom-form__checkbox-label custom-form__info" style="display: block;">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox"
        <?= isset($request['filters']) && $request['filters']['sale'] ? 'checked' : '' ?>>
      <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
    </fieldset>
    <button class="button" type="submit" style="width: 100%" name="filters" value="change">Применить</button>
  </form>
</section>