<?php
function tableHeadersUser($approvalState, $search_venueID)
{
    ?>
  <table class="table table-striped sortable">
    <thead class="thead-inverse">
       <tr>
        <th>Hours</th>
        <th>Date</th>
        <?php if ($search_venueID == null) {
        ?>
        <th>Venue</th>
        <?php
    }
    if ($approvalState == 'all' or $approvalState == null or $approvalState == 'app') {
        ?>
          <th>App'd</th>
          <th>Approved By</th>
          <th>Approved At</th>
        <?php
    } else {//Only viewing non approved?>
          <th>Description</th>
          <th></th> <!--Approval Button-->
          <?php
    } ?>
      </tr>
    </thead>
  <?php
}
function tableHeadersVenue($approvalState, $search_venueID)
{
    ?>
  <table class="table table-striped sortable">
    <thead class="thead-inverse">
       <tr>
        <th>Name</th>
        <th>Hours</th>
        <th>Date</th>
        <?php
        if ($approvalState == 'all' or $approvalState == null or $approvalState == 'app') {
            ?>
          <th>App'd</th>
          <th>Approved By</th>
          <th>Approved At</th>
        <?php
        } else {
            //Only viewing non approved?>
          <th>Description</th>
          <th></th> <!--Approval Button-->
          <?php
        } ?>
      </tr>
    </thead>
  <?php
}
?>
