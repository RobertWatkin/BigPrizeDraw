<?php
$sql = "SELECT * FROM `tblcompetitions`";
$results = mysqli_query($conn, $sql);


if (mysqli_num_rows($results) > 0) {


    $dyn_table = '
    <div class="card-columns" style="display: flex; flex-wrap: wrap; justify-content: center">';
    while ($row = mysqli_fetch_array($results)){
        //$datetime1 = new DateTime();
        $datetime2 = new DateTime($row['drawDate']);
        //$interval = $datetime1->diff($datetime2);

        $dyn_table .= '
        <div class="card card-default" style="flex: 0 1 400px; margin: 10px; border: 1px solid #505050; box-shadow: 10px 10px 5px grey;">
            <img class="card-img-top" src="'.$row['image'].'" alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title" style="float: left">'.$row['title'].'</h5>
                <form method="post">
                    <button  type="submit" name="select" value="'.$row['competitionID'].'" onclick="compSelected()" class="btn btn-success" style="float: right;">Select</button>
                </form>
                <br><br>
                <b class="mb-2 "style="float: left;">
                '.$datetime2->format('l jS F Y')
                .'</b>
                
            </div>
        </div>
            ';
    }
    $dyn_table .= '</div>';
} else {
    $dyn_table = "
    <div class='text-center'>
    <h2 class='mt-5'>There are currently no competitions</h2>   
    <h4 class='mb-5'>To create a new competition click on the button above and continue with the form</h4>
    </div>";
}



?>

        