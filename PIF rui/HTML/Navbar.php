<nav class="navbar navbar-expand-lg navbar-light p-3">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="Home.php">DataCorp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-2 active text-white" aria-current="page" href="Home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-white" href="newReservation.php">Reservations</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link mx-2 dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION["Name"] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="MyProfile.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">My Reservations</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-none d-lg-inline-flex">

            </ul>
        </div>
    </div>
    <form method="post">
        <button class="btn btn-light" type="submit" name="logout">Logout</button>
    </form>
</nav>