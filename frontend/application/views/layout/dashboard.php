<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-cube text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Proyectos</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0"><?php echo $projects; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-receipt text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Ejecuciones</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0"><?php echo $executions; ?></h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-poll-box text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Instancias</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0"><?php echo $instances; ?></h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <i class="mdi mdi-account-location text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                        <p class="mb-0 text-right">Otros</p>
                        <div class="fluid-container">
                            <h3 class="font-weight-medium text-right mb-0">246</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 grid-margin stretch-card">
        <!--weather card-->
        <div class="card card-weather">
            <div class="card-body">
                <div class="weather-date-location">
<!--                    <h3>--><?php
//                        setlocale(LC_ALL, "esp" ) or die("Not found"); # "es_ES@euro", "esp"
//                        echo ucwords(strftime("%A"));
//                        ?><!--</h3>-->
                    <p class="text-gray">
                        <span class="weather-date"><?php echo strftime("%d de %B, %Y");?></span>
                    </p>
                </div>
            </div>
        </div>
        <!--weather card ends-->
    </div>
    <div class="col-lg-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-primary mb-5">Proyectos compartidos conmigo</h2>
                <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                        <p class="mb-2">Proyecto X</p>
                    </div>
                    <div class="side-right">
                        <small class="text-muted">2017</small>
                    </div>
                </div>
                <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                        <p class="mb-2">Proyecto X</p>
                    </div>
                    <div class="side-right">
                        <small class="text-muted">2017</small>
                    </div>
                </div>
                <div class="wrapper d-flex justify-content-between">
                    <div class="side-left">
                        <p class="mb-2">Proyecto X</p>
                    </div>
                    <div class="side-right">
                        <small class="text-muted">2017</small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layout/display'); ?>