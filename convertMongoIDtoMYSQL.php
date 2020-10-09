<?php
include_once($DBFilePath); // Include your DB connection
include_once ("inc.config.php"); 

//64bits conversion function
function get64BitNumber($str)
{

     return gmp_strval(gmp_init(substr(md5($str), 0, 16), 16), 10);

}

//Table Select Ids
//$connectionVariable from include connect file
$select_id ="SELECT $idColumnName FROM $tableName";
$resultc = mysqli_query($connectionVariable,$select_id);

while ($row = mysqli_fetch_assoc($resultc)){
    
//Id Column Names
$id1 = $row[$idColumnName];

//Converting to 64bit number format
$idc = get64BitNumber($id1);



//convert the 64bits format to 32bits
$idc32_1 = gmp_and("0xffffffff", "$idc");


// ** if you want you can convert to less bits for lesser big Ids **


//Update ID on DB Table
$update_id ="UPDATE $tableName SET $idColumnName = '$idc32_1' WHERE $idColumnName = '$id1'";
$resultadd = mysqli_query($connectionVariable,$update_id);

}

//Success or Error Message
if($resultadd){ 
    echo "<p style='color:green;margin-bottom:10px;'>Successfully Converted!</p>";

    //Table With Data Fetching
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Not Converted</th>";
    echo "<th>Converted</th>";
    echo "<th>32bit</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>".$id1."</td>";
    echo "<td>".$idc."</td>";
    echo "<td>".$idc32_1."</td>";
    echo "</tr>";
    echo "</table>";

}else{

    echo "<p style='color:red;'>We couldn't convert the IDs</p>";

}

// Repeat this for each Table

?>