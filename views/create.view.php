<?php require "partials/header.view.php" ?>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

<div class="container">

    <nav class="breadcrumb section" aria-label="breadcrumbs">
        <ul>
            <li><a href="/">Homepage</a></li>
            <li class="is-active"><a href="#" aria-current="page" id="title">Create</a></li>
        </ul>
    </nav>

    <div class="section">
        <form action="/create/add" method="POST" enctype="multipart/form-data">

            <div class="field">
                <div class="control">
                    <label for="r_title">Title</label>
                    <input name="title" id="r_title" class="input" type="text" required>
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
                        <input id="amount" v-model="amount" type="text" class="input">
                    </div>
                </div>

                <label for="">Ingredients</label>
                <div class="columns" v-for="number in no">
                    <div class="field column is-one-fifth">
                        <div class="control">
                            <input :name="number[0]" id="ingredient_count" min="0" value="0" type="number" class="input">
                        </div>
                    </div>
                    <div class="field column is-one-fifth">
                        <div class="control">
                            <div class="select">
                                <select :name="number[1]">
                                    <option disabled>Choose a measurement</option>
                                    <?php foreach ($measurements as $measurement) : ?>
                                        <option value="<?= $measurement['id'] ?>"><?= $measurement['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field column">
                        <div class="control">
                            <div class="select">
                                <select :name="number[2]">
                                    <option disabled>Choose an ingredient</option>
                                    <?php foreach ($ingredients as $ingredient) : ?>
                                        <option value="<?= $ingredient['id'] ?>"><?= $ingredient['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label for="instructions">Instructions</label>
                    <textarea name="instructions" id="instructions" required class="textarea" placeholder="Instructions"></textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label for="time_preparing">Time (in minutes) to prepare</label>
                    <input name="time_preparing" id="time_preparing" required min="5" type="number" class="input">
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

    <script>
        new Vue({
            el: '#root',
            data: {
                amount: 2
            },
            computed: {
                no() {
                    let arr = [];
                    for (let i = 0; i < this.amount; i++) {
                        arr[i] = [];
                        arr[i].push('ingredient_count' + i, 'measurement' + i, 'ingredient' + i);
                    }
                    return arr;
                }
            }
        })
    </script>


<?php require "partials/footer.view.php" ?>