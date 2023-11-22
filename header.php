<nav id="navbar" style="transition: top 0.3s;" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <?php if (isset($_SESSION["logged_in"])) { ?>
            <span class="navbar-text text-white">
                Ingelogd als: <b><?php echo $_SESSION["username"]; ?></b>
            </span>
            <form class="d-flex" action="index.php" method="post">
                <input type="search" class="form-control ds-input me-2" id="search-input" name="search" placeholder="Zoeken..." aria-label="Search for..." autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" />
                <button class="btn btn-outline-secondary" type="submit">Zoeken</button>
            </form>
            <div>
                <a href="add.php" class="btn btn-secondary ms-2">Nieuwe record toevoegen</a>
                <a href="logout.php" class="btn btn-danger ms-2">Log uit</a>
            </div>
        <?php } else { ?>
            <div class="ms-auto text-white">
                <span>Je bezoekt de site momenteel als gast, klik <a href='login.php'>hier</a> om in te loggen</span>
            </div>
        <?php } ?>
    </div>
</nav>