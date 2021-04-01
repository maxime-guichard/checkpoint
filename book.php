<?php

require_once 'Database.php';

$database = new Database;
$bribes = $database->read();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = ['name', "payment"];
    $data = array_map('trim', $_POST);

    foreach ($data as $input => $inputValue) {
        if (!in_array($input, $inputs)) {
            $errors[] = 'Le champ ' . $input . ' n\'est pas présent';
        } elseif (empty($inputValue)) {
            $errors[] = 'Le champ ' . $input . ' ne doit pas être vide';
        } else if ($input === 'payment' && !empty($inputValue) && $inputValue <= 0) {
            $errors[] = 'Le paiement ne doit pas être null';
        } else {
            $data[$input] = htmlentities($inputValue);
        }
    }

    if (empty($errors)) {
        $database->add($data);
        header('location: /book.php');
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>

<body>

<?php include 'header.php'; ?>

<main class="container">

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
                Add a bribe

                <?php if (!empty($errors)) : ?>
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
                <form action="" method="POST" novalidate>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Alpacino" required>
                    <label for="payment">Payment</label>
                    <input type="number" name="payment" id="payment" placeholder="€€€€" required>
                    <button>PAY!</button>
                </form>
            </div>

            <div class="page rightpage">
            <caption>S</caption>
                <div class="line"></div>
                    <table>
                        <thead>
                        </thead>
                        <tbody>
                            <?php foreach ($bribes as $bribe) : ?>
                                <tr>
                                    <td class="left"><?= $bribe->name; ?></td>
                                    <td><?= $bribe->payment . '€'; ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="left-foot">Total</td>
                                <td class=line-top>
                                    <?php $sum = 0; ?>
                                    <?php foreach ($bribes as $bribe) : ?>
                                        <?php $sum += $bribe->payment ?>
                                    <?php endforeach ?>
                                    <?= $sum . '€'; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
    </section>
</main>
</body>
</html>
