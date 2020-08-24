<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <ul class="page-order__list">

    <?php foreach ($orders as $order) : ?>
    <li class="order-item page-order__item">
      <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--id">
          <span class="order-item__title">Номер заказа</span>
          <span class="order-item__info order-item__info--id"><?= $order['order_id'] ?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Сумма заказа</span>
          <?= $order['fullPrice'] ?> руб.
        </div>
        <button class="order-item__toggle"></button>
      </div>
      <div class="order-item__wrapper">
        <div class="order-item__group">
          <span class="order-item__title">Товар</span>
          <span class="order-item__info">id <?= $order['product_id'] ?> | <?= $order['title'] ?></span>
        </div>
      </div>

      <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--margin">
          <span class="order-item__title">Заказчик</span>
          <span class="order-item__info"><?= $order['fullname'] ?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Номер телефона</span>
          <span class="order-item__info"><?= $order['phone'] ?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Способ доставки</span>
          <span class="order-item__info">
            <?= $order['delivery'] == 'dev-no' ? 'Самовывоз' : 'Курьером' ?>
            </span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Способ оплаты</span>
          <span class="order-item__info">
            <?= $order['delivery'] == 'cash' ? 'Наличными' : 'Банковской картой' ?></span>
        </div>
        <div class="order-item__group order-item__group--status">
          <span class="order-item__title">Статус заказа</span>
          <span class="order-item__info order-item__info--<?= $order['status'] == 1 ? 'yes' : 'no' ?>">
            <?= $order['status'] == 1 ? 'Выполнено' : 'Не выполнено' ?></span>
          <button class="order-item__btn" data-id=<?= $order['order_id'] ?>>Изменить</button>
        </div>
      </div>

        <?php if (isset($order['address'])) : ?>
          <div class="order-item__wrapper">
            <div class="order-item__group">
              <span class="order-item__title">Адрес доставки</span>
              <span class="order-item__info"><?= $order['address'] ?></span>
            </div>
          </div>
        <?php endif; ?>

        <?php if (isset($order['comment'])) : ?>
          <div class="order-item__wrapper">
            <div class="order-item__group">
              <span class="order-item__title">Комментарий к заказу</span>
              <span class="order-item__info"><?= $order['comment'] ?></span>
            </div>
          </div>
        <?php endif; ?>

    </li>
    <?php endforeach; ?>

  </ul>
</main>