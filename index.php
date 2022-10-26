<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="display.css">

    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="center_div">

            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <h1 class="navbar-brand">PHP & AJAX </h1>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse p-3" id="navbarSupportedContent">
                        <form class="d-flex myfrom text-white">
                            <input class="form-control me-2" id="search" type="search" placeholder="Search"
                                aria-label="Search">
                            <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
                        </form>
                    </div>
                </div>
            </nav>

            <!-- from session start -->
            <div class="form_div">
                <form id="addfrom" action="" method="post">
                    <div class="d-flex">
                        <label class="mx-3" for="fristName">Frist Name : </label>
                        <input class="form-control inla" style="width:20%;" id="fname" type="text" name="fname">

                        <label class="mx-3" for="lastName">Last Name : </label>
                        <input class="form-control" style="width:20%;" id="lname" type="text" name="lname">

                        <button style="margin-left:15px;" type="submit" id="submit_btn"
                            class="btn btn-primary btn-sm px-4 py-1">submit</button>
                    </div>
                    <div class="invalid-feedback" id="error_mag"
                        style="text-align:center; font-size:20px; padding:10px; font-weight:bolder;">
                    </div>
                    <div id="success_mag"
                        style="text-align:center; font-size:20px; padding:10px; font-weight:bolder; color:white;"></div>
                </form>
            </div>



            <!-- Table session start -->
            <div class=" table_session">
                <div class="table_center">
                    <table style="width:90%; margin: 0 auto;">
                        <tr>
                            <td>
                                <!-- <button type="submit" id="load_data"
                                    class="btn btn-outline-primary m-3 w-50 text-center">Show
                                    Data</button> -->
                            </td>
                        </tr>

                        <tr>
                            <td id="show_data">

                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Edit form creting -->
            <div id="id01" class="modal">
                <span onclick="document.getElementById('id01').style.display='none'" class="close"
                    title="Close Modal">&times;</span>
                <form class="modal-content" action="/action_page.php">

                </form>
            </div>


        </div>
    </div>

    <!-- javascript cone start -->
    <script src="../js/jquery-3.6.1.js"></script>

    <script>
    $(document).ready(function() {

        function student() {
            $.ajax({
                type: "POST",
                url: "load_data.php",
                // data: "data",
                // dataType: "dataType",
                success: function(data) {
                    $("#show_data").html(data);
                }
            });
        }
        student();

        // Insert Data 
        $("#submit_btn").on('click', function(e) {
            e.preventDefault();

            var first_name = $("#fname").val();
            var last_name = $("#lname").val();

            // form validation
            if (first_name == '' || last_name == '') {
                $("#error_mag").html("Plaze fill the input option!!!").slideDown();
                $("#success_mag").slideUp();
            } else {
                $.ajax({
                    type: "POST",
                    url: "ajax_insert.php",
                    data: {
                        first_name: first_name,
                        last_name: last_name
                    },
                    // dataType: "dataType",
                    success: function(response) {
                        if (response == 1) {
                            $("#success_mag").html("Data Inserted Successfully")
                                .slideDown();
                            $("#error_mag").slideUp();
                            $("#addfrom").trigger('reset');
                            student();
                        } else {
                            alert("Data recode not found!!!");
                        }
                    }
                });

            }
        });

        // Delete Data 
        $(document).on('click', '.delete_btn', function(e) {
            if (confirm("Your data is deleting!")) {
                var deleteId = $(this).data('id');
                var element = this;
                $.ajax({
                    type: "POST",
                    url: "delete_data.php",
                    data: {
                        id: deleteId
                    },
                    // dataType: "dataType",
                    success: function(response) {
                        if (response == 1) {
                            $(element).closest("tr").fadeOut();
                        } else {
                            $("#error_mag").html("Data Not Deleting!!!").slideDown();
                            $("#success_mag").slideUp();
                        }
                    }
                });
            }
        });

        // Edit Data 
        $(document).on("click", ".edit_btn", function(e) {
            $("#id01").show();
            var editId = $(this).data('eid');

            $.ajax({
                type: "POST",
                url: "edit_load.php",
                data: {
                    eid: editId
                },
                // dataType: "dataType",
                success: function(response) {
                    $(".modal-content").html(response);
                }
            });

            $(document).on("click", "#update_btn", function(e) {
                e.preventDefault();

                var edit_id = $("#edit_id").val();
                var edit_firstName = $("#edit_fname").val();
                var edit_lastName = $("#edit_lname").val();

                $.ajax({
                    type: "POST",
                    url: "update.php",
                    data: {
                        e_id: edit_id,
                        e_fname: edit_firstName,
                        e_lname: edit_lastName
                    },
                    // dataType: "dataType",
                    success: function(response) {
                        if (response == 1) {
                            $("#id01").hide();
                            student();
                        } else {
                            alert("Your Data Not Updated!!!");
                        }
                    }
                });

            });

        });

        // Live search pagination start
        $("#search").on('keyup', function() {
            var searchId = $(this).val();

            $.ajax({
                type: "POST",
                url: "Live_search.php",
                data: {
                    search: searchId
                },
                // dataType: "dataType",
                success: function(response) {
                    $("#show_data").html(response);
                }
            });
        });

    });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"> -->
    </script>
</body>

</html>