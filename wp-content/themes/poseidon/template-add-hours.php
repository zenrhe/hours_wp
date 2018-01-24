<?php
/**
 * Template Name: Add Hours Page
 *
 * Description: A custom page template for displaying user Add Hours. copied from Full Width
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
      //Show Logged in User
      $current_user = wp_get_current_user();
      $current_userID = get_current_user_id();
      $display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

      echo "Logging hours for <strong>". $display_name."</strong>"; ?>

<br/><br/>

    <!-- HTML Form (wrapped in a .bootstrap-iso div) -->
    <div class="bootstrap-iso">
     <div class="container-fluid">
      <div class="row">
       <div class="col-md-6 col-sm-6 col-xs-12">
          <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <!--<form method="post" action="view-user"> -->
         <div class="form-group ">
          <label class="control-label requiredField" for="hoursSelection">
           Hours
          </label>
          <input type="hidden" name="userID" value="<?php echo $current_userID?>">

          <select class="select form-control" id="hoursSelection" name="hours">
            <!-- TODO Make Option Loop -->
           <option value="1"> 1 </option>
           <option value="2"> 2 </option>
           <option value="3"> 3 </option>
           <option value="4"> 4 </option>
           <option value="5"> 5 </option>
           <option value="6"> 6 </option>
           <option value="7"> 7 </option>
           <option value="8"> 8 </option>
           <option value="9"> 9 </option>
           <option value="10"> 10 </option>
          </select>
         </div>
         <div class="form-group ">
          <label class="control-label requiredField" for="date"> Date  </label>
          <div class="input-group">
           <div class="input-group-addon">
            <i class="fa fa-calendar">
            </i>
           </div>
           <input class="form-control" id="date" name="date" placeholder="yyyy-mm-dd" type="text"/>
          </div>
         </div>
         <div class="form-group ">
          <label class="control-label requiredField" for="venue"> Venue </label>
          <select class="select form-control" id="venue" name="venue">
            <?php
            //Add Venues from Database
            $row = $wpdb->get_results("SELECT * FROM wphrs_hrsvenue ORDER BY name");
                foreach ($row as $row) {
                    echo "<option value='".$row->Id."'>";
                    echo $row->name;
                    echo "</option>";
                } ?>
           <!-- <option value="Other">  Other </option> -->
          </select>
         </div>
         <div class="form-group ">
          <label class="control-label " for="description">
           Description </label>
          <input class="form-control" id="description" name="description" type="text"/>
         </div>
         <div class="form-group">
          <div>
            <input type="hidden" name="action" value="add_Hours_Form">

           <button class="btn btn-primary " name="submit" type="submit" >
            Submit
           </button>
          </div>
         </div>
        </form>
       </div>
      </div>
     </div>
    </div>

    <script>
    $(document).ready(function(){
      //Show Calendar datepicker
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
            todayBtn: true,
        })
    })
  </script>
		</main><!—- #main —>
	</section><!—- #primary —>

<?php get_footer(); ?>
