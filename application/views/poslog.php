<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app='PSApp'>
<head>
    <meta charset="utf-8">
    <title>Lemme - POSLogSearch</title>
    <link rel="shortcut icon" href="<?php echo base_url("lemme");?>/resources/img/poslog.ico" />
    <script src="<?php echo base_url("lemme");?>/resources/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/spin.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/angular.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/ng-infinite-scroll.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/app.js?ver=1.3"></script>
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/main.css">
    <script>var base_url='<?php echo base_url("lemme");?>';$(document).ready(function(){$(function(){$('[data-toggle="tooltip"]').tooltip();});$(function(){$('[data-toggle="popover"]').popover()})});
    function able(){
            var e = document.getElementById("table");
            var strUser = e.options[e.selectedIndex].text;
            document.getElementById("transtype").disabled = false;
            if(strUser!=="Transactions"){
//                DISABLE THE TRANSACTION TYPE DROPDOWN
                document.getElementById("transtype").disabled = true;
            }
        }
    </script>
</head>
<body ng-controller='POSLog' ng-init="base_url='<?php echo base_url("lemme");?>'">
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/lemme/home#poslog" style="color:#fff;"><span id="" class="glyphicon glyphicon-home" style="font-size:1.5em;line-height:20px;"></span></a>
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
    <!-- ConnSettings Modal -->
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
    <!-- ConnSettings Modal -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                ...
            </div>
        </div>
    </div>
    <!-- Form Inputs -->
    <div id="form">
        <div id="header-form2">
            <div class="filter-group">
                <form class="form-inline" ng-submit="search(table, store, term, trans, transtype)">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Table</span>
                            <select id="table" class="form-control" name="table" onchange="able()" ng-model="table">
                                <option value="Transactions"<?php echo set_select('table', 'Transactions', TRUE); ?>>Transactions</option>
                                <option value="ErrorQueue"<?php echo set_select('table', 'ErrorQueue'); ?>>ErrorQueue</option>
                                <option value="InputQueue"<?php echo set_select('table', 'InputQueue'); ?>>InputQueue</option>
                                <option value="OutputQueue"<?php echo set_select('table', 'OutputQueue'); ?>>OutputQueue</option>
                                <option value="PendingQueue"<?php echo set_select('table', 'PendingQueue'); ?>>PendingQueue</option>
                            </select>
                        </div>
                    </div> | 
                    <div class="form-group">
                            <input id="filters" type="text" class="form-control" placeholder="Store #" ng-model="store">
                        </div>
                    <div class="form-group">
                            <input id="filters" type="text" class="form-control" placeholder="Terminal #" ng-model="term">
                    </div>
                    <div class="form-group">
                            <input id="filters" type="text" class="form-control" placeholder="Trans #" ng-model="trans">
                    </div> | 
                    <div class="form-group">
                      <div class="input-group">
                            <span class="input-group-addon">Type</span>
                            <select id="transtype" class="form-control" name="transtype" onchange="able()" ng-model="transtype" ng-options="type.TransactionTypeID as type.TransactionTypeDescription for type in types">
                                <option value="">All</option>
                            </select>
                        </div>
                    </div>
                    <button id="search" type="submit" class="btn btn-primary">Search <span class="glyphicon glyphicon-refresh"></span></button>
                </form>
            </div>
        </div>
    </div>
    <!-- Results -->
    <i name="top" id="top"></i>
    <div id="result-body" class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <i name="top" id="top"></i>
                <table class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th ng-show="layout==='Transactions'">TransType</th>
                            <th id="transtypeid" ng-show="layout==='Transactions'">TransTypeId</th>
                            <th ng-show="layout==='Transactions'">Store</th>
                            <th id='terminal' ng-show="layout==='Transactions'">Terminal</th>
                            <th ng-show="layout!=='Transactions'">SequenceNumber</th>
                            <th ng-show="layout!=='Transactions'">TenantId</th>
                            <th>POSLog</th>
                            <th ng-show="layout==='ErrorQueue'">Error</th>
                            <th colspan='2' id="action">Action</th>
                        </tr>
                    </thead>
                    <tbody infinite-scroll="loadMore(table, store, term, trans, transtype)" infinite-scroll-disabled="busy" infinite-scroll-distance="0">
                        <tr ng-repeat="item in items" ng-click="setSelected(item.TranID)" ng-class="{active : item.TranID === idSelected}">
                            <td ng-show="layout==='Transactions'">{{item.TransType}}</td>
                            <td ng-show="layout==='Transactions'">{{item.TransTypeId}}</td>
                            <td ng-show="layout==='Transactions'">{{item.StoreId}}</td>
                            <td ng-show="layout==='Transactions'">{{item.TermId}}</td>
                            <td ng-show="layout!=='Transactions'">{{item.SequenceNumber}}</td>
                            <td ng-show="layout!=='Transactions'">{{item.TenantId}}</td>
                            <td><a target="_blank" ng-href="{{base_url}}/poslog/{{item.TranID}}">{{item.TranID}}</a></td>
                            <td ng-show="layout==='ErrorQueue'" id="error">{{item.Error}}</td>
                            <td style="text-align: center;">
                                <a target="_blank" class="btn btn-default" ng-href="{{base_url}}/poslog/{{item.TranID}}" data-toggle="tooltip" data-placement="bottom" title="Open" tooltip>
                                    <span style="position: initial;" class="glyphicon glyphicon-open"></span>
                                </a>
                                <a target="_blank" class="btn btn-default" ng-href="{{base_url}}/poslog/{{item.TranID}}?action=download" data-toggle="tooltip" data-placement="bottom" title="Download" tooltip>
                                    <span style="position: initial;" class="glyphicon glyphicon-download-alt"></span>
                                </a>
                            </td>
                        </tr>
                        <tr ng-show="empty"><td colspan="6" style='text-align:center;'>No Results Found</td></tr>
                        <tr ng-show="busy"><td colspan="6" style='text-align:center;'>Loading data...</td></tr>
                    </tbody>
                </table>
                <style>td{line-height: 2em;}</style>
            </div>
        </div>
    </div>
<!-- Footer -->
    <div id="nav-footer">
        <p><a href="#top">Back to Top</a><span style="float:right;">Took {elapsed_time}s and {memory_usage} of Memory</span></p>
        <div class="footer" style="line-height: 10px;">Other Tools: <a href="./params">Param Search</a><a href="./users">User Search</a> | Other Sites: <a href="../RTI.html">RTI Cheatsheet</a><a href="../training/">AS Overview</a><span style="float: right;">Developed by<a target="_blank" href="https://github.com/remzaki">remzaki</a>&copy; 2016</span></div>
    </div>
</body>
</html>