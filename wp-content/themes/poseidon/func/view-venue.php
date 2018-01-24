<?php

function groupFilter($venueID, $approvalState, $groupBy)
{
    //Search Button Filters - Active status
    if ($groupBy == 'L') {
        echo "<a href='?VID=".$venueID."&amp;A=".$approvalState."&amp;G=L'class='btn btn-primary activeFilter' role='button'>
     List</a>";
    } else {
        echo "<a href='?VID=".$venueID."&amp;A=".$approvalState."&amp;G=L'class='btn btn-primary' role='button'>
     List</a>";
    }
    if ($groupBy == 'U') {
        echo "<a href='?VID=".$venueID."&amp;A=".$approvalState."&amp;G=U'class='btn btn-primary activeFilter' role='button'>
   User</a>";
    } else {
        echo "<a href='?VID=".$venueID."&amp;A=".$approvalState."&amp;G=U'class='btn btn-primary' role='button'>
     User</a>";
    }
}

function approvalFilter($userID, $venueID, $approvalState, $groupBy, $searchPeriod)
{
    $url ="?UID=".$userID."&amp;?VID=".$venueID."&amp;G=".$groupBy."&amp;P=".$searchPeriod."&amp;A=";

    // Show Approval Filter - All, Approve, Unnapproved
    // Apply CSS Class to Show which is Active
    if ($approvalState == 'all') {
        echo "<a href='".$url."all' class='btn activeFilter' role='button' >All</a>";
    } else {
        echo "<a href='".$url."all' class='btn' role='button' >All</a>";
    }
    if ($approvalState == 'app') {
        echo "<a href='".$url."app' class='btn activeFilter' role='button' >Approved</a>";
    } else {
        echo "<a href='".$url."app' class='btn' role='button' >Approved</a>";
    }
    if ($approvalState == 'napp') {
        echo "<a href='".$url."napp' class='btn activeFilter' role='button' >Not Approved</a>";
    } else {
        echo "<a href='".$url."napp' class='btn' role='button' >Not Approved</a>";
    }
}

function getVenueHours($search_venueID, $approvalState, $searchPeriod)
{
    global $wpdb;

    //Get all hours for venue
    $baseSelect = "SELECT SUM(Hours) FROM hrs_hrslog WHERE Venue = '". $search_venueID." '";

    //Add Approval Filter restriction
    $approval = "";
    if ($approvalState == 'app') {
        $approval = " AND ApprovedBy IS NOT NULL";
    };
    if ($approvalState == 'napp') {
        $approval = " AND ApprovedBy IS NULL";
    };
    //Add Date Filter restriction
    $dateRange = "";
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime("-$searchPeriod months"));
    if ($searchPeriod !== null) {
        $dateRange = " AND dateWorked Between '$startDate' And '$endDate'";
    }
    $query = $baseSelect.$approval.$dateRange;
    //echo "query: ".$query;

    $total_hrs = $wpdb->get_var("$query");

    return $total_hrs;
}
