<?php
/**
 * Template Name: View Hours
 *
 * Description: Current Page for All table examples
 *
 * @package Poseidon
 */
if (!is_user_logged_in()) {
    auth_redirect();
}

get_header(); ?>

 <?php global $wpdb; ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

 			<?php while (have_posts()) : the_post();
            // Shows Any Content placed in the Wordpress Page
                get_template_part(‘template-parts/content’, ‘page’);
            endwhile; ?>

			<?php

            //Checked Logged In

            if (is_user_logged_in()) {
                //Show Logged in User Name
                $current_user = wp_get_current_user();
                $current_userID = get_current_user_id();
                $display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

                echo "Logged In User: ".$display_name;
            } else {
                //Show Login Link
                echo "You must be Logged In: <a href='/wp-login.php' title='Members Area Login' rel='home'>Login</a>";
            }
            ?>


<br/><br/>
        <?php

       if (current_user_can('administrator')) {

        //Echo results example
           // $user_row = $wpdb->get_results( "SELECT * FROM $wpdb->users");
           //     foreach ( $user_row as $user_row )
           // //     {
           //             echo "<tr>"
           //             echo "<td>".$user_row->user_nicename."</td>";
           //             echo "<tr>"
           //     }
           //?>

      <div id="view_all">

        <h2>All Hours Logged</h2>

            <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog"); ?>

          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
              <tr>
                <th>Name</th>
                <!--<th>Hours</th>-->
                <th>Submitted</th>
                <th>Desc</th>
                <th>Venue</th>
                <th>App'd</ht>
                <th>App'd By</th>
                <th>App'd At</th>
              </tr>
              </thead>
            <?php
            $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog ORDER BY Submitted");
           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               echo "<tr>";
               echo "<td>";
               echo $user->first_name." ".$user->last_name."<br/>";
               echo get_avatar($user_row->UserId, 32);
               echo "</td>";
               // echo "<td>".$user_row->Hours."</td>";
               echo "<td>";
               echo date('jS M', strtotime($user_row->Submitted));
               echo "</td>";
               echo "<td>";
               echo "<p><strong>".$user_row->Hours." Hours</strong></p>";
               echo substr($user_row->Description, 0, 50)."...</td>";
               echo "</td>";

               $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

               echo "<td>".$venueName."</td>";
               echo "<td>";
               if ($user_row->ApprovedBy == null) {
                   echo "<input type='checkbox' />";
               } else {
                   echo "<input type='checkbox' checked />";
               };
               echo "</td>";
               echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }
               echo "</tr>";
           } ?>
          </table>
      </div>
      <div id="view_logged_in">

        <h2>Your Hours <?php echo $current_user->user_firstname."<br/>"; ?></h2>
         <br/>
          <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $current_userID"); ?>
          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
              <tr>
                <th>Submitted</th>
                <th>Hours</th>
                <th>Venue</th>
                <!--<th>Desc</th>-->
                <th>App'd</th>
                <th>Approved By</th>
                <th>Approved At</th>
              </tr>
              </thead>
              <?php
                //$current_userID set earlier
                $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog WHERE UserId = $current_userID ");
           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);
               echo "<tr>";
               echo "<td>".date('jS M', strtotime($user_row->Submitted))."</td>";
               echo "<td>".$user_row->Hours."</td>";
               echo "<td>".$user_row->Venue."</td>";
               // echo "<td>".$user_row->Description."</td>";
               echo "<td>";
               if ($user_row->ApprovedBy == null) {
                   echo "<input type='checkbox' />";
               } else {
                   echo "<input type='checkbox' checked />";
               }
               echo "</td>";
               echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }

               echo "</tr>";
           } ?>

          </table>

      </div>
      <div id="view_by_user">
