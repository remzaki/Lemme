<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>Lemme - ParamSearch</title>
    <link rel="shortcut icon" href="<?php echo base_url("lemme");?>/resources/img/params.ico" />
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
<body ng-controller="Params">
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/lemme/home#params" style="color:#fff;"><span id="" class="glyphicon glyphicon-home" style="font-size:1.5em;line-height:20px;"></span></a>
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
          <div class="modal-content" id="spinn">
          </div>
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
                        <div class="">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Parameter Information</h4>
                </div>
                <div class="modal-body">
                    <p><b>Tab:</b> {{info.Tab}}</p>
                    <p><b>Category:</b> {{info.Category}}</p>
                    <p><b>Group:</b> {{info.Group}} (<a href="" ng-click="getgroupdetails(info.rGroup, info.Tab)">{{info.rGroup}}</a>)</p>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Group Information</h4>
                </div>
                <div class="modal-body">
                    <div ng-show="touchtypes!==''">
                        <p><b>Group:</b> {{group}}</p>
                        <!-- Nav tabs -->
                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                            <li role="presentation" ng-repeat="touchtype in touchtypes" ng-class="{active: $index == 0}">
                                <a href="#{{touchtype.Name}}" aria-controls="thick" role="tab" data-toggle="tab" ng-click="getdefaultparams(group, touchtype.DeviceClassId)">{{touchtype.Description}}</a>
                            </li>
                            <li style="float:right;">
                                <input type="text" class="form-control" placeholder="Filter" aria-describedby="basic-addon1" ng-model="filt.$">
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!--<div id="spinnnn" ng-show="params===''" style="height:15em;"></div>-->
                            <div role="tabpanel" class="tab-pane fade in" ng-repeat="touchtype in touchtypes" id="{{touchtype.Name}}" ng-class="{active: $index == 0}">
                                <!--<div id="ind{{touchtype.DeviceClassId}}" ng-show="params===''" style="height:15em;"></div>-->
                                <div class="panel-group" style="max-height:30em;overflow-x:auto;border:0px solid #E5E5E5;">
                                    <div class="panel panel-default">
                                            <div class="panel-heading" ng-repeat="values in defvalues | filter:filt:strict" ng-show="values.Touchtype===touchtype.DeviceClassId" style="border-bottom:1px solid #ddd;">
                                                <style>.panel-heading:hover{background:#e6e6e6;}</style>
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-target="#collapse{{values.Touchtype}}{{values.Numeric}}" href="#collapse{{values.Touchtype}}{{values.Numeric}}">{{values.Header}} = {{values.Value}}</a>
                                                </h4>
                                                <div id="collapse{{values.Touchtype}}{{values.Numeric}}" class="panel-collapse collapse in">
                                                    <ul class="list-group">
                                                        <li class="list-group-item" ng-repeat="D in values.Data">Record {{D.RecordKey}}: {{D.FieldName}} = {{D.Value}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <p><b>Default Records:</b> </p>
                        <div style="max-height:30em;overflow-x:auto;border:0px solid #E5E5E5;">
                            <ul ng-repeat="grpval in grp">
                                <li>Record {{grpval.RecordKey}}: {{grpval.FieldName}}: {{grpval.Value}}</li>
                            </ul>
                        </div>-->
                    </div>
                    <div id="spinnn" ng-show="touchtypes==='' || defvalues===''" style="height:15em;"></div>
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
                    <a style="cursor: pointer;/*font-size:135%;*/" ng-click="getdetails(result.rGroup, result.rParameter)"><span>{{result.Parameter}}</span></a> &nbsp;
<!--                    <span class="label label-info" ng-if="result.RecordLimit===1">Single Record</span>
                    <span class="label label-primary" ng-if="result.RecordLimit!==1">Multi Record</span>-->
                </h4>
                <!--</p>-->
                <p>
                    Description: <span class="desc">{{result.Description}}</span> &nbsp;
                    <span class="label label-success">{{result.Tab}}</span>
                    <span class="label label-info" ng-if="result.RecordLimit===1">Single Record</span>
                    <span class="label label-primary" ng-if="result.RecordLimit!==1">Multi Record</span>
                    <span class="label label-default">{{result.UIType}}</span>
                </p>
                <p>Location: {{result.Tab}} &gt; {{result.Category}} &gt; {{result.Group}} &gt; {{result.Parameter}}</p>
                <p>XML Raw: 
                    <a style="cursor: pointer;" ng-if="result.RecordLimit!==1" ng-click="getgroupdetails(result.rGroup, result.Tab)">&lt;{{result.rGroup}}&gt;</a>
                    <span style="color: #337AB7" ng-if="result.RecordLimit===1">&lt;{{result.rGroup}}&gt;</span>
                    &#47; <span style="color: #337AB7">&lt;{{result.rParameter}}&gt;</span></p>
            </div>
        </div>
    </div>
<!-- Footer -->
    <div id="nav-footer">
        <p><a href="#top">Back to Top</a><span style="float:right;">Took {elapsed_time}s and {memory_usage} of Memory</span></p>
        <div class="footer" style="line-height: 10px;">Other Tools: <a href="./poslog">POSLog Search</a><a href="./users">User Search</a> | Other Sites: <a href="../RTI.html">RTI Cheatsheet</a><a href="../training/">AS Overview</a><span style="float: right;">Developed by<a target="_blank" href="https://github.com/remzaki">remzaki</a>&copy; 2016</span></div>
    </div>
</body>
</html>