<?php include "db.php" ?>
<?php

    if(isset($_POST["lc_name"])){
        $discord_name = mysqli_real_escape_string($db, $_POST["discord_name"]);
        $lc_name =      mysqli_real_escape_string($db, $_POST["lc_name"]);
        $lc_rank =      mysqli_real_escape_string($db, $_POST["lc_rank"]);
        $easy =         mysqli_real_escape_string($db, $_POST["easy"]);
        $medium =       mysqli_real_escape_string($db, $_POST["medium"]);
        $hard =         mysqli_real_escape_string($db, $_POST["hard"]);
        $total =        mysqli_real_escape_string($db, $_POST["total"]);
        $heatmap =      mysqli_real_escape_string($db, $_POST["heatmap"]);

        $insertQuery = "INSERT INTO `members` (`id`, `discord_name`, `lc_name`, `lc_rank`, `easy`, `medium`, `hard`, `total`, `heatmap`, `created_on`) VALUES (NULL, '$discord_name', '$lc_name', '$lc_rank', '$easy', '$medium', '$hard', '$total', '$heatmap', current_timestamp())";
        $insertResult = mysqli_query($db, $insertQuery);
        if($insertQuery){
            echo "success";
        }

    }    

?>