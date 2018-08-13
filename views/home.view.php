<?php require "partials/header.view.php" ?>

<div class="container">

    <nav class="breadcrumb section" aria-label="breadcrumbs">
        <ul>
            <li class="is-active"><a href="#" aria-current="page">Homepage</a></li>
        </ul>
    </nav>

    <div class="section">
        <a href="/create" class="button is-light is-medium">Add new recipe</a>
        <a href="/logout" class="button is-warning is-medium">Logout</a>
    </div>

    <?php foreach ($recipes as $key => $recipe) : ?>
    <div class="section">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <?= $recipe['title'] ?>
                </p>
            </header>
            <?php if ($recipe['image'] != "") : ?>
                <div class="card-content">
                    <img src="views/img/<?= $recipe['image'] ?>" alt="<?= $recipe['title'] ?> image">
                </div>
            <?php endif; ?>
            <div class="card-content columns">
                <div class="content column is-one-third">
                    <h5>Ingredients</h5>
                    <ul>
                    <?php for ($i = 0; $i < count($details); $i++) : ?>
                        <?php if ($recipe['id'] === $details[$i]['recipe_id']) : ?>
                            <li>
                                <?= $details[$i]['ingredient_count'] == 0 ? "" : $details[$i]['ingredient_count'] ?>
                                <?= $details[$i]['measurement_title'] ?>
                                <?= $details[$i]['ingredient_title'] ?>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>
                    </ul>
                    <h5>Time preparing</h5>
                    <p><?= $recipe['time_preparing'] / 60 ?> h.</p>
                </div>
                <div class="content column">
                    <article class="message is-warning">
                        <div class="message-header">
                            <p>Instructions</p>
                        </div>
                        <div class="message-body">
                            <?= $recipe['instructions'] ?>
                        </div>
                    </article>
                </div>
            </div>
            <footer class="card-footer">
                <a href="/edit/<?= $recipe['id'] ?>" class="card-footer-item">Edit</a>
                <a href="/delete/<?= $recipe['id'] ?>" class="card-footer-item">Delete</a>
            </footer>
        </div>
    </div>
    <?php endforeach; ?>

</div>
<?php require "partials/footer.view.php" ?>