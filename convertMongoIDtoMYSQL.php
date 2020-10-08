<?php

include_once ("path/to/connect.php"); // Include your DB connection

//64bits conversion function
function get64BitNumber($str)
{

     return gmp_strval(gmp_init(substr(md5($str), 0, 16), 16), 10);

}

//Table Select Ids
//$connectionVariable from include connect file
$convert_id = "select id_column1,id_column2 from table";
$resultc = mysqli_query($connectionVariable,$convert_id);


while ($row = mysqli_fetch_assoc($resultc)){
    
//Id Column Names
$id1 = $row["id"];
$id1_2 = $row["anotherId"];

//Converting to 64bit number format
$idc = get64BitNumber($id1);
$idc1_2 = get64BitNumber($id1_2);


//convert the 64bits format to 32bits
$idc32_1 = gmp_and("0xffffffff", "$idc");
$idc32_1_2 = gmp_and("0xffffffff", "$idc1_2");

// ** if you want you can convert to less bits for lesser big Ids **


//Update ID on bank
$update_id ="UPDATE table SET id_column = '$idc32_1' WHERE id_column = '$id1'";
$resultadd = mysqli_query($connectionVariable,$update_id);

}

//Success or Error Message
if($resultadd){ 
    echo "<p style='color:green;'>Successfully Converted!</p>";

}else{

    echo "<p style='color:red;'>We couldn't convert the IDs</p>";

}

// Repeat this for each Table

?>