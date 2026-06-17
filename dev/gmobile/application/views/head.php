<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GMobile </title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
<meta name="description" content="Apps and Webs">
  <meta name="keywords" content="Apps and Webs">
  <meta name="author" content="Gabriel Ochoa">
    <meta http-equiv="pragma" content="no-cache" />
  <meta name="google" content="notranslate">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>images/icons/icon-72x72.png">
<link rel="apple-touch-icon" sizes="96x96" href="<?php echo base_url(); ?>images/icons/icon-96x96.png">
<link rel="apple-touch-icon" sizes="128x128" href="<?php echo base_url(); ?>images/icons/icon-128x128.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>images/icons/icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>images/icons/icon-152x152.png">
<link rel="apple-touch-icon" sizes="192x192" href="<?php echo base_url(); ?>images/icons/icon-192x192.png">
<link rel="apple-touch-icon" sizes="384x384" href="<?php echo base_url(); ?>images/icons/icon-384x384.png">
<link rel="apple-touch-icon" sizes="512x512" href="<?php echo base_url(); ?>images/icons/icon-512x512.png">

<link rel="manifest" href="<?php echo base_url(); ?>manifest.json">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="application-name" content="GMobile">
<meta name="apple-mobile-web-app-title" content="GMobile">
<meta name="theme-color" content="#2d0659">
<meta name="msapplication-navbutton-color" content="#2d0659">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="msapplication-starturl" content="/">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!--<link rel="manifest" href="<?php echo base_url(); ?>manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo base_url(); ?>images/icons/icon-144x144.png">
<meta name="theme-color" content="#ffffff">-->
    <link href="<?php echo base_url(); ?>material-icons/material-icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootadmin-master/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootadmin-master/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>jquery-datatables-checkboxes/css/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>jquery-datatables-checkboxes/css/dataTables.checkboxes.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootadmin-master/css/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootadmin-master/css/bootadmin.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>alert/themes/alertify.core.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>alert/themes/alertify.default.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>Material-DateTimePicker-master/dist/css/materialDateTimePicker.css" />

    <link rel="stylesheet" href="<?php echo base_url(); ?>jquery-ui-1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sweetalert/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>fontawesome/css/all.min.css">
    
<link rel="stylesheet" href="<?php echo base_url(); ?>DataTables/DataTables-1.10.20/css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="<?php echo base_url(); ?>DataTables/Scroller-2.0.1/css/scroller.dataTables.min.css">
<!--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">-->
    <style type="text/css">
        .dt-right{
            text-align: right;
        }

 td.details-control {
    background: url('<?php echo base_url(); ?>images/details_open.png') no-repeat center center;
    cursor: pointer;
}
td.details-control2 {
    background: url('<?php echo base_url(); ?>images/details_edit.png') no-repeat center center;
    cursor: pointer;
}
td.details-control3 {
    background: url('<?php echo base_url(); ?>images/details_delete.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('<?php echo base_url(); ?>images/details_close.png') no-repeat center center;
}

    @keyframes spinner {
  to {transform: rotate(360deg);}
}
 
.spinner:before {
  content: '';
  box-sizing: border-box;
  position: absolute;
  top: 50%;
  left: 45%;
  width: 50px;
  height: 50px;
  margin-top: -10px;
  margin-left: -10px;
  border-radius: 50%;
  border: 4px solid #ccc;
  border-top-color: #333;
  animation: spinner .6s linear infinite;
  z-index: 99999;
}

@media all and (max-width: 750px){
    .btnderecha{
        float: right;
    }
}

.subir{
    padding: 8px 10px;
    background: #FF0000;
    color:#fff;
    border:0px solid #fff;
    border-radius: .25rem;
}
 
.subir:hover{
    color:#fff;
    background: #DF0101;
}

.bg-opacity-8 {
    background-color: rgba(255,255,255,.8);
}

.sidebarv9{
  background-image: url('<?php echo base_url();?>images/sidebar1.jpg');
  background-repeat: no-repeat;
    background-size: cover;
}

.barrav9{
   background: rgb(19,12,54);
   background: linear-gradient(90deg, rgba(19,12,54,1) 0%, rgba(45,6,89,1) 35%, rgba(75,8,124,1) 100%); 
}

    </style>
 <link rel="stylesheet" href="<?php echo base_url(); ?>bootadmin-master/css/style_splash.css">
 <script src="<?php echo base_url(); ?>pace/pace.js"></script>
    <link href="<?php echo base_url(); ?>pace/themes/pink/pace-theme-minimal.css" rel="stylesheet" />
</head>
</head>