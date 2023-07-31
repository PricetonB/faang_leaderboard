<?php include "db.php" ?>
<?php

$getAllMembersQuery = "SELECT * FROM `members`";
$getAllMembers = mysqli_query($db, $getAllMembersQuery);
if ($getAllMembers) {
    $num_rows = $getAllMembers->num_rows;
    for ($i = 0; $i < $num_rows; $i++) {

        $row = mysqli_fetch_assoc($getAllMembers);
        $id = $row["id"];

        $data = json_decode(file_get_contents("https://faisal-leetcode-api.cyclic.app/" . $row["lc_name"]));

        $rank = $data->ranking;
        $easy = $data->easySolved;
        $medium = $data->mediumSolved;
        $hard = $data->hardSolved;
        $total = $data->totalSolved;
        $submissions = $data->submissionCalendar;

        $array = get_object_vars($submissions);
        $unixSubs = array();
        foreach ($array as $key => $value) {
            $unixSubs[] = array(date('Y-m-d', $key), $value);
        }
        $unixSubs = array_merge(...$unixSubs);
        $finalSubs = array();
        $day = new DateTime('today');
        for ($j = 0; $j < 30; $j++) {
            $formatted = $day->format("Y-m-d");
            if (in_array($formatted, $unixSubs)) {
                $index = array_search($formatted, $unixSubs);
                array_unshift($finalSubs, $unixSubs[$index + 1]);
            } else {
                array_unshift($finalSubs, 0);
            }
            $day->modify('-1 day');
        }
        $finalSubs = implode(",", $finalSubs);

        $updateData = "UPDATE `members` SET `lc_rank` = '$rank', `easy` = '$easy', `medium` = '$medium', `hard` = '$hard', `total` = '$total', `heatmap` = '$finalSubs' WHERE `members`.`id` = $id";
        $updateDataResult = mysqli_query($db, $updateData);
    }
}

?>