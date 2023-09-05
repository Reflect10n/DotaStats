<?php
session_start();
require_once "connect.php";
$matchId = $_POST["matchId"];
$_SESSION['trySearch'] = true;
$match = mysqli_query($connect, "SELECT * FROM `DotaMatch` WHERE `Id` = '$matchId'");
$_SESSION['desiredMatchId'] = $matchId;
if (mysqli_num_rows($match) != 0)
{
	header("Location: index.php");
	exit;
}
$url ="https://api.opendota.com/api/matches/" . "$matchId" . "?api_key=YOUR-API-KEY";

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
    $_SESSION['desiredMatch'] = $response;
    include("addToBase.php");
	header("Location: index.php");
	exit;
}
?>