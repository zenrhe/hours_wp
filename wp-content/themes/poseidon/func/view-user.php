
<?php
function monthsInputScript()
{
    ?>
	<script>
	    //change search results to given month
	    //take user input from #monthsInput field and append it to the Go Link
	    $(document).ready(function() {
		    $('#monthsInput').change(function() {

		    var baseURL = $('a.go').attr('href');
		    var searchTerm = $('#monthsInput').val();
		    var newurl = baseURL + searchTerm;

		    $('a.go').attr('href', newurl);
	    });
	  });
	</script>
	<?php
}
function setSearchUserID($ID, $current_userID)
{
    //Set search ID if allowed, fall back to logged in/current User
    if ($ID == null) {
        //If no ID provided, show logged in users hours
        $search_userID =  $current_userID;
    } else {		//Current user viewing own hours
        if ($ID == $current_userID) {
            $search_userID =  $current_userID;
        } else { //User trying to view others hours

            //Check Allowed
            if (current_user_can('administrator')) {
                //Allow to view the seleceted ID info
                $search_userID = $ID;

                if ($ID == 'all') {
                    //Admin viewing All Users
                    $search_userID = 'all';
                }
            } else {
                // User does not have permission, show only their own hours
                echo "<p class='error'>Admin Access Required - only showing your hours</p>";
                $search_userID =  $current_userID;
            }
        }
    }
    return $search_userID;
}
function monthFilter($userID, $venueID, $approvalState, $groupBy, $searchPeriod)
{
    //Display the Filter Selection for Dates

    //Search Button Filters - sets P (period) Post value in URL for date calc
    //IF this filter set, add activeFilter class to css

    echo "<div class='col-lg-6 input-group filter'>";
    $url =  "?UID=".$userID."&amp;?VID=".$venueID."&amp;A=".$approvalState."&amp;G=".$groupBy."&amp;P=";

    //echo $url;
    //setting P = Period value
    if ($searchPeriod == '1') {
        echo "<a href='".$url."1'class='btn btn-primary activeFilter' role='button'>
			Month</a>";
    } else {
        echo "<a href='".$url."1'class='btn btn-primary' role='button'>
 			 Month</a>";
    }
    if ($searchPeriod == '3') {
        echo "<a href='".$url."3'class='btn btn-primary activeFilter' role='button'>
				3 Months</a>";
    } else {
        echo "<a href='".$url."3'class='btn btn-primary' role='button'>
 			 3 Months</a>";
    }
    if ($searchPeriod == '6') {
        echo "<a href='".$url."6'class='btn btn-primary activeFilter' role='button'>
			6 Months</a>";
    } else {
        echo "<a href='".$url."6'class='btn btn-primary' role='button'>
			 6 Months</a>";
    } ?>
			 <!--Input Custom Month Period -->
			<input type="text" class="form-control" placeholder="Number of Months" id='monthsInput'>
			 <span class="input-group-btn">
					<?php //Class Go being targeted to append #monthsInput value for P - requires script
                            echo "<a href='".$url."'class='go btn btn-secondary' role='button'>Go</a>"; ?>
				</span>
				<?php echo "</div>";
}
function getUserHours($search_userID, $search_venueID, $searchPeriod, $approvalState)
{
    global $wpdb;
    $baseSelect = "SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = '". $search_userID."'";

    if ($search_venueID != null) {
        $venue = " AND Venue = '". $search_venueID."'";
    } else {
        $venue ="";
    }
    //Add Date Filter restriction
    if ($searchPeriod == null) {
        $searchPeriod = 12; //default view
    }
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime("-$searchPeriod months"));
    $dateRange = " AND dateWorked Between '$startDate' And '$endDate'";

    //Add Approval Filter restriction
    $approval = "";
    if ($approvalState == 'app') {
        $approval = " AND ApprovedBy IS NOT NULL";
    };
    if ($approvalState == 'napp') {
        $approval = " AND ApprovedBy IS NULL";
    };

    $query = $baseSelect.$venue.$dateRange.$approval;
    $total_hrs = $wpdb->get_var("$query");

    return $total_hrs;
}
function getUserTable($search_userID, $search_venueID, $searchPeriod, $approvalState)
{
    global $wpdb;

    $baseSelect = "SELECT * FROM hrs_hrslog";
    $user = " WHERE UserId = $search_userID";
    $venue1 = " WHERE Venue = $search_venueID";
    $venue2 = " AND Venue = $search_venueID"; //when no Where from User

    //Add Approval Filter restriction
    $approval = "";
    if ($approvalState == 'app') {
        $approval = " AND ApprovedBy IS NOT NULL";
    };
    if ($approvalState == 'napp') {
        $approval = " AND ApprovedBy IS NULL";
    };

    //Date Restriction
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime("-$searchPeriod months"));
    $dateRange = " AND dateWorked Between '$startDate' And '$endDate'";

    if ($search_userID != null and $search_venueID == null) {//User
        $query = $baseSelect.$user.$approval.$dateRange;
        $user_row = $wpdb->get_results("$query");
    } elseif ($search_userID == null and $search_venueID != null) {//Venue
        $query = $baseSelect.$venue1.$approval.$dateRange;
        ;
        $user_row = $wpdb->get_results("$query");
    } else {//Venue and User
        $query = $baseSelect.$user.$venue2.$approval.$dateRange;
        ;
        $user_row = $wpdb->get_results("$query");
    }

    //TODO This to a row output method
    foreach ($user_row as $user_row) {

        //Use ID's to fetch names from other tables.
        $user = get_user_by('ID', $user_row->UserId);
        $approver  = get_user_by('ID', $user_row->ApprovedBy);
        $venueName = $wpdb->get_var("SELECT name FROM hrs_venue WHERE Id = $user_row->Venue ");
        echo "<tr>";

        if ($search_userID == null) {
            echo "<td>".$user->first_name." ".$user->last_name."</td>";
        }
        echo "<td>".$user_row->Hours."</td>";
        echo "<td>".date('jS M y', strtotime($user_row->dateWorked))."</td>";
        if ($search_venueID == null) {
            echo "<td>".$venueName."</td>";
        }

        //If Showing only Non Approved - Provide Approve Button
        if ($approvalState == 'napp') {
            $current_userID = get_current_user_id();
            if (current_user_can('administrator')) {
                //If Admin, Show details and Approve button
                echo "<td>".$user_row->Description."</td>";
                echo "<td><form action='". esc_url(admin_url('admin-post.php'))."' method='post'>";
                echo "<input type='hidden' name='userID' value='".$current_userID."'>";
                echo "<input type='hidden' name='rowID' value='".$user_row->Id."'>";
                echo "<input type='hidden' name= 'action' value='approve_Hours_Form'>";
                echo "<button class='btn approve_btn' name='submit' type='submit' >
					 App
					</button>";
                echo "</form></td>";
            }
        } else {
            if ($user_row->ApprovedBy == null) {
                //No Approver Details
                echo "<td><input type='checkbox' /></td>";
                echo "<td></td>";
                echo "<td></td>";
            } else {
                //Show Approver Details
                echo "<td><input type='checkbox' checked /></td>";
                echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
                echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
            }
        }
        echo "</tr>";
    } ?>
		</table>
		<?php
}

?>
