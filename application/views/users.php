<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>Lemme - Users</title>
    <link rel="shortcut icon" href="<?php echo base_url("lemme");?>/resources/img/user.ico" />
    <script src="<?php echo base_url("lemme");?>/resources/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/spin.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/angular.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/app.js?ver=1.2"></script>
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/main.css">
    <script>var base_url='<?php echo base_url("lemme");?>';$(document).ready(function(){$(function(){$('[data-toggle="tooltip"]').tooltip();});});</script>
</head>
<body ng-controller="Users">
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/lemme/home#users" style="color:#fff;"><span id="" class="glyphicon glyphicon-home" style="font-size:1.5em;line-height:20px;"></span></a>
                <p class="navbar-text"><u>Search Users</u> for statuses and informations. <a href="#"><u>Help</u></a></p>
            </div>
            <div class="navbar-menu">
                <div id="settings" class="">
                    <a class="spin" data-toggle="modal" data-target="#ConnSettings">
                        <span id="navicn-settings" class="glyphicon glyphicon-cog"></span>
                    </a>
                </div>
                <div id="loader" class="">
                    <p>
                        <span id="navicn-loading-label">Connecting...</span>
                    </p>
                </div>
                <div id="status">
                    <p>
                        <span id="navicn-status"></span>
                        <span id="navicn-status-label">{{msg.data}} <b>{{msg.server}}</b></span>
                    </p>
                </div>
            </div>
        </div>
    </nav>
    <!-- Form Inputs -->
    <div id="form">
        <div id="header-form">
            <form ng-submit="search()">
            <div class="input-group">
                <span class="input-group-addon" id="sizing-addon">Org Unit / Store Number</span>
                <input id="store" type="text" class="form-control" placeholder="####" aria-describedby="sizing-addon1" ng-model="store" autofocus>
                <span class="input-group-btn">
                    <button id="search" class="btn btn-default" type="submit">Search</button>
                </span>
            </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="ConnSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Connection Settings</h4>
                </div>
                <form ng-submit="connect()" >
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sql-server" class="control-label">Server:</label>
                            <input type="text" ng-model="server" class="form-control" id="server" name="server" placeholder="Server Name or IP Address" />
                        </div>
                        <div class="form-group">
                            <label for="sql-instance" class="control-label">Instance:</label>
                            <input type="text" ng-model="instance" class="form-control" id="" name="instance" placeholder="Leave empty for Default Instance" />
                        </div>
                        <div class="form-group">
                            <label for="sql-username" class="control-label">Username:</label>
                            <input type="text" ng-model="username" class="form-control" id="" name="username" placeholder="SQL Username" />
                        </div>
                        <div class="form-group">
                            <label for="sql-password"  class="control-label">Password:</label>
                            <input type="text" ng-model="password" class="form-control" id="" name="password" placeholder="SQL Password" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="">
                            <button type="submit" class="btn btn-primary">Connect</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
      </div>
    </div>
    <div id="UserInfo" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">User Infomation</h4>
                </div>
                <div class="modal-body" ng-repeat="row in info">
                    <p><b>Username:</b> {{row.UserName}}</p>
                    <p><b>First Name:</b> {{row.FirstName}}</p>
                    <p><b>Last Name:</b> {{row.LastName}}</p>
                    <p><b>Display Name:</b> {{row.DisplayName}}</p>
                    <p><b>Role Code:</b> {{row.RoleCode}}</p>
                    <p><b>Role Name:</b> {{row.RoleName}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Results -->
    <div id="result-body" class="panel panel-default">
        <div class="panel-body">
            <div class="result-count" style="height:20px;">
                <div style="float:left;width:20%;min-width:162px;background:#fff;">{{count}}</div>
            </div>
            <div class="result-panel-body">
                <div id="stat{{result.RetryCount}}{{result.PCD}}" class="result-user-row" ng-repeat="result in results | orderBy:orderProp">
                    <div class="tltp" ng-show="{{result.PCD===null}}" data-toggle="tooltip" data-placement="bottom" title="User is Inactive" tooltip></div>
                    <div class="tltp" ng-show="{{result.RetryCount>=6}}" data-toggle="tooltip" data-placement="bottom" title="User is currently Locked" tooltip></div>
                    <div class="tltp" ng-show="{{result.PCD!==null}}" data-toggle="tooltip" data-placement="bottom" title="User is Active" tooltip></div>
                    <div class="user-id"><a href="" ng-click="more(result.UserID)">{{result.UserName}}</a></div>
                    <div class="user-role">{{result.RoleName}} ({{result.RoleCode}})</div>
                    <div class="user-name">{{result.DisplayName}}</div>
                    <div class="user-action">
                        <a ng-if="result.RetryCount===6" href="" ng-click="unlock(result.UserID)">Unlock<!--img src="./resources/img/unlock.png"--></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <div id="nav-footer">
        <p><a href="#top">Back to Top</a><span style="float:right;">Took {elapsed_time}s and {memory_usage} of Memory</span></p>
        <div class="footer" style="line-height: 10px;">Other Tools: <a href="./poslog">POSLog Search</a><a href="./params">Param Search</a> | Other Sites: <a href="../RTI.html">RTI Cheatsheet</a><a href="../training/">AS Overview</a><span style="float: right;">Developed by<a target="_blank" href="https://github.com/remzaki">remzaki</a>&copy; 2016</span></div>
    </div>
</body>
</html>