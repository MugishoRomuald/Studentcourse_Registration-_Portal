<?php
  include('header.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Umoja Course registration Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="script.js"></script>
    <style>
      body{
    background-color: lightblue;
    font-family:poppins, sans-serif;
    text-align:center;
    margin:0;
    padding:0;
}

h1{
    color:white;
    font-weight: bold;
    padding:20px;
    margin-bottom:40px;
}

.container{
    width:100%;
    margin:auto;
    background: lightblue;);
    padding:30px;
    border-radius:10px;
    box-shadow:0px 0px 10px rgba(0,0,0,0.1);
}

#para{
    font-size:20px;
    color:#333;
    line-height:1.8;
}
#slogan{
    color: red;
    font-weight: bold;
}
div button{
    margin-top:30px;
}

.btn{
    background-color: #2D9CDB;
    color:white;
    border:none;
    padding:12px 30px;
    font-size:18px;
    border-radius:6px;
    cursor:pointer;
    margin-right:15px;
}

.btn:hover{
    background-color: green;
}
.slogan{
    color: ;
}
    </style>
  </head>
  <body>
    <h1>WELCOME TO UMOJA STUDENT COURSE REGISTRATION PORTAL</h1>
    <div class="container">
  <?php
    echo"<p id='para'>Umoja Student Course Registration Portal simplifies the course enrollment process, 
            allowing students to easily browse, register, and manage their courses online. 
            Our platform provides a seamless experience for both students and administrators, 
            ensuring efficient course management and real-time registration updates.</p>";
  ?>
<h6 class="slogan">Our Slogan</h6>
  <p><span id="slogan">Mfumo Mmoja, Fursa Zisizo na Mwisho</span> | One Portal Endless Opportunities</p>
</div>

<div>
<button onclick="go()" class="btn">Get Started</button>
</div>
<?php
//include("footer.php")
?>
  