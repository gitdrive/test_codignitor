<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        /* Style the body */
        body {
            font-family: Arial;
            margin: 0;
        }

        /* Header/logo Title */
        .header {
            padding: 60px;
            text-align: center;
            background: #1abc9c;
            color: white;
        }

        /* Style the top navigation bar */
        .navbar {
            display: flex;
            background-color: #333;
        }

        /* Style the navigation bar links */
        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }

        /* Change color on hover */
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Column container */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        /* Create two unequal columns that sits next to each other */
        /* Sidebar/left column */
        .side {
            flex: 30%;
            background-color: #f1f1f1;
            padding: 20px;
        }


        /* Fake image, just for this example */
        .fakeimg {
            background-color: #aaa;
            width: 100%;
            padding: 20px;
        }


        /* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 700px) {
            .row, .navbar {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>


<!-- The flexible grid (content) -->
<div class="row">
    <div class="side">
        <h2>About Me</h2>
<!--        Username --><?php //echo $this->session->userdata('username');
        ?>
        <table>
            <tr>
                <td><h4>Username</h4></td>
                <td><?php   echo $this->session->userdata('username'); ?></td>
            </tr>
            <tr>
                <td><h4>Name</h4></td>
                <td><?php  print_r($userdata[0]['name']); ?></td>
            </tr>
            <tr>
                <td><h4>Email</h4></td>
                <td><?php  print_r($userdata[0]['email']); ?></td>
            </tr>
            <tr>
                <td><h4>Contact</h4></td>
                <td><?php  print_r($userdata[0]['phone']); ?></td>
            </tr>

        </table>
        <h5>Photo of me:</h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
    </div>
</div>


</body>
</html>
