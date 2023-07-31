<?php include "php/db.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div>
        <h1 id="main_heading" >from nothing to FAANG Leaderboard</h1>
    </div>
    <nav>
        <!-- <a href="">Global Ranking</a>
        <a href="?ts=1">Total Solved</a>
        <a href="?ar=1">Acceptance Rate</a> -->
        <a>Ranked on the basis of Leetcode Global Rank</a>
    </nav>
    <div class="tiles_wrapper">
        <table class="tiles">
            <tr class="tr_head">
                <td class="td_head">#</td>
                <td class="td_head">Discord Name</td>
                <td class="td_head">LC username</td>
                <td class="td_head">LC #</td>
                <td class="td_head">Easy</td>
                <td class="td_head">Medium</td>
                <td class="td_head">Hard</td>
                <td class="td_head">Total Solved</td>
                <td class="td_head">30 days heatmap</td>
            </tr>
            <?php

                $fetchMembersQuery = "SELECT * FROM `members` ORDER BY lc_rank ASC";
                $fetchMembers = mysqli_query($db, $fetchMembersQuery);
                if($fetchMembers){
                    $num_rows = $fetchMembers -> num_rows;
                    for($i = 0; $i < $num_rows; $i++){
                        $row = mysqli_fetch_assoc($fetchMembers);
                        echo "<tr>";
                        echo "<td>" . ($i + 1) . "</td>";
                        echo "<td>" . $row["discord_name"] . "</td>";
                        echo "<td>" . $row["lc_name"] . "</td>";
                        echo "<td>" . $row["lc_rank"] . "</td>";
                        echo "<td>" . $row["easy"] . "</td>";
                        echo "<td>" . $row["medium"] . "</td>";
                        echo "<td>" . $row["hard"] . "</td>";
                        echo "<td>" . $row["total"] . "</td>";
                        echo "<td class='td_heatmap'>";
                        echo '<svg height="25" width="268px">';
                        $heatmap = explode(",", $row["heatmap"]);
                        $counter = 0;
                        for($j = 0; $j < count($heatmap); $j++){
                            echo '<rect y="0" x="'. $counter .'" rx="2" ry="2" width="7" height="25" style="fill:rgb(0, 255, 0); opacity:'. ($heatmap[$j] * 0.1 )  .' " />';
                            $counter += 9;
                        }
                        echo "</svg>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }

            ?>
        </table>
    </div>
    <button id="new_mem_btn">New Member</button>
    <div id="floating_form" class="floating_form">
        <input type="text" id="disc_name_inp" placeholder="Discord Name">
        <input type="text" id="lc_name_inp" placeholder="Leetcode username">
        <button onclick="postRequest()">Submit</button>
        <br>
        <p>To change or remove existing information, please ping the mods</p>
    </div>
    <footer>
        <p>Made with ❤️ by <a href="https://instagram.com/classicaf">Yash Kolambekar</a></p>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="js/index.js"></script>
</html>