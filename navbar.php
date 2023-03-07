 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand bg-white rounded d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-text text-success mx-3 text-sm">SCS</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
         <a class="nav-link" href="home.php">
             <i class="fa-solid fa-house"></i>
             <span>Home</span></a>
     </li>
     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
             <span>Purchase Requests</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
             <div class="bg-white collapse-inner rounded">
                 <h6 class="collapse-header">Select Purchase Requests:</h6>
                 <?php

                    include('handlers/db.php');
                    $query = "SELECT DISTINCT pr_no FROM purchase_request";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $pr_no = $row['pr_no'];
                    ?>
                         <a href="purchase_request.php?pr_no=<?php echo $pr_no; ?>" class="view-users-btn dropdown-item">PR No. <?php echo $pr_no ?></a>

                 <?php
                        }
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }

                    mysqli_close($conn);
                    ?>
             </div>
         </div>
     </li>
     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>
 </ul>
 <!-- End of Sidebar -->