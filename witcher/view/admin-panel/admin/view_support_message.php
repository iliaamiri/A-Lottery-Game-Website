<div class="right_col" role="main">
<?php
if (isset($_GET['msgid'])){
    $panel = new \Controller\panel();
    $user = new \Model\user();
    $data = $panel->start();
    $message_info = $data['message_info'];
    $replies_list = $data['replies'];
    $user_permission = $data['user_permissions'];
    if (count($message_info) > 0 ){
?>
   <script src="https://cdn.ckeditor.com/4.7.2/standard/ckeditor.js"></script> 
   <style>
        .thumbnail {
            padding:0px;
        }
        .panel {
            position:relative;
        }
        .panel>.panel-heading:after,.panel>.panel-heading:before{
            position:absolute;
            top:11px;left:-16px;
            right:100%;
            width:0;
            height:0;
            display:block;
            content:" ";
            border-color:transparent;
            border-style:solid solid outset;
            pointer-events:none;
        }
        .panel>.panel-heading:after{
            border-width:7px;
            border-right-color:#f7f7f7;
            margin-top:1px;
            margin-left:2px;
        }
        .panel>.panel-heading:before{
            border-right-color:#ddd;
            border-width:8px;
        }
    </style>
    
        <div class="">
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?=$message_info['Email']?></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <b>موضوع: </b> <?=$message_info['Subject']?>
                            <div class="ln_solid"></div>
                            <b>متن : </b><br>
                            <?=$message_info['Message']?>
                            <div class="ln_solid"></div>
                            <b>پاسخ ها</b>
 <div class="row">
                            <?php foreach ($replies_list as $reply){
                                $user_info = $user->getUserInfoBy('Email',$reply['Email']);
                            ?>
                    <div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<strong><?=$reply['Email']?></strong> <span class="text-muted">commented <?=date("H:i:s",time() - $reply['Sent_At'])?> ago</span> 
<?php if ($user_permission['role_id'] == 2){ ?>
<div style="direction:rtl!important;">
<a href = "/profile/support_messages/view?msgid=<?=$reply['Message_id']?>&delete" class="btn btn-danger" >حذف</a>
</div>
<?php }?>
</div>
<div class="panel-body">
<?=preg_replace('#<script(.*?)>(.*?)</script>#is','',$reply['Message'])?>
</div><!-- /panel-body -->
</div><!-- /panel panel-default -->
</div>
                  
                            <?php }?>
                            </div>
                                <form method="post">
                                <textarea name="Texts" ></textarea>
                                <script>
                                    CKEDITOR.replace('Texts');
                                </script>
                                <br><br>

                                <br>
                                <div id="cke_editor" dir="rtl"></div>
                                    <input type="hidden" name="type" value="replying">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <button class="btn btn-primary" type="button">لغو و بازگشت</button>
                                        <input type="submit" class="btn btn-success" value="ثبت" name="submit" >
                                    </div>
                                </div>
                                </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
<?php }else{ ?>
<p>یافت نشد</p>
<?php }}?>
</div>