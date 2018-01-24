<?php
/**
 * Template Name: View List of Venues
 *
 * Description: A custom page template for displaying All Venues
 *
 * @package Poseidon
 */
if (!is_user_logged_in()) {
    auth_redirect();
}

get_header(); ?>


<section id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">

 			<?php
                $current_user = wp_get_current_user();
                $current_userID = get_current_user_id();
                $display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

            if (current_user_can('administrator')) {
                ?>
        <br/><br/>
             <div id="view_venue_list">

                <h2>Venues</h2>
                <p><a href="/view-venue/">Show Hours for All Venues</a></p>
                  <table class="table table-striped sortable">
                    <thead class="thead-inverse">
                      <tr>
                        <th>Name</th>
                        <!-- <th>Description</th> -->
                        <th>Month</th>
                        <th>Total</th>
                      </tr>
                      </thead>
                    <?php
                    $row = $wpdb->get_results("SELECT * FROM hrs_venue");
                foreach ($row as $row) {
                    echo "<tr>";
                    echo "<td><a href='/view-venue/?ID=".$row->Id."'>";
                    echo $row->name."</a></td>" ;
                    //echo "<td>".$row->description."</td>" ;


                    //Current Month
                    $month = date('m');
                    $year = date('Y');
                    $search_venueID = $row->Id;

                    $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue = $search_venueID  AND MONTH(dateWorked) = $month AND YEAR(dateWorked) = $year");

                    echo "<td>".$total_hrs."</td>";


                    $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue = $search_venueID");

                    echo "<td>".$total_hrs."</td>";
                    echo "</tr>";
                } ?>

                  </table>
      </div>
<?php
            } else {
                echo "<p clas='error'>You must be an Administrator to view this page</p>";
            }//Close Logged and Admin In Check
        ?>
		</main><!—- #main —>
	</section><!—- #primary —>
<?php get_footer(); ?>
