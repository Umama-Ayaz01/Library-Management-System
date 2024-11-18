<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Member Management</h2>

        <form id="memberForm" enctype="multipart/form-data" class="mb-4">
            <input type="hidden" id="member_id" name="member_id" value="">
            
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Gender:</label><br>
                <input type="radio" id="male" name="gender" value="Male" class="form-check-input">
                <label for="male" class="form-check-label">Male</label>

                <input type="radio" id="female" name="gender" value="Female" class="form-check-input ms-3">
                <label for="female" class="form-check-label">Female</label>

                <input type="radio" id="other" name="gender" value="Other" class="form-check-input ms-3">
                <label for="other" class="form-check-label">Other</label>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary">Add Member</button>
        </form>

        <h3>Member List</h3>
        <table id="membersList" class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Profile Picture</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Members will be loaded here dynamically -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            loadMembers();

            $('#memberForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                formData.append('action', $('#member_id').val() ? 'updateMember' : 'addMember');

                $.ajax({
                    url: 'member_action.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alert(response);
                        loadMembers(); 
                        $('#memberForm')[0].reset();
                        $('#submitBtn').text('Add Member'); 
                    }
                });
            });

            // Edit member
            $(document).on('click', '.editBtn', function () {
                var memberId = $(this).data('id');
                $.ajax({
                    url: 'member_action.php',
                    type: 'POST',
                    data: { action: 'getMember', member_id: memberId },
                    success: function (response) {
                        var member = JSON.parse(response);
                        $('#member_id').val(member.member_id);
                        $('#name').val(member.name);
                        $('#email').val(member.email);
                        $('#phone_number').val(member.phone_number);
                        if (member.gender === 'Male') {
                            $('#male').prop('checked', true);
                        } else if (member.gender === 'Female') {
                            $('#female').prop('checked', true);
                        } else {
                            $('#other').prop('checked', true);
                        }
                        $('#submitBtn').text('Update Member');
                    }
                });
            });

            // Delete member
            $(document).on('click', '.deleteBtn', function () {
                var memberId = $(this).data('id');
                if (confirm('Are you sure you want to delete this member?')) {
                    $.ajax({
                        url: 'member_action.php',
                        type: 'POST',
                        data: { action: 'deleteMember', member_id: memberId },
                        success: function (response) {
                            alert(response);
                            loadMembers(); 
                        }
                    });
                }
            });
        });

        // Load members into the table
        function loadMembers() {
            $.ajax({
                url: 'member_action.php',
                type: 'POST',
                data: { action: 'loadMembers' },
                success: function (response) {
                    $('#membersList tbody').html(response);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
