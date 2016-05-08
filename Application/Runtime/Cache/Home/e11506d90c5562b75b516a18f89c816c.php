<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>我的-被接受的</title>
<link href="/LingHang-iteration-ii/Public/css/boots/bootstrap.min.css" rel="stylesheet">
    <link href="/LingHang-iteration-ii/Public/css/less/main/main.css" rel="stylesheet">
    <link href="/LingHang-iteration-ii/Public/css/less/personal/des-personal-main.css" rel="stylesheet">
    <link href="/LingHang-iteration-ii/Public/css/less/personal/des-personal-accepted.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top nav-top desktop">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img alt="Brand" src="/LingHang-iteration-ii/Public/img/logo.png" style="height: 45px;">
            </a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="#">市场</a></li>
                <li><a href="#">悬赏</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">CR14</a></li>
                <li class="active"><a href="#">我的</a></li>
                <li><a href="#">退出</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 search-container desktop">
            <div class="row">
                <div class="col-md-offset-5 col-md-2">
                    <img src="/LingHang-iteration-ii/Public/img/test3.jpg" class="img-responsive center-block img-circle">
                    <a class="name center-block" data-toggle="modal" data-target="#info-modal">详情>></a>
                </div>
                <div class="col-md-5">
                    <div class="evaluate">
                        买家好评&nbsp;:&nbsp;&nbsp;<?php echo ($comment_buyer); ?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        卖家好评&nbsp;:&nbsp;&nbsp;<?php echo ($comment_seller); ?>&nbsp;%
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid main-container">
            <div class="col-md-2 side desktop">
                <div class="panel-group" id="left-dropdown">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuOne">
                                我发布的
                            </a>
                        </div>
                        <div id="menuOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <button class="btn form-control">悬赏</button>
                                <button class="btn form-control">技能</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuTwo">
                                被接受的
                            </a>
                        </div>
                        <div id="menuTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <button class="btn form-control">悬赏</button>
                                <button class="btn form-control">技能</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuSeven">
                                我买下的
                            </a>
                        </div>
                        <div id="menuSeven" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <button class="btn form-control">悬赏</button>
                                <button class="btn form-control btn-active">技能</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuThree">
                                我的收藏
                            </a>
                        </div>
                        <div id="menuThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <button class="btn form-control">悬赏</button>
                                <button class="btn form-control">技能</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuFour">
                                评价详情
                            </a>
                        </div>
                        <div id="menuFour" class="panel-collapse collapse">
                            <div class="panel-body">
                                <button class="btn form-control">我是学生</button>
                                <button class="btn form-control">我是老师</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuFive">
                                我的账户
                            </a>
                        </div>
                        <div id="menuFive" class="panel-collapse collapse">
                            <div class="panel-body">
                                <button class="btn form-control">我的账户</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <a class="nav-title" data-toggle="collapse" data-parent="#left-dropdown" href="#menuSix">
                                设置
                            </a>
                        </div>
                        <div id="menuSix" class="panel-collapse collapse">
                            <div class="panel-body">
                                <button class="btn form-control">账号设置</button>
                                <button class="btn form-control">更改个人资料</button>
                                <button class="btn form-control">主题设置</button>
                                <button class="btn form-control">关于我们</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        <?php if(is_array($buys)): foreach($buys as $key=>$buy): ?><div class="panel panel-default main">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-2 clear-pad-right">
                                            <img src="<?php echo ($buy[pic_url][0]); ?>" class="img-responsive img-1">
                                        </div>
                                        <div class="col-md-8">
                                            <div><?php echo ($buy[title]); ?></div>
                                            <div class="price">￥<?php echo ($buy[price]); ?></div>
                                        </div>
                                        <div class="col-md-2 right">
                                            <div class="row">
                                                <div class="title">卖家</div>
                                            </div>
                                            <div class="row row-2">
                                                <div class="col-xs-6 clear-pad-left">
                                                    <img src="<?php echo ($buy[avatar_url]); ?>" class="img-responsive img-circle">
                                                </div>
                                                <div class="col-xs-6 clear-pad">
                                                    <?php echo ($buy[username]); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row clear-mar-lr">
                                        <label class="num"><?php echo ($buy[time]); ?></label>
                                        <label class="icon-sm num">删除</label>
                                        <label class="icon-sm save"></label>
                                        <label class="icon-sm num">查看评价</label>
                                        <label class="icon-sm msg"></label>
                                    </div>
                                </div>
                            </div><?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--modal personal info-->
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="info-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="info-title">
                    个人资料
                </h4>
            </div>
            <div class="modal-body list-group">
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">昵称</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">Top_CR</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">姓名</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">陈睿</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">性别</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">男</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">手机</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">12939281922</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">邮箱</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">293729109@qq.com</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">生日</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">3.10</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">擅长</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">小提琴</h5>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-3">
                            <h5 class="clear-mar-ud">爱好</h5>
                        </div>
                        <div class="col-xs-9">
                            <h5 class="clear-mar-ud">打篮球</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-block publish_btn_des center-block">确认</button>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>

<script src="/LingHang-iteration-ii/Public/js/jquery.js"></script>
<script src="/LingHang-iteration-ii/Public/js/fileinput.min.js"></script>
<script src="/LingHang-iteration-ii/Public/js/bootstrap.min.js"></script>
<script src="/LingHang-iteration-ii/Public/js/bootstrap-datepicker.js"></script>
<script src="/LingHang-iteration-ii/Public/js/common.js"></script>
</body>
</html>