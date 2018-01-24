<?php
/**
 * Template Name: View User
 *
 * Description: A custom page template for displaying details of 1 user
 *
 * @package Poseidon
 */
// Redirect to Login if trying to view. Line must be first line.
if (!is_user_logged_in()) {
    auth_redirect();
}
get_header();

//Reference External Methods
get_template_part('func/view', 'user');
get_template_part('func/view', 'venue');
get_template_part('func/table', 'headers');
monthsInputScript(); //listner for manual month input
?> 

<section id="primary" class="fullwidth-content-area content-area">
<main id="main" class="site-main" role="main">

<?php
  //Set Current User
  //TODO Current user needs put in a header method
  $current_user = wp_get_current_user();
  $current_userID = get_current_user_id();
  $display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

  //Get Criteria from URL
  //$ID = htmlspecialchars($_GET['ID']);
  $userID = htmlspecialchars($_GET['UID']);
  $venueID = htmlspecialchars($_GET['VID']);
  $searchPeriod = htmlspecialchars($_GET['P']);
  $approvalState = htmlspecialchars($_GET['A']);
  $search_venueID = null;
  $groupBy = null;
  if ($searchPeriod == null) {
      $searchPeriod = 12;
  }
  //$grouping = htmlspecialchars($_GET['G']);

  //Check Search is allowed
  $search_userID = setSearchUserID($userID, $current_userID);

  //Insert Month Filter
  monthFilter($userID, $venueID, $approvalState, $groupBy, $searchPeriod);?>

  <div class="col-lg-6 input-group filter">
     <?php approvalFilter($userID, $venueID, $approvalState, $groupBy, $searchPeriod);?>
  </div>

  <?php if ($search_userID != 'all') {
      ?>
  <div id="view_user">
    <?php //Get Search User's Full Name for display
    $search_user = get_user_by('ID', $search_userID);
      $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ; ?>

    <div class="username-title">
        <h2><?php echo  get_avatar($search_userID, 32)."   ".$search_name."'s Hours"?> </h2>
    </div>
    <?php $total_hrs =  getUserHours($search_userID, $search_venueID, $searchPeriod, $approvalState); ?>

    <h4>Total Hours for <?php echo $searchPeriod ; ?> Months: <?php echo $total_hrs ?> </h4>
    <?php
      //Load Table Format
      tableHeadersUser($approvalState, $search_venueID);

      //Get data and display in table
      getUserTable($search_userID, null, $searchPeriod, $approvalState); ?>
    </div><!-- #view_user-->
    <?php
  } else {
      ?>
    <div id="view_all_users">
      <?php
      $row = $wpdb->get_results("SELECT * FROM hrs_users");
      foreach ($row as $row) {
          $search_userID = $row->ID;
          $search_user = get_user_by('ID', $search_userID);
          $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ; ?>
      <div id="view_user">
        <div class="username-title">
            <h2><?php echo  get_avatar($search_userID, 32)."   ".$search_name."'s Hours"?> </h2>
        </div>
        <?php $total_hrs =  getUserHours($search_userID, $search_venueID, $searchPeriod, $approvalState); ?>

        <h4>Total Hours for <?php echo $searchPeriod ; ?> Months: <?php echo $total_hrs ?> </h4>
        <?php
          //Load Table Format
          tableHeadersUser($approvalState, $search_venueID);

          //TODO global vars.
          //Get data and display in table
          getUserTable($search_userID, null, $searchPeriod, $approvalState); ?>
        </div><!-- #view_user-->
      <?php
      } //end User Row
  } //view all users
    ?>
  </div>
	</main><!-- #main -->
</section><!-- #primary —>
<?php get_footer(); ?>
