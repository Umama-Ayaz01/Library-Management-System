<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJpE6H6VmdmVX9R7fyyD5Yfuim72FVv5vbp+e6w/a4mIQhxL0vfsHGtONDAy" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <h2>Issue Book</h2>

        <!-- Issue Book Form -->
        <form id="issueBookForm" method="POST" class="mt-4">
            <input type="hidden" id="issue_id" name="issue_id" value="">

            <div class="mb-3">
                <label for="book_id" class="form-label">Select Book:</label>
                <select id="book_id" name="book_id" class="form-select" required>
                    <option value="" disabled selected>Choose Book</option> 
                    <!-- Books will be populated -->
                </select>
            </div>

            <div class="mb-3">
                <label for="member_id" class="form-label">Select Member:</label>
                <select id="member_id" name="member_id" class="form-select" required>
                    <option value="" disabled selected>Choose Member</option> 
                    <!-- Members will be populated  -->
                </select>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary">Issue Book</button>
        </form>

        <h3 class="mt-5">Issued Books</h3>

        <!-- Issued Books Table -->
        <table id="issuedBooksList" class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Book</th>
                    <th>Member</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Issued books will be loaded here dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOly2ChGQU6HhvZhnxQpS6nZYAGpG7l31yyMklz5gsXLMc7p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ1eYw6aJfLfH4U5zDtbD3aWktD/hbkw0p7w2JloO" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            loadBooks();
            loadMembers();
            loadIssuedBooks();

           
            $('#issueBookForm').on('submit', function (e) {
                e.preventDefault();

                var issueId = $('#issue_id').val(); 
                var actionType = (issueId == "") ? 'issue' : 'update'; 
                var formData = $(this).serialize() + '&action=' + actionType;

                $.ajax({
                    url: 'issue_book_action.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        alert(response);
                        loadIssuedBooks();
                        $('#issueBookForm')[0].reset(); 
                        $('#submitBtn').text('Issue Book'); 
                        $('#issue_id').val(''); 
                    }
                });
            });

            // Edit book issue
            $(document).on('click', '.editBtn', function () {
                var issueId = $(this).data('id');
                $.ajax({
                    url: 'get_issued_books.php',
                    type: 'POST',
                    data: { action: 'getIssue', issue_id: issueId },
                    success: function (response) {
                        var issue = JSON.parse(response);
                        $('#issue_id').val(issue.issue_id);
                        $('#book_id').val(issue.book_id);
                        $('#member_id').val(issue.member_id); 
                        $('#submitBtn').text('Update Issue'); 
                    }
                });
            });

            // Delete issue
            $(document).on('click', '.deleteBtn', function () {
                var issueId = $(this).data('id');
                if (confirm('Are you sure you want to delete this issue?')) {
                    $.ajax({
                        url: 'issue_book_action.php',
                        type: 'POST',
                        data: { action: 'deleteIssue', issue_id: issueId },
                        success: function (response) {
                            alert(response);
                            loadIssuedBooks();
                        }
                    });
                }
            });
        });

        // Load books into the dropdown
        function loadBooks() {
            $.ajax({
                url: 'get_books.php',
                type: 'POST',
                data: { action: 'loadBooks' },
                success: function (response) {
                    $('#book_id').html('<option value="" disabled selected>Choose Book</option>' + response);
                }
            });
        }

        // Load members into the dropdown
        function loadMembers() {
            $.ajax({
                url: 'get_members.php',
                type: 'POST',
                data: { action: 'loadMembers' },
                success: function (response) {
                    $('#member_id').html('<option value="" disabled selected>Choose Member</option>' + response);
                }
            });
        }

        // Load issued books into the table
        function loadIssuedBooks() {
            $.ajax({
                url: 'get_issued_books.php',
                type: 'POST',
                data: { action: 'loadIssuedBooks' },
                success: function (response) {
                    $('#issuedBooksList tbody').html(response);
                }
            });
        }
    </script>
</body>
</html>
