<ul class="shop__paginator paginator">
<?php for ($i = 1; $i < (1 + $products['count'] / PRODUCTS_ON_PAGE); $i++) : ?>
    <li>
        <?php if ($products['currentPage'] == $i) : ?>
            <a class="paginator__item"><?= $i ?></a>
        <?php else : ?>
            <a class="paginator__item"
                href="<?= "/catalog/{$products['category']}/{$i}{$getParamsForPagination}" ?>">
                <?= $i ?>
            </a>
        <?php endif; ?>
    </li>
<?php endfor; ?>
</ul>