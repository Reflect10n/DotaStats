<?php

$decoded_json = json_decode($_SESSION['desiredMatch'], true);
$matchId = $decoded_json["match_id"];
$_SESSION['desiredMatchId'] = $matchId;

$duration = $decoded_json["duration"];
$radiantWin = $decoded_json["radiant_win"];
if ($radiantWin != 1)
{
    $radiantWin = 0;
}
$firstBlood = $decoded_json["first_blood_time"];
$radiantScore = $decoded_json["radiant_score"];
$direScore = $decoded_json["dire_score"];

mysqli_query($connect, "INSERT INTO `DotaMatch`(`Id`, `Duration`, `RadiantWin`, `FirstBlood`, `RadiantScore`, `DireScore`)
VALUES ($matchId, $duration, $radiantWin, $firstBlood, $radiantScore, $direScore);");
for($i=0;$i<10;$i++)
{
    $heroId = $decoded_json["players"][$i]['hero_id'];
    $kills = $decoded_json["players"][$i]['kills'];
    if ($kills == "")
    {
        $kills = 0;
    }
    $deaths = $decoded_json["players"][$i]['deaths'];
    if ($deaths == "")
    {
        $deaths = 0;
    }
    $assists = $decoded_json["players"][$i]['assists'];
    if ($assists == "")
    {
        $assists = 0;
    }
    $networth = $decoded_json["players"][$i]['net_worth'];
    if ($networth == "")
    {
        $networth = 0;
    }
    $lasthits = $decoded_json["players"][$i]['last_hits'];
    if ($lasthits == "")
    {
        $lasthits = 0;
    }
    $denies = $decoded_json["players"][$i]['denies'];
    if ($deaths == "")
    {
        $denies = 0;
    }
    $gpm = $decoded_json["players"][$i]['gold_per_min'];
    if ($gpm == "")
    {
        $gpm = 0;
    }
    $xpm = $decoded_json["players"][$i]['xp_per_min'];
    if ($xpm == "")
    {
        $xpm = 0;
    }
    $level = $decoded_json["players"][$i]['level'];
    $neutralitem = $decoded_json["players"][$i]['item_neutral'];
    if ($neutralitem == "")
    {
        $neutralitem = 0;
    }
    $side="";
    if ($i < 5)
    {
    $side = "radiant";
    }
    else
    {
        $side = "dire";
    }
    $obspurchased  = $decoded_json["players"][$i]['purchase']['ward_observer'];
    if ($obspurchased == "")
    {
        $obspurchased = 0;
    }
    $sentrypurchased  = $decoded_json["players"][$i]['purchase']['ward_sentry'];
    if ($sentrypurchased == "")
    {
        $sentrypurchased = 0;
    }
    $herodamage  = $decoded_json["players"][$i]['hero_damage'];
    if ($herodamage == "")
    {
        $herodamage = 0;
    }
    $herohealing  = $decoded_json["players"][$i]['hero_healing'];
    if ($herohealing == "")
    {
        $herohealing = 0;
    }
    $accountid = $decoded_json["players"][$i]['account_id'];
    if ($accountid == "")
    {
        $accountid = 0;
    }

mysqli_query($connect, "INSERT INTO `HeroMatch`(`HeroId`, `MatchId`, `Kills`, `Deaths`, `Assists`, `NetWorth`, `LastHits`, `Denies`, `GPM`, `XPM`,
`Level`, `NeutralItem`, `Side`, `TablePosition`, `ObsPurchased`, `SentryPurchased`, `HeroDamage`, `HeroHealing`, `AccountId`)
VALUES ($heroId, $matchId, $kills, $deaths, $assists, $networth, $lasthits, $denies, $gpm, $xpm, 
$level, $neutralitem, '$side', $i, $obspurchased, $sentrypurchased, $herodamage, $herohealing, $accountid);");

    $item0 = $decoded_json["players"][$i]['item_0'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $item0, $matchId, 0, 1);");

    $item1 = $decoded_json["players"][$i]['item_1'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $item1, $matchId, 0, 2);");

    $item2 = $decoded_json["players"][$i]['item_2'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $item2, $matchId, 0, 3);");

    $item3 = $decoded_json["players"][$i]['item_3'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $item3, $matchId, 0, 4);");

    $item4 = $decoded_json["players"][$i]['item_4'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $item4, $matchId, 0, 5);");

    $item5 = $decoded_json["players"][$i]['item_5'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $item5, $matchId, 0, 6);");


    $backpack0 = $decoded_json["players"][$i]['backpack_0'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $backpack0, $matchId, 1, 1);");

    $backpack1 = $decoded_json["players"][$i]['backpack_1'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $backpack1, $matchId, 1, 2);");

    $backpack2 = $decoded_json["players"][$i]['backpack_2'];
mysqli_query($connect, "INSERT INTO `HeroItems`(`HeroId`, `ItemId`, `MatchId`, `Backpack`, `Slot`)
VALUES ($heroId, $backpack2, $matchId, 1, 3);");
}
?>
