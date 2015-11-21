<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
    <meta charset="utf-8">
    <title>Lemme - Home</title>
    <link rel="shortcut icon" href="<?php echo base_url("lemme");?>/resources/img/lemme.ico" />
    <script src="<?php echo base_url("lemme");?>/resources/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/angular.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url("lemme");?>/resources/js/app.js"></script>
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("lemme");?>/resources/css/home.css">
    <script>$(document).ready(function(){$(function(){$('[data-toggle="tooltip"]').tooltip();});});$('body').scrollspy({ target: '#spyhere' })</script>
</head>
<body data-spy="scroll" data-target="#spyhere">
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div id="spyhere" class="navbar-header">
                <p class="navbar-brand" style="color: #fff">Lemme</p>
            </div>
            <div id="spyhere">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a href="#poslog">POSLog</a></li>
                    <li><a href="#params">Params</a></li>
                    <li><a href="#users">Users</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="poslog">
        <div class="apps">
            <div class="apps-background">
                <div class="jumbotron">
                    <h1>PosLog Search</h1>
                    <p>Search POSLog to the Database and verify.</p>
                    <p><a class="btn btn-primary btn-lg" href="/lemme/poslog" role="button">Go to Site <span class="glyphicon glyphicon-circle-arrow-right"></span></a></p>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">1</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Connect to a Server</h4>
                      Server must be the Database Server of your setup
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">2</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Use Filters</h4>
                      To narrow down search results
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">3</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">View POSLog</h4>
                      View the POSLog in the browser
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">4</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Download POSLog</h4>
                      Download the XML file
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="params">
        <div class="apps">
            <div class="apps-background">
                <div class="jumbotron">
                    <h1>Parameter Search</h1>
                    <p>Search Parameter details and various parameter related informations.</p>
                    <p><a class="btn btn-primary btn-lg" href="/lemme/params" role="button">Go to Site <span class="glyphicon glyphicon-circle-arrow-right"></span></a></p>
                </div>
                <div class="media">
                    <div class="media-left">
                        <span class="">1</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Default Server Connection</h4>
                      By default there will be a pre-configured server connection. Anyone may update this.
                    </div>
                </div>
                <div class="media">
                    <div class="media-left">
                        <span class="">2</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Results</h4>
                      Results will be automatically loaded
                    </div>
                </div>
                <div class="media">
                    <div class="media-left">
                        <span class="">3</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Searching</h4>
                      Input any information of the Parameter to search
                    </div>
                </div>
                <div class="media">
                    <div class="media-left">
                        <span class="">4</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Parameter Informations</h4>
                      Clink the name of the parameter to view different parameter informations including Default Values
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="users">
        <div class="apps">
            <div class="apps-background">
                <div class="jumbotron">
                    <h1>User Search</h1>
                    <p>Search Users for statuses and informations.</p>
                    <p><a class="btn btn-primary btn-lg" href="/lemme/users" role="button">Go to Site <span class="glyphicon glyphicon-circle-arrow-right"></span></a></p>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">1</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Connect to a Server</h4>
                      Server must be the Database Server of your setup
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">2</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Org Unit or Store Number</h4>
                      Specify your Organizational Unit or Store Number
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">3</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">User Status</h4>
                      Specify your Organizational Unit or Store Number
                    </div>
                </div>
                <div class="media">
                    <div class="media-left media-top">
                        <span class="">4</span>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">Unlocking</h4>
                      You may unlock a user that is currently locked
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>