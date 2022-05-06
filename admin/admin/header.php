<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>o-o</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed" style="background-color: #F2F4F4;">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">MAXCTF| 💀</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                  
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Backend
                            </a>
                      
                            <div class="sb-sidenav-menu-heading">your tasks:</div>
                           
                            <a class="nav-link" href="flags.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                              Flag Reports
                            </a>
                           
                            <!--<a class="nav-link" href="receivehistory.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-bezier-curve"></i></div>
                              Received Log
                            </a>

                            <a class="nav-link" href="senthistory.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                              Sent Log
                            </a>-->

                            <a class="nav-link" href="userz.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                              Users
                            </a>

                            <div class="sb-sidenav-menu-heading">who&who ctf??see</div>

                            <a class="nav-link" href="ctflog.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                              ReportLog
                            </a>
                            
                        </div>
                    </div>
                  
                </nav>
            </div>