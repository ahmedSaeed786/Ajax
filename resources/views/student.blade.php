<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <form method="POST" id="studentForm">
        <legend>Add Student</legend>
        <input type="hidden" name="_token" id="csrf" value="{{ Session::token() }}">
    
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Input field">
        </div>
    
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Input field">
        </div>
    
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" class="form-control" placeholder="Input field">
        </div>
    
        <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" id="classInput" class="form-control" placeholder="Input field">
        </div>
    
        <input type="submit" id="btnsubmit" value="Add Student">
    </form>

    <hr>

    <h2>Students List</h2>
    <table id="studentTable" border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Class</th>
            </tr>
        </thead>
        <tbody id="studentTableBody">
            <!-- Student data will be dynamically added here -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            function fetchStudents() {
                $.ajax({
                    url: "/student",
                    type: "GET",
                    success: function(response) {
                        console.log("Fetch Students Response:", response);
                        if (response.statusCode === 200) {
                            var students = response.students;
                            var tableBody = $('#studentTable tbody');

                            // Clear existing rows
                            tableBody.empty();

                            // Append rows for each student
                            students.forEach(function(student) {
                                var row = '<tr>' +
                                    '<td>' + student.name + '</td>' +
                                    '<td>' + student.email + '</td>' +
                                    '<td>' + student.age + '</td>' +
                                    '<td>' + student.class + '</td>' +
                                    '</tr>';
                                tableBody.append(row);
                            });
                        } else {
                            console.error("Error: Invalid statusCode", response);
                            alert("Error occurred: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching students:", error, xhr);
                        alert("Error occurred: " + error);
                    }
                });
            }

            // Fetch students on page load
            fetchStudents();

            $('#btnsubmit').on('click', function(event) {
                event.preventDefault();
                
                var name = $('#name').val();
                var email = $('#email').val();
                var studentClass = $('#classInput').val();
                var age = $('#age').val();
                
                if (name !== "" && email !== "" && studentClass !== "" && age !== "") {
                    $.ajax({
                        url: "/students",
                        type: "POST",
                        data: {
                            _token: $("#csrf").val(),
                            name: name,
                            email: email,
                            class: studentClass,
                            age: age
                        },
                        cache: false,
                        success: function(dataResult) {
                            console.log("Add Student Response:", dataResult);

                            // Fetch students after adding a new student
                            fetchStudents();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error adding student:", error, xhr);
                            alert("Error occurred: " + error);
                        }
                    });
                } else {
                    alert("All fields are required!");
                }
            });
        });
    </script>
</body>
</html>
