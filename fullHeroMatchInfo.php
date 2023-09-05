<?php 
session_start();
$desiredMatchId = $_SESSION['desiredMatchId'];
$match = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `DotaMatch`
WHERE `Id` = $desiredMatchId"));
$matchId = $match['Id'];
                    for ($i=0; $i<5; $i++)
                    {
                    $heroMatch = mysqli_fetch_assoc($matchDetails);
                    $heroMatchId = $heroMatch['HeroId'];
                    $heroInfo = mysqli_fetch_assoc(mysqli_query($connect,
                    "SELECT * FROM `Hero` WHERE `Id` = $heroMatchId"));
                    ?>
                <tr class="col-hints faction-radiant player--1">
                    <td class="cell-fill-image party-cell">
                        <div>
                            <i><?php echo $heroInfo['Name']?><i>
                        </div>
                        <div class="image-container image-container-hero image-container-icon image-container-overlay">
                                <img class="image-hero image-icon image-overlay"
                                src="<?php echo $heroInfo['Image']?>">
                                <span style="font-size: 18px;" class="overlay-text bottom right"><?php echo $heroMatch['Level']?></span>
                        </div>
                    </td>
                    <td class="tf-pl single-lines"><?php
                    if ($heroMatch['AccountId'] == 0)
                    {
                        echo "Anonymous";
                    }
                    else
                    {
                        $accountDetaisLink = $heroMatch['AccountId'];
                        $style="";
                        if ($heroMatch['Side'] == 'radiant')
                        {
                            $style="color: #A9CF54";
                        }
                        else
                        {
                            $style="color: #C23C2A";
                        }
                        ?>
                        <a style="<?php echo $style?>; text-decoration: underline;" href = "https://www.opendota.com/players/<?php echo $accountDetaisLink?>">
                        <?php
                     echo $heroMatch['AccountId'];
                    }
                    ?><br>
                    </td>
                    <td class="tf-r r-tab r-group-1 shown"><?php echo $heroMatch['Kills'];?>
                    </td>
                    <td class="tf-r r-tab r-group-1 cell-minor shown"><?php echo $heroMatch['Deaths'];?>
                    </td>
                    <td class="tf-r r-tab r-group-1 shown"><?php echo $heroMatch['Assists'];?>
                    </td>
                    <td class="tf-r r-tab r-group-1 color-stat-gold shown">
                        <img style="max-height: 12px" src="/gold.webp">
                        <acronym rel="tooltip" data-hasqtip="21" oldtitle="12.3k Total Gold Earned" title=""><?php echo "&nbsp" . $heroMatch['NetWorth'];?>
                        </acronym>
                    </td>
                    <td class="tf-r r-tab r-group-2 cell-minor"><?php echo $heroMatch['LastHits'];?>
                    </td>
                    <td class="tf-s r-tab r-group-2">/</td>
                    <td class="tf-pl r-tab r-group-2 cell-minor"><?php echo $heroMatch['Denies'];?>
                    </td>
                    <td class="tf-r r-tab r-group-2 cell-minor"><?php echo $heroMatch['GPM'];?>
                    </td>
                    <td class="tf-s r-tab r-group-2">/</td>
                    <td class="tf-pl r-tab r-group-2 cell-minor"><?php echo $heroMatch['XPM'];?>
                    </td>
                    <td class="tf-r r-tab r-group-3 cell-minor"><?php echo $heroMatch['HeroDamage'];?>
                    </td>
                    <td class="tf-r r-tab r-group-3 cell-minor">
                        <span><?php echo $heroMatch['HeroHealing'];?></span>
                    </td>
                    <td class="tf-c r-tab r-group-4" style="text-align: center">
                        <span class="color-item-observer-ward"><?php echo $heroMatch['ObsPurchased'];?>
                            <span class="hyphen">
                            </span>
                        </span>
                        <div class="slash">/
                        </div>
                        <span class="color-item-sentry-ward">
                             <span class="hyphen"><?php echo $heroMatch['SentryPurchased'];?>
                             </span>
                        </span>
                    </td>
                    <?php 
                    ?>
                    <td class="tf-pl r-tab r-group-4">
                        <div class="player-active-items">
                        <div class="player-inventory-items">
                            <?php
                                $currentHeroItems = mysqli_query($connect, "SELECT * FROM `HeroItems` WHERE `MatchId` = $matchId AND `HeroId` = $heroMatchId AND `Backpack` = 0 ORDER BY `Slot`;");
                                while($items = mysqli_fetch_assoc($currentHeroItems))
                                {
                                $item = $items['ItemId'];
                                $item1 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `Item` WHERE `Id` = $item")); 
                                ?>
                                <div class="match-item-with-time match-item-with-time-plusicon">
                                    <div class="image-container image-container-item image-container-plusicon image-container-overlay">
                                        <?php 
                                        if ($item1 !=0)
                                        {
                                            ?>
                                        <img class="image-item image-plusicon image-overlay"
                                        src="<?php echo $item1['Image']?>">
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                        <img class="image-item image-plusicon image-overlay"
                                        src="/void.png">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    </div>
                                    <?php
        $neutralItemId = $heroMatch['NeutralItem'];
        $neutralItem = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `Item` WHERE `Id` = $neutralItemId"))
        ?>
        <div class="player-neutral-item">
                                <div class="match-item-with-time match-item-with-time-roundicon">
                                    <div class="image-container image-container-item image-container-roundicon">
                                        <?php 
                                        if ($neutralItem != 0)
                                        {
                                            ?>
                                            <img class="image-item image-roundicon"  
                                            src="<?php echo $neutralItem['Image']?>">
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img class="image-item image-roundicon"  
                                            src="/void.png">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                        </div>
                </div>
                <div style="display: flex">
                <?php
                    $currentHeroBackpackItems = mysqli_query($connect, "SELECT * FROM `HeroItems` WHERE `MatchId` = $matchId AND `HeroId` = $heroMatchId AND `Backpack` = 1 ORDER BY `Slot`;");
                    while($items = mysqli_fetch_assoc($currentHeroBackpackItems))
                    { 
                        $item = $items['ItemId'];
                        $backpackItem1 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `Item` WHERE `Id` = $item"))
                ?>
                <div class="subtext">
                            <div class="match-item-with-time match-item-with-time-smallicon">
                                <div style="max-width: 38px" class="image-container image-container-item image-container-smallicon image-container-overlay">
                                <?php
                                if ($backpackItem1 !=0)
                                        {
                                            ?>
                                        <img class="image-item image-smallicon image-overlay"
                                     src="<?php echo $backpackItem1['Image']; ?>">
                                    <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <img class="image-item image-plusicon image-overlay"
                                            src="/void.png">
                                            <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                        ?>
                </div>
            </td>
        </tr>
        <?php
            }
        ?>