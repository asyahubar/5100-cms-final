<?php require "partials/header.view.php" ?>

<section class="hero">
    <div class="hero-body">
        <div class="container">
            <h2 class="title" id="title">
                Sign up
            </h2>
        </div>
    </div>
</section>
<div class="container">
    <form action="/createuser" method="POST" class="container">
        <div class="field">
            <p class="control has-icons-left">
                <input class="input" id="nickname" name="nickname" type="text" placeholder="Nickname">
                <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left has-icons-right">
                <input class="input" id="email" name="email" type="email" placeholder="Email">
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
                <input class="input" id="password" name="password" type="password" placeholder="Password">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control">
                <button class="button is-warning">
                    Register
                </button>
            </p>
        </div>
    </form>
</div>

<section class="hero">
    <div class="hero-body">
        <div class="container">
            <h4>
                I already have an account, <a href="/login">log me in</a>!
            </h4>
        </div>
    </div>
</section>

<?php require "partials/footer.view.php" ?>

