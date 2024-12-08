<?php
session_start();

if (isset($_POST['reset'])) {
    $_SESSION["positionCat"] = ["i" => 0, "j" => 0];
    $_SESSION['currentLab'] = ($_SESSION['currentLab'] === 'one') ? 'two' : 'one';
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (!isset($_SESSION['currentLab'])) {
    $_SESSION['currentLab'] = 'one';
    $_SESSION["positionCat"] = ["i" => 0, "j" => 0];

}

$tableau = [
    ["0", "0", "0", "0", "0", "1"],
    ["1", "1", "0", "1", "0", "0"],
    ["0", "0", "0", "1", "1", "1"],
    ["1", "0", "1", "0", "0", "0"],
    ["1", "0", "1", "0", "1", "S"],
    ["0", "0", "0", "0", "1", "0"],
];

$tableauTwo = [
    ["0", "0", "0", "0", "0", "0"],
    ["0", "0", "0", "0", "0", "0"],
    ["0", "0", "0", "0", "0", "0"],
    ["0", "0", "0", "0", "0", "0"],
    ["0", "0", "0", "0", "0", "0"],
    ["0", "S", "0", "0", "0", "0"],
];


$currentTable = ($_SESSION['currentLab'] === 'two') ? $tableauTwo : $tableau;

$positionCat = &$_SESSION["positionCat"];

$currentTable[$positionCat["i"]][$positionCat["j"]] = "C";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['move'])) {
    $currentTable[$positionCat['i']][$positionCat['j']] = "0";

    switch ($_POST['move']) {
        case 'up':
            if ($positionCat['i'] > 0 && $currentTable[$positionCat['i'] - 1][$positionCat['j']] !== "1") {
                $positionCat['i']--;
            }
            break;
        case 'down':
            if ($positionCat['i'] < count($currentTable) - 1 && $currentTable[$positionCat['i'] + 1][$positionCat['j']] !== "1") {
                $positionCat['i']++;
            }
            break;
        case 'left':
            if ($positionCat['j'] > 0 && $currentTable[$positionCat['i']][$positionCat['j'] - 1] !== "1") {
                $positionCat['j']--;
            }
            break;
        case 'right':
            if ($positionCat['j'] < count($currentTable[0]) - 1 && $currentTable[$positionCat['i']][$positionCat['j'] + 1] !== "1") {
                $positionCat['j']++;
            }
            break;
    }

    if ($currentTable[$positionCat['i']][$positionCat['j']] === "S") {
        echo "<p>BRAVO VOUS AVEZ GAGNÉ !</p>";
    }

    $currentTable[$positionCat['i']][$positionCat['j']] = "C";
}

$tableHtml = '<table border="1" style="border-collapse: collapse;">';
$visibleRadius = 1;

foreach ($currentTable as $i => $row) {
    $tableHtml .= '<tr>';
    foreach ($row as $j => $cell) {
        $distance = max(abs($positionCat['i'] - $i), abs($positionCat['j'] - $j));
        $style = 'width: 80px; height: 80px; text-align: center;';
        $backgroundColor = ($cell === "1") ? '#4b2d00' : 'pink';
        $style .= "background-color: $backgroundColor; position: relative;";

        if ($cell === "C") {
            $content = '<img src="assets/images/chat.png" alt="Chat" style="width: 60%;">';
        } elseif ($cell === "S") {
            $content = '<img src="assets/images/souris.png" alt="Souris" style="width: 60%;">';
        } else {
            $content = '&nbsp;';
        }

        $tableHtml .= '<td style="' . $style . '">';
        $tableHtml .= $content;

        if ($distance > $visibleRadius) {
            $tableHtml .= '<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #c4c4c4;"></div>';
        }

        $tableHtml .= '</td>';
    }
    $tableHtml .= '</tr>';
}
$tableHtml .= '</table>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/laby.css">
    <title>Labyrinthe</title>
</head>

<body>
    <header>
        <h1>Labyrinthe</h1>
        <p>Vous contrôlez un chat qui doit se déplacer dans un labyrinthe jusqu’à trouver la souris.</p>
    </header>
    <main>
        <form action="" method="POST">
            <button type="submit" name="reset" id="reset" value="1">Recommencer</button>
            <?php echo $tableHtml; ?>
            <div class="grid-controls">
                <button type="submit" name="move" value="up" id="arrow">
                    <img src="assets/images/haut.svg" alt="haut">
                </button>
                <button type="submit" name="move" value="left" id="arrow">
                    <img src="assets/images/gauche.svg" alt="gauche">
                </button>
                <button type="submit" name="move" value="down" id="arrow">
                    <img src="assets/images/bas.svg" alt="bas">
                </button>
                <button type="submit" name="move" value="right" id="arrow">
                    <img src="assets/images/droite.svg" alt="droite">
                </button>
            </div>
        </form>
    </main>
    <footer></footer>
</body>

</html>