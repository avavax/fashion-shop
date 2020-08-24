'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const labelActivate = (form) => {

  const inputs = form.querySelectorAll('input');

  inputs.forEach(item => {
    const label = item.nextElementSibling;
    if (label) {
      label.hidden = false;
    }
  })
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const deliveryReset = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  fields.forEach(inp => {
    if (inp.required === true) {
      inp.required = false;
    }
  });

  deliveryYes.hidden = true;
  deliveryNo.hidden = false;

}

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const inputProductId = document.querySelector('.input-product-id');

const shopList = document.querySelector('.shop__list');
if (shopList) {

  const sortSelect = document.querySelector('select[name="sort"]');
  const sortInput = document.querySelector('input[name="sort"]');
  sortSelect.addEventListener('change', evt => {
    sortInput.value = evt.target.value;
  })

  const orderSelect = document.querySelector('select[name="order"]');
  const orderInput = document.querySelector('input[name="order"]');
  orderSelect.addEventListener('change', evt => {
    orderInput.value = evt.target.value;
  })

  const popupEnd = document.querySelector('.shop-page__popup-end');
  const buttonEnd = popupEnd.querySelector('.continue-order');

  buttonEnd.addEventListener('click', () => {
    popupEnd.classList.add('fade-reverse');

    setTimeout(() => {
      popupEnd.classList.remove('fade-reverse');
      toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));
    }, 1000);
  });

  //const shopOrder = document.querySelector('.shop-page__order');
  toggleDelivery(document.querySelector('.shop-page__order'));

  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');

      labelActivate(form);
      labelHidden(form);

      if (prod[0]) {
        inputProductId.value = prod[0].dataset.id;
      }

      const buttonOrder = shopOrder.querySelector('.send-order');

      const sendOrder = (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        /** Валидация на стороне клиента */
        inputs.forEach(inp => {

          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {

          evt.preventDefault();
          const formData = new FormData(form);

          fetch('/ajax/order/', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {

            if (data.result) {

              /* Ветка при успешном оформлении заказа - начало  */

              buttonOrder.removeEventListener('click', sendOrder);

              toggleHidden(shopOrder, popupEnd);

              popupEnd.classList.add('fade');

              setTimeout(() => popupEnd.classList.remove('fade'), 1000);

              window.scroll(0, 0);

              form.reset();
              deliveryReset(shopOrder);

              /* Ветка при успешном оформлении заказа - окончание */


            } else {

              /* Ветка при ошибках оформления заказа - начало  */

              if (Object.keys(data.errors).length === 0) {
                const serverErrorMsg = document.querySelector('.error-add-message');
                serverErrorMsg.textContent = 'Заказ сделать не удалось. Попробуйте позже';
              } else {
                inputs.forEach(inp => {
                    if (inp.classList.contains('custom-form__input--error')) {
                      inp.classList.remove('custom-form__input--error');
                    }
                });

                for (let error in data.errors) {
                  const wrongInput = shopOrder.querySelector('[name = ' + error + ']');
                  wrongInput.classList.add('custom-form__input--error');
                };
              }
              /* Ветка при ошибках оформления заказа - конец  */

            }

          })

        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      };

      buttonOrder.addEventListener('click', sendOrder);

    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {


      /** Отправка на сервер ajax-запроса на изменение статуса заказа */

      fetch('/ajax/order/?change_status=on&id=' + evt.target.dataset.id)
      .then(response => response.json())
      .then(data => {
        if (data.result) {

          const status = evt.target.previousElementSibling;

          if (data.status === 1) {
            status.textContent = 'Выполнено';
            status.classList.remove('order-item__info--no');
            status.classList.add('order-item__info--yes');
          } else {
            status.textContent = 'Не выполнено';
            status.classList.remove('order-item__info--yes');
            status.classList.add('order-item__info--no');
          }
        }
      });

      /** Отправка на сервер ajax-запроса на изменение статуса заказа */

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');

  checkList(addList, addButton);

  const reader = new FileReader();

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

  const button = document.querySelector('.button');
  const popupEnd = document.querySelector('.page-add__popup-end');

  button.addEventListener('click', (evt) => {

    evt.preventDefault();

    // Отправка ajax-запроса добавление / изменения товара
    const errorsProductAdd = document.querySelector('.errors-product-add');
    errorsProductAdd.innerHTML = '';

    const formDataProduct = new FormData(form);

    fetch('/ajax/products/add/', {
        method: 'POST',
        body: formDataProduct
    })
    .then(response => response.json())
    .then(data => {

      if (data.result) {

        form.hidden = true;
        popupEnd.hidden = false;

      } else {

        let errors = '';
        if (data.errors) {
          errors += data.errors.reduce((sum, current) => sum + '<br>' + current, '');
        }

        errorsProductAdd.innerHTML = errors

      }
    })

  })

}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {

      // Удаление товара ajax-запрос

      fetch('/ajax/products/delete/?id=' + target.dataset.id)
      .then(response => response.json())
      .then(data => {

        if (data.result) {
          productsList.removeChild(target.parentElement);
        } else {
          const delError = "<p class='product-del-error'>" + data.error + "</p>";
          target.insertAdjacentHTML('afterEnd', delError);
        }
      })
    }

  });

}

// jquery range maxmin
if (document.querySelector('.shop-page')) {

  const minStart = + $('.min-price').attr('data-price');
  const maxStart = + $('.max-price').attr('data-price');

  const minInput = + $('.min-price-input').val();
  const maxInput = + $('.max-price-input').val();

  $('.range__line').slider({

    min: minStart,
    max: maxStart,
    values: [minInput, maxInput],
    range: true,
    stop: function(event, ui) {

      let minValue = $('.range__line').slider('values', 0);
      let maxValue = $('.range__line').slider('values', 1);

      $('.min-price').text(minValue + ' руб.');
      $('.max-price').text(maxValue + ' руб.');
      $('.min-price-input').val(minValue);
      $('.max-price-input').val(maxValue);

    },
    slide: function(event, ui) {

      let minValue = $('.range__line').slider('values', 0);
      let maxValue = $('.range__line').slider('values', 1);

      $('.min-price').text(minValue + ' руб.');
      $('.max-price').text(maxValue + ' руб.');
      $('.min-price-input').val(minValue);
      $('.max-price-input').val(maxValue);

    },
  });
}

