<?php
/**
 * Template Name: View List of Users
 *
 * Description: A custom page template for displaying All Users
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
            //Set Current User
            $current_user = wp_get_current_user();
            $current_userID = get_current_user_id();
            $display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

            if (current_user_can('administrator')) {
                ?>
    <div id="view_user_list">

        <h2>Users</h2>
        <p><a href="/view-user/?ID=all&A=&P=12">View All Users</a></p>
          <table class="table table-striped sortable">
            <thead class="thead-inverse">
              <tr>
                <th>Name</th>
                <th>Month</th>
                <th>Total</th>
              </tr>
              </thead>
            <?php
            $user_row = $wpdb->get_results("SELECT * FROM $wpdb->users");
                foreach ($user_row as $user_row) {
                    //Use user ID's to fetch User names.
                    echo "<tr>";

                    echo "<td><a href='/view-user/?ID=".$user_row->ID."&A=&P=12'>";
                    echo get_avatar($user_row->ID, 32);
                    echo "  ".$user_row->display_name ;

                    echo "</a></td>" ;

                    //Current Month
                    $month = date('m');
                    $year = date('Y');
                    $search_userID = $user_row->ID;

                    $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID AND MONTH(dateWorked) = $month AND YEAR(dateWorked) = $year ");

                    echo "<td>".$total_hrs."</td>";

                    $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID");

                    echo "<td>".$total_hrs."</td>";
                    $total_hrs = $wpdb->get_var("SELECT SUM(Hours) FROM hrs_hrslog WHERE UserId = $search_userID");

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
<?php get_footer(); ?>
