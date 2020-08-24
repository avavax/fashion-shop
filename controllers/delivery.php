<?php

echo render('v_layout', [
    'title' => 'Доставка',
    'pageContent' => render('v_delivery'),
    'topmenu' => render('parts/v_topmenu'),
]);
