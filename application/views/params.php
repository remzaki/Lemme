<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>Lemme - ParamSearch</title>
    <link rel="shortcut icon" href="<?php echo base_url("lemme");?>/resources/img/params.ico" />
    <script src="<?php echo base_url("lemme");?>/resources/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/angular.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/app.js"></script>
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/main.css">
    <script>var base_url='<?php echo base_url("lemme");?>';$(document).ready(function(){$(function(){$('[data-toggle="tooltip"]').tooltip();});});</script>
</head>
<body ng-controller="Search">
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/lemme/" style="color:#fff;"><span id="" class="glyphicon glyphicon-home" style="font-size:1.5em;line-height:20px;"></span></a>
                <p class="navbar-text" style=""><u>Search Parameter</u> details and various parameter related informations. <a href="#"><u>Help</u></a></p>
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
    <div class="modal fade" id="ConnSettings" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
    <div id="ParamInfo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Parameter Infomation</h4>
                </div>
                <div class="modal-body">
                    <p><b>Tab:</b> {{info.Tab}}</p>
                    <p><b>Category:</b> {{info.Category}}</p>
                    <p><b>Group:</b> {{info.Group}} ({{info.rGroup}})</p>
                    <p><b>Field:</b> {{info.Field}} ({{info.rParameter}})</p>
                    <p><b>Description:</b> {{info.Description}}</p>
                    <p><b>Help:</b> {{info.Help}}</p>
                    <p><b>Input Type:</b> {{info.UIType}}</p>
                    <p ng-if="option!==''"><b>Options:</b> </p>
                    <div ng-if="option!==''" style="max-height:6em;overflow-x:auto;border:1px solid #E5E5E5;">
                        <ul ng-repeat="opt in option">
                            <li>{{opt.Val}} ({{opt.rVal}})</li>
                        </ul>
                    </div>
                    <p ng-if="defval!==''"><b>Default Value/s:</b> </p>
                    <div ng-if="defval!==''" style="max-height:15em;overflow-x:auto;border:1px solid #E5E5E5;">
                        <ul ng-repeat="val in defval">
                            <li ng-if="val.RecordKey===0">{{val.Value}}</li>
                            <li ng-if="val.RecordKey!==0">Record {{val.RecordKey}}: {{val.Value}}</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- ParamsInfo Modal -->
    <div id="GroupInfo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Group Infomation</h4>
                </div>
                <div class="modal-body">
<!--                    <p><b>Tab:</b> {{info.Tab}}</p>
                    <p><b>Category:</b> {{info.Category}}</p>-->
                    <p><b>Group:</b> {{grp[0].GroupName}}</p>
                    <select ng-model="orderf">
                        <option value="RecordKey">Record</option>
                        <option value="FieldName">Alphabetical</option>
                    </select>
                    <p><b>Default Record/s:</b> </p>
                    <div style="max-height:30em;overflow-x:auto;border:1px solid #E5E5E5;">
                        <ul ng-repeat="grpval in grp | orderBy:orderf">
                            <li>Record {{grpval.RecordKey}}: {{grpval.FieldName}}: {{grpval.Value}}</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- GroupInfo Modal -->
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
    <i id="top"></i>
    <!--<div id="nullify" style="height: 130px;"></div>-->
    <!-- Results -->
    <div id="result-body" class="panel panel-default">
        <div class="panel-body">
            <div id="{{result.rParameter}}" class="result-row" ng-repeat="result in results | filter:query:strict">
                <!--<p>-->
                <h4>
                    <a>
                        <span class="glyphicon glyphicon-minus-sign" style="position: initial;" ng-if="result.RecordLimit===1"></span>
                        <span class="glyphicon glyphicon-plus-sign" style="position: initial;" ng-if="result.RecordLimit!==1"></span>
                    </a>
                    <a style="cursor: pointer;" ng-click="getdetails(result.rGroup, result.rParameter)"><span>{{result.Parameter}}</span></a>
                </h4>
                <!--</p>-->
                <p>Description: <span class="desc">{{result.Description}}</span></p>
                <p>Location: {{result.Tab}} &gt; {{result.Category}} &gt; {{result.Group}} &gt; {{result.Parameter}}</p>
                <p>XML Raw: 
                    <a style="cursor: pointer;" ng-if="result.RecordLimit!==1" ng-click="getgroupdetails(result.rGroup)">&lt;{{result.rGroup}}&gt;</a>
                    <span style="color: #337AB7" ng-if="result.RecordLimit===1">&lt;{{result.rGroup}}&gt;</span>
                    &#47; <span style="color: #337AB7">&lt;{{result.rParameter}}&gt;</span></p>
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