<?php
/**
 * Template Name: View Venue
 *
 * Description: A custom page template for displaying details of 1 user
 *
 * @package Poseidon
 */
if (!is_user_logged_in()) {
    auth_redirect();
}

get_header();

//Reference External Methods
get_template_part('func/view', 'user');
get_template_part('func/view', 'venue');
get_template_part('func/table', 'headers');
monthsInputScript(); //listner for manual month input
//Set Current User
//TODO Current user needs put in a header method
$current_user = wp_get_current_user();
$current_userID = get_current_user_id();
$display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

if (current_user_can('administrator')) {
    //Get Criteria from URL //TODO put in a header method
    //$userID = htmlspecialchars($_GET['UID']);
    $userID = htmlspecialchars($_GET['UID']);
    $venueID = htmlspecialchars($_GET['VID']);
    $groupBy = htmlspecialchars($_GET['G']);
    $approvalState = htmlspecialchars($_GET['A']);
    $searchPeriod = htmlspecialchars($_GET['P']);
    $search_venueID = null;
    if ($searchPeriod == null) {
        $searchPeriod = 12;
    } ?>

<section id="primary" class="fullwidth-content-area content-area">
<main id="main" class="site-main" role="main">
  <?php //Insert Month Filter
  monthFilter($userID, $venueID, $approvalState, $groupBy, $searchPeriod); ?>

  <div class="col-lg-6 input-group filter">
       <?php approvalFilter($userID, $venueID, $approvalState, $groupBy, $searchPeriod); ?>
       <?php groupFilter($venueID, $approvalState, $groupBy); ?>
  </div> <br/>
       <?php
  //TODO $searchPeriod to be added to venue queries

  //Search Specific venue or all
  if ($venueID != null) {
      $venue_row = $wpdb->get_results("SELECT * FROM hrs_venue WHERE Id=$venueID");
  } else {
      $venue_row = $wpdb->get_results("SELECT * FROM hrs_venue");
  }

    if ($groupBy == 'U' or $groupBy == null) { //Grouping by User under each venue?>
    <div id="view_all_venues_by_user">
      <?php
    foreach ($venue_row as $venue_row) {
        //Venue Title and info
      $search_venueID = $venue_row->Id;

        //Show Venue Name and Hours
        $search_venue = $wpdb->get_var("SELECT name FROM hrs_venue WHERE Id = '$search_venueID'"); ?>

      <h2><?php echo $search_venue ?></h2>
      <?php
      $total_hrs = getVenueHours($search_venueID, $approvalState, $searchPeriod); ?>

      <h4>Total Hours: <?php echo $total_hrs ?></h4>
      	<hr/>
      <?php

      //Select individual Users
       $row = $wpdb->get_results("SELECT DISTINCT UserId FROM hrs_hrslog Where Venue = $search_venueID");

        foreach ($row as $row) {
            //Each User
            $search_userID = $row->UserId;

            $search_user = get_user_by('ID', $search_userID);
            $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ;

            $total_hrs =  getUserHours($search_userID, $search_venueID, $searchPeriod, $approvalState);

            //May have no hours based on Approval Filter
            if ($total_hrs != null) {
                //Show User name and total hours
                echo "<div class='username-title'><h4>".get_avatar($search_userID, 32)." ".$search_name." (".$total_hrs.")</h4></div>";

                //Table for User at Venue
                tableHeadersUser($approvalState, $search_venueID);

                getUserTable($search_userID, $search_venueID, $searchPeriod, $approvalState);
            }
        }//each user
    } //each Venue?>
      </div> <!-- All Venue Div-->
<?php
    }//Group by U
  else {//Display normal list
  //TODO Refactor plain list view
  ?>
     <div id="view_all_venues">
       <hr>
     <?php
        foreach ($venue_row as $venue_row) {
            $search_venueID = $venue_row->Id;
            $search_userID = null;
            //TODO create getVenueName
          $search_venue = $wpdb->get_var("SELECT name FROM hrs_venue WHERE Id = '$search_venueID'"); ?>
          <h2>Venue: <?php echo $search_venue ?></h2>

          <?php
          $total_hrs = getVenueHours($search_venueID, $approvalState, $searchPeriod); ?>
          <h4>Total Hours: <?php echo $total_hrs ?></h4>

          <?php tableHeadersVenue($approvalState, $search_venueID); ?>

         <?php getUserTable($search_userID, $search_venueID, $searchPeriod, $approvalState); ?>

          </table>
      <?php
        } //venue loop
      ?>
		</div> <!-- All Venue Div -->
<?php
  } //Normal Venue List
} else {
    //Logged and Admin In Check
    echo "<p class='error'>You must be an Administrator to view this page</p>";
}
?>
		</main><!—- #main —>
	</section><!—- #primary —>
<?php get_footer(); ?>
