<?php
$sessdata = $this->session->userdata('project_id');
if (isset($sessdata)) {
    $project_id = $sessdata;
}
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <?php if (!isset($project_id)) { ?>
                    <a class="btn btn-success btn-block" href="/projects/define">Selecciornar Proyecto</a>
                    <a class="btn btn-default btn-block" href="/projects/create">Nuevo Proyecto</a>
                <?php } else { ?>
                    <a class="btn btn-success btn-block" href="/projects/create">Nuevo Proyecto</a>
                    <a class="btn btn-default btn-block" href="/projects/define">Cambiar
                        de <?php echo $project_id; ?> </a>
                <?php } ?>

            </div>
        </li>

        <li class="nav-item">
            <a a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="true" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-file"></i>
                <span class="menu-title">Proyectos</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic" style="">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="/projects">Mis proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projects/shared">Compartidos conmigo</a>
                    </li>
                </ul>
            </div>
        </li>

        <?php if (isset($project_id)) { ?>

            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="menu-icon mdi mdi-television"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/task-instances">
                    <i class="menu-icon mdi mdi-content-copy"></i>
                    <span class="menu-title">Instancias</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/files">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Archivos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/processes">
                    <i class="menu-icon mdi mdi-worker"></i>
                    <span class="menu-title">Procesos</span>
                </a>
            </li>
        <?php } ?>

    </ul>
</nav>