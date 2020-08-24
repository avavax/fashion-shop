<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <form class="custom-form" action="/admin/" method="post">
    <input type="email" class="custom-form__input" required="" name="email"
        value="<?= $email ?>">
    <input type="password" class="custom-form__input" required="" name="password"
        value="<?= $password ?>">
    <button class="button" type="submit" name="auth" value="on">Войти в личный кабинет</button>
  </form>
  <h2 style="color: red;"
    <?= isset($authError) ? '' : 'hidden' ?>>
    Неверный логин или пароль</h2>
</main>