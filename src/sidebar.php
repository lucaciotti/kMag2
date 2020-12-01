<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="funzioni-pc.php" class="brand-link">
        <img src="images/logo.jpg" alt="KK Logo" class="brand-image elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Krona Koblenz</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-header text-uppercase text-bold text-md">Funzioni Ricevimento Merci</li>
                <li class="nav-item">
                    <a href=""
                       class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Gestione Documenti Prelevabili
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                       class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Elenco Righe Acquisite
                        </p>
                    </a>
                </li>
            </ul>

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-header text-uppercase text-bold text-md">Funzione Inventario</li>
                <li class="nav-item">
                    <a href="invTable.php"
                       class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Riepilogo Sparate Inventario (Richiede Login)
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                       class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Carico inventario da Excel
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<?php
function highlight_menu($menu, $titolo){
    $hl = "";
    if(trim($menu) == trim($titolo)){
        $hl = "navbar-primary";
    }
    return $hl;
}


?>
