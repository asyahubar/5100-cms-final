<?php require "partials/header.view.php" ?>

    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h2 class="title">
                    Sign in
                </h2>
            </div>
        </div>
    </section>
    <form action="/validate" method="POST" class="container">
        <div class="field">
            <p class="control has-icons-left has-icons-right">
                <input class="input" name="email" type="email" placeholder="Email">
                <span class="icon is-small is-left">
              <i class="fas fa-envelope"></i>
            </span>
                <span class="icon is-small is-right">
              <i class="fas fa-check"></i>
            </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <input class="input" name="password" type="password" placeholder="Password">
                <span class="icon is-small is-left">
              <i class="fas fa-lock"></i>
            </span>
            </p>
        </div>
        <div class="field">
            <p class="control">
                <button class="button is-warning">
                    Login
                </button>
            </p>
        </div>
    </form>

    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h4>
                    I do not have an account, let`s <a href="/register">create one</a>
                </h4>
            </div>
        </div>
    </section>

<?php require "partials/footer.view.php" ?>