<?php
/**
 * Template Name: View Approval
 *
 * Description: A custom page template for displaying all logs
 *
 * @package Poseidon
 */

if (!is_user_logged_in()) { auth_redirect(); }

get_header();
//Reference External Methods
get_template_part('func/view', 'user');
get_template_part('func/view', 'venue');
get_template_part('func/table', 'headers');
monthsInputScript(); //listner for manual ?>

<script>
    //take user input from #monthsInput field and append it to the Go Link
    $(document).ready(function() {
    $('.appBtn').change(function() {
        alert("");
    // var baseURL = $('a.go').attr('href');
    // var searchTerm = $('#monthsInput').val();
    // var newurl = baseURL + searchTerm;

    //   $('a.go').attr('href', newurl);
    });
});
</script>
	<section id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">
			<?php
      //Show Logged in User
      $current_user = wp_get_current_user();
			$current_userID = get_current_user_id();
			$display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

      if ( current_user_can('administrator') )
      {
            //Get venue ID from Hyplerlink
            $venueID = htmlspecialchars($_GET['ID']);
            $groupBy = htmlspecialchars($_GET['G']);

            //Filters
            ?>
            <div class="col-lg-6 input-group filter">
            <?
            //Search Button Filters - sets number in URL for date calc
             echo "<a href='/approval/?ID=".$venueID."&amp;G=L'class='btn btn-primary' role='button'>
             List</a>";

             echo "<a href='/approval/?ID=".$venueID."&amp;G=V'class='btn btn-primary' role='button'>
             Venue</a>";

             echo "<a href='/approval/?ID=".$venueID."&amp;G=U'class='btn btn-primary' role='button'>
             User</a>";
             ?>
             </div>
             <div class="col-lg-6 input-group filter 2">
                <?approvalFilter($venueID, $groupBy);?>
             </div>


             <?

            //Get search period from url
            //TODO search input to be added
             $searchPeriod = htmlspecialchars($_GET['P']);
             $approvalState = htmlspecialchars($_GET['A']);

             if($searchPeriod == NULL)
             {
                 //default view. 1= 1 month
                 $searchPeriod = 12;
             }
             $endDate = date('Y-m-d');
             $startDate = date('Y-m-d', strtotime("-$searchPeriod months"));

             if ($groupBy == 'L' AND $approvalState != 'napp' OR $groupBy == NULL OR $approvalState != 'napp')
             {//Just List, no Grouping

             if($venueID != null)
             {echo "venueID: ".$venueID;
               ?>

              <div id="view_approval">

              <h2>For Approval 3</h2>
               <br/>

               <?php $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE ApprovedBy IS NULL");?>

                <h4>Total Hours: <?php echo $total_hrs ?></h4>

                <table class="table table-striped sortable">
                  <thead class="thead-inverse">
                  <tr>
                      <th>Name</th>
                      <th>Hours</th>
                      <th>Submitted</th>
                      <!--<th>Venue</th>-->
                      <th>Description</th>
                      <th></th>
                      <th></th>
                    </tr>
                    </thead>

                             <?php
                  $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog");
                   //$user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog OrderBy dateWorked Desc");
                  foreach ( $user_row as $user_row )
                  {
                      //Use user ID's to fetch User names.
                      $user = get_user_by( 'ID', $user_row->UserId );
                      $approver  = get_user_by( 'ID', $user_row->ApprovedBy );

                      //Only Show Appreoved Rows
                      if ($user_row->ApprovedBy == NULL)
                          {
                              echo "<tr>";
                              echo "<td>";
                              echo $user->first_name." ".$user->last_name."<br/>";
                              echo get_avatar( $user_row->UserId, 32 );
                              echo "</td>";
                              //echo "<td>".$user->first_name." ".$user->last_name."</td>";

                              echo "<td>".$user_row->Hours."</td>";
                              echo "<td>".date('jS M', strtotime($user_row->Submitted))."</td>";
                          $venueName = $wpdb->get_var( "SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

                          // echo "<td>".$venueName."</td>";
                              echo "<td><strong>".$venueName."</strong></br>".$user_row->Description."</td>";

                                          echo "<td><input type='button' text='Approve' class='btn approve_btn appBtn' value='". $user_row->Id."'/></td>";

                              echo "</tr>";
                      };// End Approval If
                  }
              ?>
                </table>

                </div>

             <?
           }
    }
      if ($groupBy == 'L' AND $approvalState == 'napp' OR $groupBy == NULL )
                 {//Just List, no Grouping ?>

      <div id="view_not_approved">

        <h2>For Approval 2</h2>
         <br/>

         <?php $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE ApprovedBy IS NULL");?>

          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Hours</th>
                <th>Submitted</th>
                <!--<th>Venue</th>-->
                <th>Description</th>
                <th></th>
                <th></th>
              </tr>
              </thead>

                       <?php
            $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog");
             //$user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog OrderBy dateWorked Desc");
            foreach ( $user_row as $user_row )
            {
                //Use user ID's to fetch User names.
                $user = get_user_by( 'ID', $user_row->UserId );
                $approver  = get_user_by( 'ID', $user_row->ApprovedBy );

                //Only Show Appreoved Rows
                if ($user_row->ApprovedBy != NULL)
                    {
                        echo "<tr>";
                        echo "<td>";
                        echo $user->first_name." ".$user->last_name."<br/>";
                        echo get_avatar( $user_row->UserId, 32 );
                        echo "</td>";
                        //echo "<td>".$user->first_name." ".$user->last_name."</td>";

                        echo "<td>".$user_row->Hours."</td>";
                        echo "<td>".date('jS M', strtotime($user_row->Submitted))."</td>";
                    $venueName = $wpdb->get_var( "SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

                    // echo "<td>".$venueName."</td>";
                        echo "<td><strong>".$venueName."</strong></br>".$user_row->Description."</td>";

                                    echo "<td><input type='button' text='Approve' class='btn approve_btn appBtn' value='". $user_row->Id."'/></td>";

                        echo "</tr>";
                };// End Approval If
            }
        ?>

          </table>

      </div>
<?}

                if ($groupBy == U)
                {
                //Group By Venue?>
                <div id="view_all_venues_by_user">
               <?php
               //Iterate Venue's
                if($venueID != NULL)
                {
                    //Search for specific
                  $venue_row = $wpdb->get_results( "SELECT * FROM hrs_hrsvenue WHERE Id=$venueID");

                }
                else
                {
                    //Search for all Venues
                   $venue_row = $wpdb->get_results( "SELECT * FROM hrs_hrsvenue");

                }

                foreach ( $venue_row as $venue_row )
                {
                    $search_venueID = $venue_row->Id;

                    //Show Venue Name
                    $search_venue = $wpdb->get_var( "SELECT name FROM hrs_hrsvenue WHERE Id = '$search_venueID'");
	                    ?>
	                    <h2>Venue: <?php echo $search_venue ?></h2>
	                    <h4>Grouped by User</h4>
	                    <br/>
                      <?php  $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue = $search_venueID");
                        ?>
                    	<h4>Total Hours: <?php echo $total_hrs ?></h4>
                    	<hr/>
                    <?

                    //Iterate Users
                     $row = $wpdb->get_results( "SELECT DISTINCT UserId FROM hrs_hrslog Where Venue = $search_venueID");
                    foreach ( $row as $row )
            	    {
            	         $search_userID = $row->UserId;

                         $search_user = get_user_by( 'ID', $search_userID );
                         $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ;


                         // $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID AND Venue=$search_venueID AND dateWorked Between '$startDate' And '$endDate'");


    $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID AND Venue=$search_venueID ");

    if($approvalState == 'app' OR $approvalState == 'napp')
    { //override total hours is App filter unsused or all
        if($approvalState == 'app'){$searchApp = "NOT NULL";};
        if($approvalState == 'napp'){$searchApp = " NULL";};
        $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID AND Venue=$search_venueID AND ApprovedBy IS $searchApp");
    }
    //Show User name and total hours
    echo "<h4>".get_avatar( $search_userID, 32 )." ".$search_name." (".$total_hrs.")</h4>";

?>
<table class="table table-striped sortable">
    <thead class="thead-inverse">
       <tr>
        <th>Hours</th>
        <th>Submitted</th>
   <? if($approvalState == 'all' OR $approvalState == 'app' OR $approvalState == NULL)
   {    ?>
        <th>App'd</th>
        <th>Approved By</th>
        <th>Approved At</th>
        <? }
        else { echo "<th>Description</th><th></th>";}
        ?>
      </tr>
      </thead>
      <?
      //Iterate each User

        $approvalState= htmlspecialchars($_GET['A']);


        $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog WHERE UserId = $search_userID AND Venue = $search_venueID ");

        if($approvalState == 'app' OR $approvalState == 'napp')
        {
            if($approvalState == 'app'){$searchApp = "NOT NULL";};
            if($approvalState == 'napp'){$searchApp = " NULL";};

            $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog WHERE UserId = $search_userID AND Venue = $search_venueID AND ApprovedBy IS $searchApp");
        }

                            //TODO 2nd look doesnt work with date bit
//$user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog WHERE UserId = $search_userID AND Venue = $search_venueID AND dateWorked Between '$startDate' And '$endDate' ORDER By dateWorked Desc");

                              foreach ( $user_row as $user_row )
                                {

                                //Use user ID's to fetch User names.
                                $user = get_user_by( 'ID', $user_row->UserId );
                                //echo "user".$user;
                                $approver  = get_user_by( 'ID', $user_row->ApprovedBy );

                                echo "<tr>";

                                echo "<td>".$user_row->Hours."</td>";
                                echo "<td>".date('jS M y', strtotime($user_row->dateWorked))."</td>";

                               if($approvalState == 'all' OR $approvalState == 'app'  OR $approvalState == NULL)
                               {
                                    echo "<td>";
                                    if ($user_row->ApprovedBy == NULL)
                                    {
                                      echo "<input type='checkbox' />";
                                    }
                                    else
                                    {
                                        echo "<input type='checkbox' checked />";
                                     }
                                    echo "</td>";
                                    echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
                                if ($user_row->ApprovedAt == !NULL)
                                    {

                                        echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
                                    }
                                    else
                                    {
                                        echo "<td></td>";
                                    }
                               }
                               else
                                    {
                            echo "<td>".$user_row->Description."</td>";
                            echo "<td><input type='button' text='Approve' class='btn approve_btn appBtn' value='". $user_row->Id."'/></td>";
                                        }
                                echo "</tr>";
                            }
                            //end user loop
                            ?>
                        </table><br/><br/>
                  <?  }//end users loop
                    ?>

            <?  } //end outer venue loop
            ?>
										</div> <!-- All Venue Div-->

              <?  }
                if ($groupBy == V)
                {//Display normal list ( groupBy="L")
                ?>
                     <div id="view_all_venues">
                     <hr>
                   <?php
                   $venue_row = $wpdb->get_results( "SELECT * FROM hrs_hrsvenue");
                    foreach ( $venue_row as $venue_row )
		                    {
		                        $search_venueID = $venue_row->Id;

		                        $search_venue = $wpdb->get_var( "SELECT name FROM hrs_hrsvenue WHERE Id = '$search_venueID'");
				                    ?>
				                    <h2>Venue: <?php echo $search_venue ?></h2>
				                    <br/>
			                      <?php
			                      $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue = $search_venueID");

                                if($approvalState == 'app' OR $approvalState == 'napp')
                                { //override total hours is App filter unsused or all
                                    if($approvalState == 'app'){$searchApp = "NOT NULL";};
                                    if($approvalState == 'napp'){$searchApp = " NULL";};
                                    $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue=$search_venueID AND ApprovedBy IS $searchApp");
                                }

?>
          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Hours</th>
                <th>Submitted</th>
              <? if($approvalState == 'all' OR $approvalState == 'app' OR $approvalState == NULL)
                 {    ?>
            <th>App'd</th>
            <th>Approved By</th>
            <th>Approved At</th>
            <? }
            else
            {
                echo "<th>Description</td>";
                echo "<th></td>";
            }
            ?>
                </tr>
                </thead>
                  <?php

			                        $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog WHERE Venue = '$search_venueID'");

                               if($approvalState == 'app' OR $approvalState == 'napp')
                                {
                                    if($approvalState == 'app'){$searchApp = "NOT NULL";};
                                    if($approvalState == 'napp'){$searchApp = " NULL";};

                                    $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog WHERE Venue = $search_venueID AND ApprovedBy IS $searchApp");
                                }

			                        foreach ( $user_row as $user_row )
			                        {
			                            //Use user ID's to fetch User names.
		                            $user = get_user_by( 'ID', $user_row->UserId );
		                            $approver  = get_user_by( 'ID', $user_row->ApprovedBy );

		                            echo "<tr>";
			                            echo "<td>".$user->first_name." ".$user->last_name."</td>";
			                            echo "<td>".$user_row->Hours."</td>";
			                            echo "<td>".date('jS M', strtotime($user_row->dateWorked))."</td>";

			                           if($approvalState == 'all' OR $approvalState == 'app'  OR $approvalState == NULL)
                                       {
                                            echo "<td>";
                                            if ($user_row->ApprovedBy == NULL)
                                            {
                                              echo "<input type='checkbox' />";
                                            }
                                            else
                                            {
                                                echo "<input type='checkbox' checked />";
                                             }
                                            echo "</td>";
                                            echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
                                        if ($user_row->ApprovedAt == !NULL)
                                            {

                                                echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
                                            }else
                                            {echo "<td></td>";}


                                       }
                                       else
                {
            echo "<td>".$user_row->Description."</td>";
            echo "<td><input type='button' text='Approve' class='btn approve_btn appBtn' value='". $user_row->Id."'/></td>";


                                            }
        		                            echo "</tr>";
        		                        	}	//end user details loop
        		                        	?>

		                  			</table>
		                <?  } //end outer venue loop
		                ?>
						</div> <!-- All Venue Div -->
							<? } //end Show all Venues
								?>



    <?php }
        else
        {
        echo "<p class='error'>You must be an Administrator to view this page</p>";
        }//Close Logged and Admin In Check
        ?>
		</main><!—- #main —>
	</section><!—- #primary —>
<?php get_footer(); ?>
