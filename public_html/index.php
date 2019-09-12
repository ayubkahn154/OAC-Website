<?php
include 'resources/templates/header.php';
?>

    <h1>Home</h1> <br> <br>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <div class="slideshow-container">

        <div class="mySlides fade">
            <img src="assets/windsor.png" style="width:100%">
            <div class="text">Windsor</div>
        </div>

        <div class="mySlides fade">
            <img src="assets/essex.png" style="width:100%">
            <div class="text">Essex</div>
        </div>

        <div class="mySlides fade">
            <img src="assets/chatham.png" style="width:100%">
            <div class="text">Chatham-kent</div>
        </div>

        <div class="mySlides fade">
            <img src="assets/leamington.png" style="width:100%">
            <div class="text">Leamington</div>
        </div>

    </div>
    <br>
    <p id="slogan">To provide a supportive and collaborative forum to enhance the delivery of Orientation services in Windsor, Essex and Chatham-Kent</p>
    <br>
    <script src="scripts/slideshow.js"></script>


<?php include 'resources/templates/footer.php'; ?>