<?php
         //TODO will need to pass in selected ID
         $search_userID = 2;
           $search_user = get_user_by('ID', $search_userID);
           $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ; ?>
        <h2><?php echo  get_avatar($user_row->UserId, 32)."   ".$search_name."'s Hours"?> </h2>
         <br/>

          <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID"); ?>

          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
               <tr>
                <!--<th>Name</th>-->
                <th>Hours</th>
                <th>Submitted</th>
                <th>Venue</th>
                <th>App'd</th>
                <th>Approved By</th>
                <th>Approved At</th>
              </tr>
              </thead>

              <?php
                //$current_userID set earlier
                $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog WHERE UserId = $search_userID ");

           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               echo "<tr>";
               // echo "<td>".$user->first_name." ".$user->last_name."</td>";
               echo "<td>".$user_row->Hours."</td>";
               echo "<td>".date('jS M y', strtotime($user_row->Submitted))."</td>";
               $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

               echo "<td>".$venueName."</td>";
               echo "<td>";
               if ($user_row->ApprovedBy == null) {
                   echo "<input type='checkbox' />";
               } else {
                   echo "<input type='checkbox' checked />";
               }
               echo "</td>";
               echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }
               echo "</tr>";
           } ?>

          </table>
      </div>
      <div id="view_venue">

        <?php //TODO: need to feed in venue
        $search_venue = "Tilly Flat"; ?>

        <h2>Venue: <?php echo $search_venue ?></h2>
        <br/>
          <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue = '$search_venue'"); ?>

          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
            <tr>
                <th>Name</th>
            <th>Hours</th>
            <th>Submitted</th>
            <th>Venue</th>
            <th>Approved By</th>
            <th>Approved At</th>
            </tr>
            </thead>

              <?php

                $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog WHERE Venue = '$search_venue'");

           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               echo "<tr>";
               echo "<td>".$user->first_name." ".$user->last_name."</td>";
               echo "<td>".$user_row->Hours."</td>";
               echo "<td>".date('jS M', strtotime($user_row->Submitted))."</td>";

               $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

               echo "<td>".$venueName."</td>";
               echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }
               echo "</tr>";
           } ?>

          </table>

      </div>
      <div id="view_app_status">

        <h2>Approval Status</h2>
         <br/></br>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
             <tr>
                <th>Name</th>
                <th>Hours</th>
                <th>Submitted</th>
                <th>Venue</th>
                <th>Approved By</th>
                <th>Approved At</th>
                <th>Approved</th>
              </tr>
              </thead>

                       <?php
            $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog");
           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               echo "<tr>";
               echo "<td>".$user->first_name."</td>";
               //echo "<td>".$user->first_name." ".$user->last_name."</td>";

               echo "<td>".$user_row->Hours."</td>";
               echo "<td>".date('jS M y', strtotime($user_row->Submitted))."</td>";
               $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

               echo "<td>".$venueName."</td>";
               echo "<td>".$approver->first_name." "."</td>";
               // echo "<td>".$user_row->ApprovedBy." - ".$approver->first_name." ".$approver->last_name."</td>";

               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }
               echo "<td>";
               if ($user_row->ApprovedBy == null) {
                   echo "<input type='checkbox' />";
               //   echo "<input type='checkbox' />";
               } else {
                   echo "<input type='checkbox' checked />";
               };
               echo "</td>";
               echo "</tr>";
           } ?>

          </table>

      </div>
      <div id="view_approved">

        <h2>Approved</h2>
         <br/>

          <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE ApprovedBy IS NOT NULL"); ?>
          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Hours</th>
                <th>Submitted</th>
                <th>Venue</th>
                <th>Approved By</th>
                <th>Approved At</th>
              </tr>
              </thead>

                       <?php
            $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog");
           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               //Only Show Appreoved Rows
               if ($user_row->ApprovedBy == !null) {
                   echo "<tr>";
                   echo "<td>".$user->first_name."</td>";
                   //echo "<td>".$user->first_name." ".$user->last_name."</td>";

                   echo "<td>".$user_row->Hours."</td>";
                   echo "<td>".date('jS M y', strtotime($user_row->Submitted))."</td>";
                   $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

                   echo "<td>".$venueName."</td>";
                   echo "<td>".$approver->first_name." "."</td>";
                   // echo "<td>".$approver->first_name." ".$approver->last_name."</td>";

                   if ($user_row->ApprovedAt == !null) {
                       echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
                   } else {
                       echo "<td></td>";
                   }

                   echo "</tr>";
               };// End Approval If
           } ?>

          </table>

      </div>
      <div id="view_not_approved">

        <h2>For Approval</h2>
         <br/>

         <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE ApprovedBy IS NULL"); ?>

          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
            <tr>
                <th>Name</th>
                <th>Hours</th>
                <th>Submitted</th>
                <th>Venue</th>
                <th>Description</th>
              </tr>
              </thead>

                       <?php
            $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog");
           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               //Only Show Appreoved Rows
               if ($user_row->ApprovedBy == null) {
                   echo "<tr>";
                   echo "<td>";
                   echo $user->first_name." ".$user->last_name."<br/>";
                   echo get_avatar($user_row->UserId, 32);
                   echo "</td>";
                   //echo "<td>".$user->first_name." ".$user->last_name."</td>";

                   echo "<td>".$user_row->Hours."</td>";
                   echo "<td>".date('jS M', strtotime($user_row->Submitted))."</td>";
                   $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

                   echo "<td>".$venueName."</td>";
                   echo "<td><strong>".$venueName."</strong></br>".$user_row->Description."</td>";
                   echo "<td><input type='button' text='Approve' class='approve_btn' id='". $user_row->Id."'/></td>";
                   echo "</tr>";
               };// End Approval If
           } ?>

          </table>

      </div>
      <div id="view_user_list">

        <h2>Users</h2>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
              <tr>
              <th></th>
                <th>Name</th>
                <th>Hours</th>
              </tr>
              </thead>
            <?php
            $user_row = $wpdb->get_results("SELECT * FROM $wpdb->users");
           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               echo "<tr>";
               echo "<td>";
               echo get_avatar($user_row->ID, 32);
               echo "</td>";
               echo "<td>".$user_row->display_name."</td>" ; //TODO Make Hyperlink to page to show users hours
                    echo "<td>"."</td>"; //TODO use ueser ID to check hours table and sum on hours by that user
                echo "</tr>";
           } ?>
          </table>
      </div>
      <div id="view_venue_list">

        <h2>Venues</h2>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
              <tr>
                <th>Venue</th>
                <th>Hours</th>
              </tr>
              </thead>
            <?php
            $user_row = $wpdb->get_results("SELECT DISTINCT Venue FROM $wpdb->hrslog");
           foreach ($user_row as $user_row) {
               echo "<tr>";
               echo "<td>".$user_row->Venue."</td>" ;
               echo "</tr>";
           } ?>
          </table>
      </div>
      <div id="view_user_month">
        <?php
        //Get user ID from Hyplerlink
        $userID = htmlspecialchars($_GET['ID']);

           if ($userID == null) {
               //If no ID provided, then only show logged in users hours
               $search_userID =  $current_userID;
           } else {
               //TODO Add Admin Check , fallback to current user
               $search_userID = $userID;
           }

           $search_user = get_user_by('ID', $search_userID);
           $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ; ?>
        <h2><?php echo  get_avatar($search_userID, 32)."   ".$search_name."'s Hours"?> </h2>
         <br/>

        <?php
         //Current Month
         $month = date('m');
           $year = date('Y');

           $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID AND MONTH(dateWorked) = $month AND YEAR(dateWorked) = $year "); ?>

          <h4>Total Hours for <?php echo date(' M Y') ?> : <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
               <tr>
                <!--<th>Name</th>-->
                <th>Hours</th>
                <th>Submitted</th>
                <th>Venue</th>
                <th>App'd</th>
                <th>Approved By</th>
                <th>Approved At</th>
              </tr>
              </thead>

              <?php
                 $endDate = date('Y-m-d');
           $startDate = date('Y-m-d', strtotime('-3 months'));

           $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog WHERE UserId = $search_userID AND dateWorked Between '$startDate' And '$endDate' ORDER By dateWorked Desc");

           //Logs for Current Month
           $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog WHERE UserId = $search_userID AND MONTH(dateWorked) = $month AND YEAR(dateWorked) = $year ORDER By dateWorked Desc");


           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               echo "<tr>";
               // echo "<td>".$user->first_name." ".$user->last_name."</td>";
               echo "<td>".$user_row->Hours."</td>";
               echo "<td>".date('jS M y', strtotime($user_row->dateWorked))."</td>";

               $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

               echo "<td>".$venueName."</td>";

               echo "<td>";
               if ($user_row->ApprovedBy == null) {
                   echo "<input type='checkbox' />";
               } else {
                   echo "<input type='checkbox' checked />";
               }
               echo "</td>";
               echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }
               echo "</tr>";
           } ?>

          </table>
      </div>
      <div id="view_by_user">
        <?php
        //Get user ID from Hyplerlink
        $userID = htmlspecialchars($_GET['ID']);

           if ($userID == null) {
               //If no ID provided, then only show logged in users hours
               $search_userID =  $current_userID;
           } else {
               //TODO Add Admin Check , fallback to current user
               $search_userID = $userID;
           }
           $search_user = get_user_by('ID', $search_userID);
           $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ; ?>
        <h2><?php echo  get_avatar($search_userID, 32)."   ".$search_name."'s Hours"?> </h2>
         <br/>

          <?php $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID"); ?>

          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <table class="table table-striped sortable">
            <thead class="thead-inverse">
               <tr>
                <!--<th>Name</th>-->
                <th>Hours</th>
                <th>Submitted</th>
                <th>Venue</th>
                <th>App'd</th>
                <th>Approved By</th>
                <th>Approved At</th>
              </tr>
              </thead>

              <?php
                //$current_userID set earlier
                $user_row = $wpdb->get_results("SELECT * FROM hrs_hrslog WHERE UserId = $search_userID ORDER By dateWorked Desc");

           foreach ($user_row as $user_row) {
               //Use user ID's to fetch User names.
               $user = get_user_by('ID', $user_row->UserId);
               $approver  = get_user_by('ID', $user_row->ApprovedBy);

               echo "<tr>";
               // echo "<td>".$user->first_name." ".$user->last_name."</td>";
               echo "<td>".$user_row->Hours."</td>";
               echo "<td>".date('jS M y', strtotime($user_row->dateWorked))."</td>";

               $venueName = $wpdb->get_var("SELECT name FROM hrs_hrsvenue WHERE Id = $user_row->Venue ");

               echo "<td>".$venueName."</td>";

               echo "<td>";
               if ($user_row->ApprovedBy == null) {
                   echo "<input type='checkbox' />";
               } else {
                   echo "<input type='checkbox' checked />";
               }
               echo "</td>";
               echo "<td>".$approver->first_name." ".$approver->last_name."</td>";
               if ($user_row->ApprovedAt == !null) {
                   echo "<td>".date('jS M y', strtotime($user_row->ApprovedAt))."</td>";
               } else {
                   echo "<td></td>";
               }
               echo "</tr>";
           } ?>

          </table>
      </div>

<?php
       } else {
            echo "<p class='error'>You must be an Administrator to view this page</p>";
        }//Close Logged and Admin In Check
        ?>
		</main><!—- #main —>
	</section><!—- #primary —>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
