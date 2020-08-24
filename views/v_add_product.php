<main class="page-add" >
  <h1 class="h h--1"><?= empty($product) ? 'Добавление товара' : 'Редактирование' ?></h1>
  <form class="custom-form" action="/ajax/products/add/" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $product['id'] ?? '' ?>">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name"
        value="<?= $product['name'] ?? '' ?>">
        <p class="custom-form__input-label custom-form__input-label--prod">
          Название товара
        </p>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price"
        value="<?= $product['price'] ?? '' ?>">
        <p class="custom-form__input-label custom-form__input-label--prod">
          Цена товара
        </p>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <div class="product-photo-block" >

        <ul class="add-list">
          <li class="add-list__item add-list__item--add">
            <input type="file" name="product-photo" id="product-photo" hidden="" value="">
            <label for="product-photo">
              <?= isset($product) ? 'Заменить' : 'Добавить' ?> фотографию
            </label>
          </li>
        </ul>

        <?php if (isset($product)) : ?>
        <div class="product-old-photo">
          <img src="<?= IMGS_STORAGE . $product['img'] ?>" alt="photo">
          <input type="hidden" name="old-product-photo" id="old-product-photo"
              value="<?= $product['img'] ?? '' ?>">
        </div>
        <?php endif; ?>
      </div>

    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>

          <?php foreach ($categories as $cat) : ?>
            <option value="<?= $cat['category_id'] ?>"
              <?= isset($product) && in_array($cat['title'], $product['category']) ? 'selected' : '' ?>>
              <?= $cat['title'] ?>
            </option>
          <?php endforeach; ?>

        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox"
        <?= isset($product) && $product['new'] == 1 ? 'checked' : '' ?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox"
        <?= isset($product) && $product['sale'] == 1 ? 'checked' : '' ?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group" style="color: red;">
      <p class="errors-product-add"></p>
    </fieldset>
    <input type="hidden" value="on" name="add">
    <button class="button" type="submit">
      <?= isset($product) ? 'Сохранить изменения' : 'Добавить товар' ?>
    </button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно
      <?= isset($product) ? ' отредактирован' : ' добавлен' ?></h2>
    </div>
  </section>
</main>