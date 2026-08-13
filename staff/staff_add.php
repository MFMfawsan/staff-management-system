<?php

include '../includes/auth.php';
include '../db/db.php';


/* =====================================================
   ADD STAFF
===================================================== */

if (isset($_POST['add'])) {

    $staff_id = mysqli_real_escape_string(
        $conn,
        $_POST['staff_id']
    );

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    $designation = mysqli_real_escape_string(
        $conn,
        $_POST['designation']
    );

    $department = mysqli_real_escape_string(
        $conn,
        $_POST['department']
    );

    $contact = mysqli_real_escape_string(
        $conn,
        $_POST['contact']
    );

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $date_of_join = mysqli_real_escape_string(
        $conn,
        $_POST['date_of_join']
    );


    /* =================================================
       PROFILE PICTURE
    ================================================= */

    $uploadDir = "../assets/uploads/profile_pics/";

    $profile_pic = "default.JPG";


    if (!is_dir($uploadDir)) {

        mkdir(
            $uploadDir,
            0755,
            true
        );
    }


    if (
        isset($_FILES['profile_pic']) &&
        $_FILES['profile_pic']['error'] === 0
    ) {

        $fileTmp = $_FILES['profile_pic']['tmp_name'];

        $originalName = basename(
            $_FILES['profile_pic']['name']
        );

        $fileName =
            time() . "_" . $originalName;

        $filePath =
            $uploadDir . $fileName;


        if (
            move_uploaded_file(
                $fileTmp,
                $filePath
            )
        ) {

            $profile_pic = $fileName;
        }
    }


    /* =================================================
       INSERT STAFF
    ================================================= */

    $sql = "INSERT INTO staff
            (
                staff_id,
                name,
                designation,
                department,
                contact,
                email,
                date_of_join,
                profile_pic
            )
            VALUES
            (
                '$staff_id',
                '$name',
                '$designation',
                '$department',
                '$contact',
                '$email',
                '$date_of_join',
                '$profile_pic'
            )";


    if ($conn->query($sql)) {

        echo "
        <script>
            alert('Staff added successfully');
            window.location='staff_list.php';
        </script>
        ";

    } else {

        $database_error = $conn->error;
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Staff | Staff Manager</title>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>


    /* =================================================
       RESET
    ================================================= */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }


    /* =================================================
       BODY
    ================================================= */

    body {

        min-height: 100vh;

        font-family:
            'Segoe UI',
            Arial,
            sans-serif;

        background:

            radial-gradient(
                circle at 10% 10%,
                rgba(159, 224, 195, 0.13),
                transparent 30%
            ),

            radial-gradient(
                circle at 90% 90%,
                rgba(232, 184, 109, 0.08),
                transparent 30%
            ),

            #091B1E;

        color: #F4FFFA;

        display: flex;

        justify-content: center;

        align-items: center;

        padding: 35px 20px;
    }


    /* =================================================
       MAIN PAGE
    ================================================= */

    .add-staff-page {

        width: 100%;

        display: flex;

        justify-content: center;

        align-items: center;
    }


    /* =================================================
       MAIN CARD
    ================================================= */

    .add-staff-container {

        width: 100%;

        max-width: 850px;

        background:
            linear-gradient(
                145deg,
                #163336,
                #0D2427
            );

        border:
            1px solid
            rgba(159, 224, 195, 0.16);

        border-radius: 24px;

        padding: 40px;

        position: relative;

        overflow: hidden;

        box-shadow:
            0 30px 70px
            rgba(0, 0, 0, 0.45);
    }


    /* =================================================
       TOP COLOR LINE
    ================================================= */

    .add-staff-container::before {

        content: "";

        position: absolute;

        top: 0;

        left: 0;

        width: 100%;

        height: 4px;

        background:
            linear-gradient(
                90deg,
                #9FE0C3,
                #E8B86D,
                #9FE0C3
            );
    }


    /* =================================================
       DECORATIVE CIRCLE
    ================================================= */

    .add-staff-container::after {

        content: "";

        position: absolute;

        width: 240px;

        height: 240px;

        border-radius: 50%;

        background:
            rgba(
                159,
                224,
                195,
                0.035
            );

        right: -120px;

        top: -120px;

        pointer-events: none;
    }


    /* =================================================
       HEADER
    ================================================= */

    .add-staff-header {

        text-align: center;

        margin-bottom: 35px;

        position: relative;

        z-index: 2;
    }


    /* =================================================
       ICON
    ================================================= */

    .add-staff-header .icon {

        width: 65px;

        height: 65px;

        margin:
            0 auto 15px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 18px;

        background: #9FE0C3;

        color: #0F2A2E;

        font-size: 27px;

        box-shadow:
            0 10px 25px
            rgba(
                159,
                224,
                195,
                0.12
            );
    }


    /* =================================================
       TITLE
    ================================================= */

    .add-staff-header h2 {

        color: #FFFFFF;

        font-size: 28px;

        font-weight: 700;

        margin: 0;
    }


    /* =================================================
       SUBTITLE
    ================================================= */

    .add-staff-header p {

        margin-top: 8px;

        color: #8EA9A7;

        font-size: 14px;
    }


    /* =================================================
       FORM
    ================================================= */

    .add-staff-form {

        display: grid;

        grid-template-columns:
            1fr 1fr;

        gap:
            20px 22px;

        position: relative;

        z-index: 2;
    }


    /* =================================================
       FORM GROUP
    ================================================= */

    .form-group {

        display: flex;

        flex-direction: column;
    }


    /* =================================================
       LABEL
    ================================================= */

    .form-group label {

        margin-bottom: 8px;

        color: #CDEEDF;

        font-size: 13px;

        font-weight: 600;
    }


    /* Required star */

    .form-group label span {

        color: #9FE0C3;

        margin-left: 3px;
    }


    /* =================================================
       INPUT
    ================================================= */

    .form-group input {

        width: 100%;

        height: 46px;

        padding:
            0 14px;

        background: #0B2528;

        color: #F4FFFA;

        border:
            1px solid
            #315154;

        border-radius: 10px;

        outline: none;

        font-size: 14px;

        transition:
            all 0.25s ease;
    }


    /* =================================================
       PLACEHOLDER
    ================================================= */

    .form-group input::placeholder {

        color: #6F8988;
    }


    /* =================================================
       FOCUS
    ================================================= */

    .form-group input:focus {

        background: #0D2A2D;

        border-color: #9FE0C3;

        box-shadow:
            0 0 0 3px
            rgba(
                159,
                224,
                195,
                0.10
            );
    }


    /* =================================================
       DATE
    ================================================= */

    .form-group input[type="date"] {

        color-scheme: dark;
    }


    /* =================================================
       FILE INPUT
    ================================================= */

    .form-group input[type="file"] {

        height: auto;

        padding: 8px;

        cursor: pointer;
    }


    /* =================================================
       FILE BUTTON
    ================================================= */

    .form-group
    input[type="file"]::file-selector-button {

        background: #9FE0C3;

        color: #0F2A2E;

        border: none;

        padding:
            8px 13px;

        margin-right: 10px;

        border-radius: 7px;

        font-weight: 600;

        cursor: pointer;

        transition: 0.25s;
    }


    .form-group
    input[type="file"]::file-selector-button:hover {

        background: #BDEFD6;
    }


    /* =================================================
       BUTTON AREA
    ================================================= */

    .form-actions {

        grid-column:
            1 / -1;

        display: flex;

        gap: 12px;

        margin-top: 8px;
    }


    /* =================================================
       BACK BUTTON
    ================================================= */

    .btn-back {

        width: 150px;

        height: 48px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 7px;

        border:
            1px solid
            #36575A;

        border-radius: 10px;

        background: transparent;

        color: #B6CDCA;

        text-decoration: none;

        font-size: 14px;

        font-weight: 600;

        transition:
            all 0.3s ease;
    }


    .btn-back:hover {

        background: #183A3D;

        color: #9FE0C3;

        border-color: #9FE0C3;

        transform:
            translateY(-2px);
    }


    /* =================================================
       ADD BUTTON
    ================================================= */

    .btn-add {

        flex: 1;

        height: 48px;

        border: none;

        border-radius: 10px;

        background:
            linear-gradient(
                135deg,
                #9FE0C3,
                #83D3B0
            );

        color: #0F2A2E;

        font-size: 14px;

        font-weight: 700;

        cursor: pointer;

        transition:
            all 0.3s ease;
    }


    .btn-add:hover {

        background:
            linear-gradient(
                135deg,
                #BDEFD6,
                #9FE0C3
            );

        transform:
            translateY(-2px);

        box-shadow:
            0 12px 25px
            rgba(
                159,
                224,
                195,
                0.18
            );
    }


    .btn-add:active {

        transform:
            translateY(0);
    }


    /* =================================================
       ERROR MESSAGE
    ================================================= */

    .database-error {

        width: 100%;

        max-width: 850px;

        margin: 20px auto;

        padding: 14px;

        background: #3B1F23;

        border:
            1px solid
            #7F3A43;

        border-radius: 10px;

        color: #FFB4B4;

        text-align: center;

        font-size: 14px;
    }


    /* =================================================
       MOBILE
    ================================================= */

    @media (max-width: 700px) {

        body {

            padding:
                25px 15px;

            align-items:
                flex-start;
        }


        .add-staff-page {

            margin-top: 10px;
        }


        .add-staff-container {

            padding:
                30px 22px;

            border-radius:
                19px;
        }


        .add-staff-header h2 {

            font-size:
                23px;
        }


        .add-staff-form {

            grid-template-columns:
                1fr;

            gap:
                17px;
        }


        .form-actions {

            grid-column:
                auto;

            flex-direction:
                column;
        }


        .btn-back {

            width: 100%;
        }


        .btn-add {

            width: 100%;
        }
    }


    </style>

</head>


<body>


    <!-- =================================================
         ADD STAFF PAGE
    ================================================= -->

    <div class="add-staff-page">


        <div class="add-staff-container">


            <!-- =========================
                 HEADER
            ========================= -->

            <div class="add-staff-header">

                <div class="icon">

                    <i class="fa-solid fa-user-plus"></i>

                </div>


                <h2>
                    Add New Staff
                </h2>


                <p>
                    Create a new staff member profile
                </p>

            </div>


            <!-- =========================
                 DATABASE ERROR
            ========================= -->

            <?php if (isset($database_error)): ?>

                <div class="database-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <?php echo $database_error; ?>

                </div>

            <?php endif; ?>


            <!-- =========================
                 FORM
            ========================= -->

            <form
                method="POST"
                enctype="multipart/form-data"
                class="add-staff-form"
            >


                <!-- STAFF ID -->

                <div class="form-group">

                    <label>

                        Staff ID

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="staff_id"
                        placeholder="Enter staff ID"
                        required
                    >

                </div>


                <!-- NAME -->

                <div class="form-group">

                    <label>

                        Full Name

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter full name"
                        required
                    >

                </div>


                <!-- DESIGNATION -->

                <div class="form-group">

                    <label>

                        Designation

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="designation"
                        placeholder="Enter designation"
                        required
                    >

                </div>


                <!-- DEPARTMENT -->

                <div class="form-group">

                    <label>

                        Department

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="department"
                        placeholder="Enter department"
                        required
                    >

                </div>


                <!-- CONTACT -->

                <div class="form-group">

                    <label>

                        Contact Number

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="contact"
                        placeholder="Enter contact number"
                        required
                    >

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label>

                        Email Address

                        <span>*</span>

                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter email address"
                        required
                    >

                </div>


                <!-- DATE OF JOIN -->

                <div class="form-group">

                    <label>

                        Date of Join

                    </label>

                    <input
                        type="date"
                        name="date_of_join"
                    >

                </div>


                <!-- PROFILE PICTURE -->

                <div class="form-group">

                    <label>

                        Profile Picture

                    </label>

                    <input
                        type="file"
                        name="profile_pic"
                        accept="image/*"
                    >

                </div>


                <!-- =========================
                     ACTION BUTTONS
                ========================= -->

                <div class="form-actions">


                    <!-- BACK -->

                    <a
                        href="staff_list.php"
                        class="btn-back"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Back

                    </a>


                    <!-- ADD STAFF -->

                    <button
                        type="submit"
                        name="add"
                        class="btn-add"
                    >

                        <i class="fa-solid fa-user-plus"></i>

                        &nbsp;

                        Add Staff

                    </button>


                </div>


            </form>


        </div>

    </div>


</body>

</html>