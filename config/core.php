<!-- This file will hold pagination variables. Using a core.php file is a good practice, it can be used to hold other configuration values that  might be useful in the future. -->
<?php
  // page given in URL parameter, default page is one
  $page = isset($_GET['page']) ? $_GET['page'] : 1;

  // set number of records per page
  $records_per_page = 5;

  // calculate for the query LIMIT clause
  $from_record_num = ($records_per_page * $page) - $records_per_page;
?>
