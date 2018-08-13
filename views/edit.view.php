<?php require "partials/header.view.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

    <div class="container">

        <nav class="breadcrumb section" aria-label="breadcrumbs">
            <ul>
                <li><a href="/">Homepage</a></li>
                <li class="is-active"><a href="#" aria-current="page" id="title">Edit</a></li>
            </ul>
        </nav>

        <div class="section">
            <form action="/update/<?= $recipe['id'] ?>" method="POST" enctype="multipart/form-data">

                <div class="field">
                    <div class="control">
                        <label for="r_title">Title</label>
                        <input name="title" id="r_title" value="<?= $recipe['title'] ?>" class="input" type="text" required>
                    </div>
                </div>

                <div class="file column">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image" id="image">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Choose an image…
                        </span>
                    </span>
                    </label>
                </div>

                <div id="root">
                    <div class="field">
                        <div class="control">
                            <label for="amount">Amount of ingredients</label>
                            <input id="amount" value="<?= count($details) ?>" type="text" class="input">
                        </div>
                    </div>

                    <label for="">Ingredients</label>

                    <?php foreach ($details as $key => $value) : ?>
                        <input type="hidden" name="<?= 'pivot_id' .$key ?>" value="<?= $value['id'] ?>">
                    <div class="columns">
                        <div class="field column is-one-fifth">
                            <div class="control">
                                <input name="<?= 'ingredient_count' . $key ?>" id="ingredient_count" min="0" value="<?= $value['ingredient_count'] ?>" type="number" class="input">
                            </div>
                        </div>
                        <div class="field column is-one-fifth">
                            <div class="control">
                                <div class="select">
                                    <select name="<?= 'measurement_id' . $key ?>">
                                        <option value="<?= $value['measurement_id'] ?>"><?= $value['measurement_title'] ?></option>
                                        <?php foreach ($measurements as $measurement) : ?>
                                        <?php if ($measurement['title'] === $value['measurement_title']) continue; ?>
                                            <option value="<?= $measurement['id'] ?>"><?= $measurement['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field column">
                            <div class="control">
                                <div class="select">
                                    <select name="<?= 'ingredient_id' . $key ?>">
                                        <option value="<?= $value['ingredient_id'] ?>"><?= $value['ingredient_title'] ?></option>
                                        <?php foreach ($ingredients as $ingredient) : ?>
                                        <?php if ($ingredient['title'] === $value['ingredient_title']) continue; ?>
                                            <option value="<?= $ingredient['id'] ?>"><?= $ingredient['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>

                <div class="field">
                    <div class="control">
                        <label for="instructions">Instructions</label>
                        <textarea name="instructions" id="instructions" required class="textarea" placeholder="Instructions"><?= $recipe['instructions'] ?></textarea>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label for="time_preparing">Time (in minutes) to prepare</label>
                        <input name="time_preparing" id="time_preparing" value="<?= $recipe['time_preparing'] ?>" required min="5" type="number" class="input">
                    </div>
                </div>

                <div class="field section">
                    <div class="control">
                        <button class="button is-warning">Submit</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

<?php require "partials/footer.view.php" ?>