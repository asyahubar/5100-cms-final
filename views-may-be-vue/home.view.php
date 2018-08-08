<?php require "partials/header.view.php" ?>

<div class="container">

    <nav class="breadcrumb section" aria-label="breadcrumbs">
        <ul>
            <li class="is-active"><a href="#" aria-current="page">Homepage</a></li>
        </ul>
    </nav>

    <article class="message is-warning">
        <div class="message-header">
            <p>Instructions</p>
        </div>
        <div class="message-body">
            insert instruction
        </div>
    </article>

    <div class="section">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Recipe name
                </p>
                <a href="#" class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                </a>
            </header>
            <div class="card-content columns">
                <div class="content column is-one-third">
                    <h5>Ingredients</h5>
                    <ul>
                        <li>ingredient list</li>
                    </ul>
                </div>
                <div class="content column">
                    <article class="message is-warning">
                        <div class="message-header">
                            <p>Instructions</p>
                        </div>
                        <div class="message-body">
                            insert instruction
                        </div>
                    </article>
                </div>
            </div>
            <footer class="card-footer">
                <a href="#" class="card-footer-item">Edit</a>
                <a href="#" class="card-footer-item">Delete</a>
            </footer>
        </div>
    </div>

</div>
<?php require "partials/footer.view.php" ?>