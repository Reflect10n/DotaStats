<?php
session_start();
require_once "connect.php";
$matchId = $_POST["matchId"];
$url ="https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key=FCD71934CC76B6BB024C45C59C1717B2&language=en_us&format=JSON";

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
    $decodedHero_json = json_decode($response, true);
    ?>
    <p>
        <?php
        echo '<pre>';
        print_r($decodedHero_json);
        foreach($decodedHero_json["result"]["heroes"] as $heroInfo)
        {
            $heroName = $heroInfo["localized_name"];
            $heroId = $heroInfo["id"];

            mysqli_query($connect, "INSERT INTO `Hero`(`Id`, `Name`) VALUES ('$heroId', '$heroName')");
        }
        ?>
</p>
<?php
}
?>