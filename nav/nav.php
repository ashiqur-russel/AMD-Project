<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">My Pizza</a>
        </div>
        <ul class="nav navbar-nav">
            <li <?php if (stripos($_SERVER['REQUEST_URI'], 'index.php') !== false) {echo 'class="active"';}?>>
                <a href="index.php">Home</a>
            </li>
            <li <?php if (stripos($_SERVER['REQUEST_URI'], 'pizza.php') !== false) {echo 'class="active"';}?>>
                <a class="nav-link" href="pizza.php">Pizza</a>
            </li>
            <li <?php if (stripos($_SERVER['REQUEST_URI'], 'ingredient.php') !== false) {echo 'class="active"';}?>>
                <a class="nav-link" href="ingredient.php">Ingredient</a>
            </li>
            <li <?php if (stripos($_SERVER['REQUEST_URI'], 'supplier.php') !== false) {echo 'class="active"';}?>>
                <a class="nav-link" href="supplier.php">Supplier</a>
            </li>

        </ul>
    </div>
</nav>