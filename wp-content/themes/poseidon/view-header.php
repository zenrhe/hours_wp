<?php 

//Reference External Methods
get_template_part('func/view', 'user');
get_template_part('func/view', 'venue');
get_template_part('func/table', 'headers');
monthsInputScript(); //listner for manual month input

//Set Current User
$current_user = wp_get_current_user();
$current_userID = get_current_user_id();
$display_name = $current_user->user_firstname.' '. $current_user->user_lastname ;

function getSearchCriteria()
{
    echo "Test";
    //Get Search Criteria from URL
    $userID = htmlspecialchars($_GET['UID']);
    $venueID = htmlspecialchars($_GET['VID']);
    $groupBy = htmlspecialchars($_GET['G']);
    $approvalState = htmlspecialchars($_GET['A']);
    $searchPeriod = htmlspecialchars($_GET['P']);
    $search_venueID = null;
    if ($searchPeriod == null) {
        $searchPeriod = 12;
    } 
}
?>