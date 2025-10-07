<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="phpstyle.css">
    <style>
        table {
            width: 60vw;
            height: 20vh;
            border-collapse: collapse;
            border-radius: 15px;
        }

        th,
        td {
            border: 1px solid grey;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #BED7F4;
        }

        a {
            text-decoration: none;
            color: black;
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
        // echo "Connected successfully <br>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }


    $stmt = $conn->query("SELECT * FROM klanten");
    $klanten = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <main>
        <section class="sidebar">
            <a href="index.php" class="a-button active" style="margin-top: 60px;">Dashboard</a>
            <a href="" class="a-button">Settings</a>

            <a href="index.html" class="logout a-button">Log out</a>
        </section>

        <section class="klanten">
            <h1>Customer overview</h1><br>
            <?php if (count($klanten)  > 0) : ?>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                    <?php foreach ($klanten as $klant) : ?>
                        <tr>
                            <td><a href="klant.php?id=<?php echo $klant['id']; ?>"><?php echo htmlspecialchars($klant['naam']); ?></a></td>
                            <td><a href="klant.php?id=<?php echo $klant['id']; ?>"><?php echo htmlspecialchars($klant['email']); ?></a></td>
                            <td><a href="klant.php?id=<?php echo $klant['id']; ?>"><?php echo htmlspecialchars($klant['wachtwoord']); ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No customers found.</p>
            <?php endif; ?>
        </section>
    </main>


</body>

</html>