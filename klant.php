<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="phpstyle.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            /* margin: 20px auto; */
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .buttons {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
            width: 10vw;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        table {
            width: 60vw;
            height: 20vh;
            border-collapse: collapse;
            border-radius: 15px;
            font-size: 22px;

        }

        th,
        td {
            border: 1px solid grey;
            padding: 8px;
            text-align: left;
            height: 2vh;
        }

        input {
            font-size: 20px;
            width: 100%;
            border: none;
        }


        #update {
            background-color: #A2C2F7;
            color: white;
        }

        #update:hover {
            background-color: #6A92D4;
        }

        #delete {
            background-color: #B93E40;
            color: white;
        }

        #delete:hover {
            background-color: #7A2628;
        }
    </style>
</head>

<body>
    <?php
    $host = 'localhost';
    $db = 'klantonderhoud';
    $username = 'root';
    $password = '';
    $charset = 'utf8';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $stmt = $conn->prepare("SELECT * FROM klanten WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $klant = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        // echo "Connected successfully <br>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $name = $klant['naam'];
    $email = $klant['email'];
    $password = $klant['wachtwoord'];

    function updateKlant($id, $name, $email, $password)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE klanten SET naam = :name, email = :email, wachtwoord = :password WHERE id = :id");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password, 'id' => $id]);
        header("Location: index.php");
        exit();
    }

    function deleteKlant($id)
    {
        echo "Running delete for klant ID: $id<br>";
        global $conn;
        $stmt = $conn->prepare("DELETE FROM klanten WHERE id = :id");
        $stmt->execute(['id' => $id]);
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $id = $_GET['id'];

        if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            updateKlant($id, $name, $email, $password);

            header("Location: index.php");
            exit();
        } elseif ($action === 'delete') {
            deleteKlant($id);
            header("Location: index.php");
            exit();
        }
    }
    ?>

    <main class="main-klant">
        <?php if ($klant) : ?>
            <section class="sidebar">
                <a href="index.php" class="a-button active" style="margin-top: 60px;">Dashboard</a>
                <a href="" class="a-button">Settings</a>

                <a href="index.html" class="logout a-button">Log out</a>
            </section>

            <section class="klanten">

                <div class="header">
                    <a class="back-link" href="index.php" style="margin-right: 20px;  color: #63A9EF;"><i class="fa fa-arrow-circle-left fa-2x" aria-hidden="true"></i></a>
                    <h1>Customer Details</h1>
                </div>
                <p style="font-style: italic;">Click to edit and update details.</p>
                <br>

                <form action="klant.php?action=update&id=<?= $klant['id']; ?>" method="post">
                    <table>
                        <tr>
                            <th>Name</th>
                            <td><input type="text" name="name" value="<?php echo $name ?>"></td>
                            <!-- <td><a href=""></a>Edit</td> -->

                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><input type="text" name="email" value="<?php echo $email ?>"></td>
                            <!-- <td><a href=""></a>Edit</td> -->

                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><input type="text" name="password" value="<?php echo $password ?>"></td>
                            <!-- <td><a href=""></a>Edit</td> -->
                        </tr>
                    </table>
                    <div class="btns">
                        <button type="submit" id="update" class="buttons">Update</button>
                        <a href="klant.php?action=delete&id=<?= $klant['id']; ?>" id="delete" class="buttons" onclick="return confirm('Are you sure you want to delete this customer? This action cannot be turned back.');">Delete</a>
                    </div>

                </form>
            </section>


        <?php elseif (isset($_GET['id'])) : ?>
            <p>Customer not found.</p>
        <?php else : ?>
            <p>No customer ID provided.</p>
        <?php endif; ?>
    </main>


</body>

</html>