<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>Lemme - POSLogSearch</title>
    <link rel="shortcut icon" href="<?php echo base_url("lemme");?>/resources/img/poslog.ico" />
    <script src="<?php echo base_url("lemme");?>/resources/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/angular.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/app.js"></script>
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/main.css">
    <script>var base_url='<?php echo base_url("lemme");?>';$(document).ready(function(){$(function(){$('[data-toggle="tooltip"]').tooltip();});});</script>
</head>
<body ng-controller="">
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/lemme/" style="color:#fff;"><span id="" class="glyphicon glyphicon-home" style="font-size:1.5em;line-height:20px;"></span></a>
                <p class="navbar-text" style=""><u>Search POSLog</u> to the Database and verify. <a href="#"><u>Help</u></a></p>
            </div>
            <div class="navbar-menu">
                <div id="settings" class="">
                    <a class="spin" data-toggle="modal" data-target="#ConnSettings">
                        <span id="navicn-settings" class="glyphicon glyphicon-cog"></span>
                    </a>
                </div>
                <div id="loader" class="">
                    <p>
                        <span id="navicn-loading-label">Loading...</span>
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
    <!-- ConnSettings Modal -->
    <div class="modal fade" id="ConnSettings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Connection Settings</h4>
                </div>
                <form ng-submit="submit()" >
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sql-server" class="control-label">Server:</label>
                            <input type="text" ng-model="server" class="form-control" id="" name="server" placeholder="Server Name or IP Address" />
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
                        <div class="checkbox">
                            <label style="float:left;">
                                <input type="checkbox" ng-model="saveconn">Set as Default Connection
                            </label>
                            <button type="submit" class="btn btn-primary">Connect</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ConnSettings Modal -->
    <!-- Form Inputs -->
    <div id="form">
        <div id="header-form">
            <div class="input-group">
                <span class="input-group-addon">Parameter</span>
                <input type="text" class="form-control" placeholder="Parameter Name, Field or Group" aria-describedby="sizing-addon1" id="search" ng-model="query.$" autofocus>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" ng-click="clear()">Clear</button>
                </span>
            </div>
        </div>
    </div>
    <!-- Results -->
    <i id="top"></i>
    <div id="result-body" class="panel panel-default">
        <div class="panel-body">
            <div id="{{result.rParameter}}" class="result-row" ng-repeat="result in results | filter:query:strict">
                <p><b>{{result.Parameter}}</b></p>
                <p>Location: {{result.Tab}} &gt; {{result.Category}} &gt; {{result.Group}} &gt; {{result.Parameter}}</p>
                <p>Raw Path: &lt;{{result.rCategory}}&gt; &#47; &lt;{{result.rParameter}}&gt;</p>
                <p>Description: {{result.Description}}</p>
            </div>
        </div>
    </div>
<!-- Footer -->
    <div id="nav-footer">
        <p>Footer here...</p>
        <div class="footer">Took {elapsed_time}s and {memory_usage} of Memory</div>
        <a href="#top">Back to Top</a>
    </div>

</body>
</html>