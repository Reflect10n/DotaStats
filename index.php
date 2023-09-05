<?php 
require_once "connect.php";
session_start();
/* $decoded_json = json_decode($_SESSION['desiredMatch'], true);
echo '<pre>';
print_r($decoded_json);
foreach($decoded_json["result"]["players"] as $item)
{
    echo 'HeroId: ' . $item['hero_id'] .'<br />';
} */

$desiredMatchId = $_SESSION['desiredMatchId'];
$matchId="";
$checkMatchDb =mysqli_query($connect, "SELECT * FROM `DotaMatch` WHERE `Id` = '$desiredMatchId'");
if (mysqli_num_rows($checkMatchDb) != 0)
{
$match = mysqli_fetch_assoc($checkMatchDb);
$matchId = $match['Id'];
$matchDetails = mysqli_query($connect, "SELECT * FROM `HeroMatch` WHERE `MatchId` = $matchId ORDER BY `TablePosition`");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <link rel="icon" href="/dota2icon.png" type="image/x-icon">
    <title>Dota 2 — Match Details</title>
</head>
<body>
    <h1 style="text-align: center; color: red;">
        Dota 2 — Match Details
    </h1>
    <form method="POST" action="/getMatchDetails.php">
    <div class = "search_match">
        <input style="border-radius: 10px; outline:none; border: none; padding-left: 10px; padding-top: 10px; padding-bottom: 10px" type="text" name="matchId" placeholder="Введите id матча">
        <input class ="find-btn" type="submit" value="Find">
    </div>
    </form>
    <?php 
    if ($matchId != "")
    {
        ?>
    <div class = "match_container">
    <div class = "match-link">
        <a href = "https://www.opendota.com/matches/<?php echo $matchId?>">
        <div class ="match-dotabuff">
            <?php echo "Match " . $matchId?>
        </div>
        </a>
    </div>
    <div class = "whoWin">
        <?php 
        $winner="";
        $style="";
        $whoWin = $match['RadiantWin'];
        if ($whoWin == 0)
        {
            $style="color: red;";
            $winner = "DIRE VICTORY";
        }
        else
        {
            $style="color: green;";
            $winner = "RADIANT VICTORY";
        }
        ?>
        <div style = "<?php echo $style?>">
            <?php echo $winner?>
        </div>
    </div>
    <div class = "match-short_info">
        <span class = "radiant-score">
            <?php echo $match['RadiantScore']; ?>
        </span>
        <span class = "match-duration">
            <?php
            $minutes = intdiv($match['Duration'], 60);
            $seconds = $match['Duration'] - $minutes * 60;
            if ($seconds <10)
            {
             echo "$minutes:" . "0$seconds";
            }
            else
            {
                echo "$minutes:" . "$seconds";
            } 
            ?>
        </span>
        <span class = "dire-score">
            <?php echo $match['DireScore']; ?>
        </span>
    </div>
    <div style="margin-top: 20px">
    </div>
    <header class = "radiant_header team_header" style="vertical-align: middle">The Radiant</header>
    <div class = "radiant_heroes table_match">
        <div style="width: 100%">
            <?php
            include("getTable.php");
            ?>
        </div>
    </div>
    <div style="margin-top: 20px">
    </div>
    <header class = "dire_header team_header" style="vertical-align: middle">The Dire</header>
    <div class = "dire_heroes table_match">
        <div style="width: 100%">
            <?php
            include("getTable.php");
            ?>
        </div>
    </div>
    </div>
    <?php
    }
    else if ($_SESSION['trySearch'])
    {
    ?>
        <h1 style="text-align: center; margin-top: 20px">
        Match not found
        </h1>
    <?php
    }
    $_SESSION['trySearch']=false;
    ?>
</body>
</html>