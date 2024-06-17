<!DOCTYPE html>
<html lang="fr">
<?php 
session_name('personnel');
  session_start();
?>

  <head>
    <!-- Required meta tags -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/bootstrap.bundle.min.js"></script>
       <link href="asset/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
       <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> -->


    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">-->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
<link href="asset/css/all.css" rel="stylesheet" crossorigin="anonymous">
<link rel="stylesheet" href="css/material-icons.css">
<!-- <link rel="stylesheet" href="css/notification.css"> -->
<link rel="stylesheet" href="css/preloader.css" >
<link rel="stylesheet" href="css/toast.css">
<link rel="stylesheet" href="css/notifi.css">




<script type="text/javascript" src="js/excellentexport.js"></script>

   <!-- hide show columns plugin -->
<script src="js/hide_cols.min.js"></script>
<script src="js/jquery.sortElements.js"></script>
<script src="asset/js/jquery.dataTables.min.js" ></script>
<script src="asset/js/dataTables.bootstrap5.min.js" ></script>
<link rel="stylesheet" href="asset/css/dataTables.bootstrap5.min.css" > 

<script type="text/javascript" src="tableExport/jquery.base64.js"></script>

<script src="asset/js/jquery.validate.min.js"></script>

<script type="text/javascript">
  
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();




</script>
<style type="text/css">
  .container {
  margin: 0 auto;
  width: 100%;
  max-width:100%;
}
table th {
    width: auto !important;
}
</style>
</head>