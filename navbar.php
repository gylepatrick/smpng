<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
     <a class="sidebar-brand bg-white d-flex align-items-center justify-content-center" href="home.php">
         <div class="sidebar-brand-text text-dark mx-3 text-sm">
            <img src="logo.webp" class="mt-3" width="25%" alt="">
            <p class="float-end" style="font-size: 10px;">Sumpong Central School</p>
         </div>
     </a>
     <hr class="sidebar-divider my-0">
     <li class="nav-item active">
         <a class="nav-link" href="home.php">
             <i class="fa-solid fa-house"></i>
             <span>Home</span></a>
     </li>
     <hr class="sidebar-divider">
     <li class="nav-item">
         <?php
            session_start();

            if (isset($_SESSION['success_del'])) {
                echo '<div class="success-message text-warning">' . $_SESSION['success_del'] . '</div>';
                unset($_SESSION['success_del']);
            }
            ?>
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
                         <a href="purchase_request.php?pr_no=<?php echo $pr_no; ?>" class="btn btn-success view-users-btn dropdown-item text-success">View PR No. <?php echo $pr_no ?></a>
                         <div class="mx-auto col-12 float-end">
                             <form action="handlers/delete_pr.php" method="post">
                                 <input type="hidden" value="<?php echo $pr_no ?>" name="pr_no" id="pr_no">
                                 <button type="submit" title="This can't be undone." style="font-size: 11px;" name="submit" class="text-white mt-3 btn btn-danger btn-sm col-6 mx-auto">Delete</button>
                             </form>
                         </div>
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
     <hr class="sidebar-divider">
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0 bg-dark" id="sidebarToggle"></button>
     </div>
 </ul>