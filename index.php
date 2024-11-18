<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Library Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="?page=add_book">Add Book</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=add_member">Add Member</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=issue_book">Issue Book</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=record_list">Record List</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <?php
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'add_book':
                include 'add_book.php';
                break;
            case 'add_member':
                include 'add_member.php';
                break;
            case 'issue_book':
                include 'issue_book.php';
                break;
            case 'record_list':
                include 'record_list.php';
                break;
                default:
                echo "
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='jumbotron' style='background-color: #f5f5f5; border-radius: 10px; padding: 30px;'>
                            <h2 class='display-4 text-center text-primary'>Welcome to the Library Management System</h2>
                            <p class='lead text-center'>Your one-stop platform to manage books, members, and records efficiently.</p>
                            <hr class='my-4'>
                            <p class='text-center'>Choose an option from the menu to get started!</p>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='card' style='background-color: #007bff; color: white; border-radius: 10px;'>
                            <div class='card-body text-center'>
                                <h3 class='card-title'>Explore Library Features</h3>
                                <p class='card-text'>Easily manage your library's operations. Add books, issue them to members, and more!</p>
                                <a href='?page=add_book' class='btn btn-light'>Add Book</a>
                                <a href='?page=add_member' class='btn btn-light'>Add Member</a>
                                <a href='?page=issue_book' class='btn btn-light'>Issue Book</a>
                                <a href='?page=record_list' class='btn btn-light'>View Records</a>
                            </div>
                        </div>
                    </div>
                </div>
                <section class='mt-5'>
                    <div class='row'>
                        <div class='col-md-4'>
                            <div class='card shadow-lg' style='border-radius: 10px;'>
                                <img src='https://via.placeholder.com/300x200.png?text=Books+Collection' class='card-img-top' alt='Books Collection'>
                                <div class='card-body'>
                                    <h5 class='card-title text-center'>Vast Book Collection</h5>
                                    <p class='card-text'>Explore a wide range of books across genres and topics.</p>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card shadow-lg' style='border-radius: 10px;'>
                                <img src='https://via.placeholder.com/300x200.png?text=Member+Management' class='card-img-top' alt='Member Management'>
                                <div class='card-body'>
                                    <h5 class='card-title text-center'>Member Management</h5>
                                    <p class='card-text'>Add, update, and manage members for a smooth library experience.</p>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-4'>
                            <div class='card shadow-lg' style='border-radius: 10px;'>
                                <img src='https://via.placeholder.com/300x200.png?text=Book+Issue' class='card-img-top' alt='Book Issue'>
                                <div class='card-body'>
                                    <h5 class='card-title text-center'>Book Issue System</h5>
                                    <p class='card-text'>Easily issue books to members and keep track of borrowings.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>";
                break;
            
        }
    ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>
</html>
