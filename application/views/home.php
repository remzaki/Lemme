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
    <script>$(document).ready(function(){$(function(){$('[data-toggle="tooltip"]').tooltip();});});</script>
</head>
<body>
    <!-- Navigation -->
    <nav id="nav-header" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <p class="navbar-brand" style="color: #fff">Lemme</p>
                <div class="navbar-text">
                    <a href="#">POSLog <span class="glyphicon glyphicon-chevron-down"></span></a>
                    <a href="#">Params <span class="glyphicon glyphicon-chevron-down"></span></a>
                    <a href="#">Users <span class="glyphicon glyphicon-chevron-down"></span></a>
                </div>
            </div>
            <div class="navbar-menu">
                
            </div>
        </div>
    </nav>
<!--    <ul>
        <li><a href="/lemme/poslog">POSLog</a></li>
        <li><a href="/lemme/params">Params</a></li>
        <li><a href="/lemme/users">Users</a></li>
    </ul>-->
</body>
</html>