<html>
    <head>
        <title>Middle</title>
    </head>
    <body>
        <?php 
            // establish a database connection to Oracle database.
            $username = 's3860867';
            $password = 'RMiT!2021'; //DO NOT enter your RMIT password
            $servername = 'talsprddb01.int.its.rmit.edu.au';
            $servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
            $connection = $servername."/".$servicename;

            $conn = oci_connect($username, $password, $connection);
            if(!$conn)
            {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            else
            {
                echo "<script>console.log(\"Successfully connected to CSAMPR1.ITS.RMIT.EDU.AU.\")</script>";
                // Testing a generic SELECT SQL 
                // This SQL will work even if you do not have any tables created on your database accoount.
                // 
                
                $name = $_POST['fname'];
                $name = explode(' ', $name);
                $fname = $name[0];
                $lname = $name[1]; 
                $address = $_POST['address'];
                $asuite = $_POST['asuite'];
                $suburb = $_POST['suburb'];
                $state = $_POST['state'];
                $postcode = $_POST['postcode'];

                if($asuite != null) {
                    $sql = "SELECT ELECTORATE FROM VOTERS_REGISTER WHERE FIRST_NAME = '$fname' AND LAST_NAME = '$lname' AND RESIDENTIAL_STREET = '$address' AND RESIDENTIAL_UNIT = '$asuite' AND RESIDENTIAL_SUBURB = '$suburb' AND RESIDENTIAL_STATE = '$state' AND RESIDENTIAL_POSTCODE = '$postcode'";
                } else {
                    $sql = "SELECT ELECTORATE FROM VOTERS_REGISTER WHERE FIRST_NAME = '$fname' AND LAST_NAME = '$lname' AND RESIDENTIAL_STREET = '$address' AND RESIDENTIAL_SUBURB = '$suburb' AND RESIDENTIAL_STATE = '$state' AND RESIDENTIAL_POSTCODE = '$postcode'";
                }
                $stid = oci_parse($conn, $sql);
                oci_execute($stid);
                $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
                if(!empty($row)) {
                    $electorate = $row['ELECTORATE'];
                    // echo "</br>$electorate</br>";
                    $Usql = "UPDATE VOTERS_REGISTER SET IS_VOTED = 'Y' WHERE FIRST_NAME = '$fname' AND LAST_NAME = '$lname' AND RESIDENTIAL_STREET = '$address' AND RESIDENTIAL_SUBURB = '$suburb' AND RESIDENTIAL_STATE = '$state' AND RESIDENTIAL_POSTCODE = '$postcode'";
                    $Ustid = oci_parse($conn, $Usql);
                    oci_execute($Ustid);
                }
                
                
                // $ncols = oci_num_fields($stid);
                // echo "</br>$ncols";
                // echo "</br>" . oci_num_rows($stid);
            }

            oci_free_statement($stid);
            oci_close($conn);
        ?>

        <?php 
            //get the state and division information and transfer to ballot
            class form{
                public function subform($sta, $elect){
                  $str = '<form id="role_information" action="ballotPaper.php" method="get" style="display:none">';
                  $str .= '<input type="text" name="state" value="' . $sta . '" /><br />' ;
                  $str .= '<input type="text" name="electorate" value="' . $elect . '" /><br />' ;
                  $str .='<input type="hidden" name="vote" value="vote" /></form>';
                  $str .= '<script>window.onload = function(){document.getElementById("role_information").submit();}</script>';
                  echo $str; exit;
                }
            }
            $form = new form();
            $a = $form->subform($state, $electorate);
            exit;
        ?>
        <script>
            location.href="ballotPaper.php";
        </script>
    </body>
</html>