<?php
$panel = new \Controller\panel();
$landpages_datas = $panel->start_controller("landpage");
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Landing Page</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Upload your landpage as a php file. (You won't see anything here if you don't upload a 'php' format file).</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p>Drag multiple files to the box below for multi upload or click to select files. This is for demonstration purposes only, the files are not uploaded to any server.</p>
                        <form action="panel/lands_upl0ader.php" class="dropzone"></form>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <div class="">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Hover rows <small>Try hovering over the rows</small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Set As LandPage</th>
                                            <th>Show</th>
                                            <th>Delete</th>
                                        </tr>
                                        </thead>
                                        <?php if ($landpages_datas[0] > 0){?>
                                        <tbody>
                                        <?php foreach ($landpages_datas as $value){?>
                                            <tr>
                                                <td>Id</td>
                                                <td><a href=""><?= $value?></a></td>
                                                <td>Status</td>
                                                <td><a href="profile?parts=landingpages&SEt_Landpage=<?= $value?>"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a></td>
                                                <td><a href="profile?parts=landingpages&delete=">Show this page.</a></td>
                                                <td><a href="profile?parts=landingpages&DELETe_Landpage=<?= $value?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->