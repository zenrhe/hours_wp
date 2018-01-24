<?php
/**
 * Template Name: View All User's
 *
 * Description: A custom page template for displaying logs for all Users
 *
 * @package Poseidon
 */
 if (!is_user_logged_in()) { auth_redirect(); }


get_header(); ?>


	<section id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">

      WARNING - REDUNDANT PAGES
			<?php

      if ( is_user_logged_in() and current_user_can('administrator') ) {
      $current_user = wp_get_current_user();
			$current_userID = get_current_user_id();
			$display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;
            ?>

    <div id="view_all_users">
    <?php
       $row = $wpdb->get_results( "SELECT * FROM hrs_users");
       foreach ( $row as $row )
	   {
	        $search_userID = $row->ID;
             $search_user = get_user_by( 'ID', $search_userID );
             $search_name = $search_user->user_firstname.' '. $search_user->user_lastname ;
             ?>
             <div class="user">
            <h2><a href='view-user/?ID=<? echo $search_userID?>&A=&P=12'><?php echo  get_avatar( $search_userID, 32 )."   ".$search_name."'s Hours"?> </a></h2>
             <br/>

              <?php $total_hrs = $wpdb->get_var( "SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID");?>

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
                    $user_row = $wpdb->get_results( "SELECT * FROM hrs_hrslog WHERE UserId = $search_userID ");

                    foreach ( $user_row as $user_row )
                    {
                        //Use user ID's to fetch User names.
                        $user = get_user_by( 'ID', $user_row->UserId );
                        $approver  = get_user_by( 'ID', $user_row->ApprovedBy );

                        echo "<tr>";
                        // echo "<td>".$user->first_name." ".$user->last_name."</td>";
                        echo "<td>".$user_row->Hours."</td>";
                        echo "<td>".date('jS M y', strtotime($user_row->Submitted))."</td>";

                        $venueName = $wpdb->get_var( "SELECT name FROM hrs_venue WHERE Id = $user_row->Venue ");

                        echo "<td>".$venueName."</td>";

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
                        }                    echo "</tr>";
                    }
                ?>

              </table>
              </div><!-- End User Div-->
        <? }  //end outer user loop ?>
          </div><!-- All USers Div -->
 <?php }
        else
        {
        echo "<p class='error'>You must be an Administrator to view this page</p>";
        }//Close Logged and Admin In Check
        ?>
		</main><!—- #main —>
	</section><!—- #primary —>
<?php get_footer(); ?>
