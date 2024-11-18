<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Book Management</h2>
    <button id="addBookButton" class="btn btn-primary mb-3">Add New Book</button>

    <div id="bookModal" class="modal" tabindex="-1" style="display:none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Book Details</h5>
                    <button type="button" class="btn-close" onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <form id="bookForm">
                        <input type="hidden" name="book_id" id="book_id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" name="author" id="author" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" name="genre" id="genre" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="publication_year" class="form-label">Publication Year</label>
                            <input type="number" name="publication_year" id="publication_year" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success">Save Book</button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div id="bookList">
        <!-- Book list will be loaded here -->
    </div>
</div>

<script>
    
    function closeModal() {
        $('#bookModal').hide();
        $('#bookForm')[0].reset();
        $('#book_id').val('');
    }

    $('#addBookButton').on('click', function() {
        $('#bookModal').show();
    });

    $('#bookForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize() + "&action=add_or_update";

        $.ajax({
            url: 'book_actions.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                closeModal();
                loadBooks(); 
            }
        });
    });

    // Function to load book list
    function loadBooks() {
        $.ajax({
            url: 'book_actions.php',
            type: 'POST',
            data: { action: 'list' },
            success: function(response) {
                $('#bookList').html(response);
            }
        });
    }

    // Edit Book
    $(document).on('click', '.edit-book', function() {
        var bookId = $(this).data('id');
        $.ajax({
            url: 'book_actions.php',
            type: 'GET',
            data: { action: 'fetch', book_id: bookId },
            success: function(response) {
                var book = JSON.parse(response);
                $('#book_id').val(book.book_id);
                $('#title').val(book.title);
                $('#author').val(book.author);
                $('#genre').val(book.genre);
                $('#publication_year').val(book.publication_year);
                $('#bookModal').show();
            }
        });
    });

    $(document).ready(function() {
        loadBooks();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
