<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="static/dashboard.css">

</head>
<body>

<div class="app-shell">

    <!-- Sidebar backdrop for mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- ==== SIDEBAR === -->
    <?php 
        include 'phpfile/sidebar.php';
    ?>

    <!-- ==== MAIN ==== -->
    <div class="main-col">

        <!-- Mobile-only topbar with menu toggle -->
         <?php 
            include 'phpfile/topbar.php';
        ?>

        <main class="content">
            <div class="container-fluid p-0 grid-12">

                <!-- Greeting carousel -->
                <div class="row">
                    <div class="col-12">
                        <div id="greetingCarousel" class="carousel slide greeting-card" data-bs-ride="carousel" data-bs-interval="6000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <h1 class="greeting-title">Good Morning, <span class="placeholder-name">|User Name|</span>.</h1>
                                    <p class="greeting-sub mb-0">Resident Overview</p>
                                </div>
                                <div class="carousel-item">
                                    <h1 class="greeting-title">3 Announcements</h1>
                                    <p class="greeting-sub mb-0">New updates from Barangay Pinagkawitan</p>
                                </div>
                                <div class="carousel-item">
                                    <h1 class="greeting-title">2 Requests In Progress</h1>
                                    <p class="greeting-sub mb-0">Track the status of your document requests</p>
                                </div>
                            </div>
                            <div class="carousel-dots">
                                <button type="button" data-bs-target="#greetingCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#greetingCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#greetingCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat cards -->
                <div class="row g-3 g-md-4">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></div>
                            <div class="stat-label">Total Residents</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></div>
                            <div class="stat-label">Pending Request</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></div>
                            <div class="stat-label">To Claim</div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<script src="static/dashboard.js"></script>
</body>
</html>