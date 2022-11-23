<style>
* {
    box-sizing: border-box
}

/* body {
    font-family: Verdana, sans-serif;
    margin: 0
} */

.mainSlides {
    display: none
}

img {
    vertical-align: middle;
}

/* Slideshow container */
.main-slideshow-container {
    /* max-width: 1000px; */
    position: relative;
    margin: auto;
}

/* Next & previous buttons */
.main-slide-prev,
.main-slide-next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

/* Position the "next button" to the right */
.main-slide-next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.main-slide-prev:hover,
.main-slide-next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Caption text */
.main-slide-text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
}

/* The dots/bullets/indicators */
.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active,
.dot:hover {
    background-color: #717171;
}

/* Fading animation */
.main-slide-fade {
    animation-name: fade;
    animation-duration: 1.5s;
}

@keyframes main-slide-fade {
    from {
        opacity: .4
    }

    to {
        opacity: 1
    }
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {

    .main-slide-prev,
    .main-slide-next,
    .main-slide-text {
        font-size: 11px
    }
}

</style>
<div id="ad-banner">
    <div class="main-slideshow-container">
        <div class="mainSlides main-slide-fade">
            <img src="{{ asset('storage/test/test1.jpg') }}" style="width:100%">
            <div class="main-slide-text">Caption one</div>
        </div>

        <div class="mainSlides main-slide-fade">
            <img src="{{ asset('storage/test/test2.jpg') }}" style="width:100%">
            <div class="main-slide-text">Caption Two</div>
        </div>

        <div class="mainSlides main-slide-fade">
            <img src="{{ asset('storage/test/test3.jpg') }}" style="width:100%">
            <div class="main-slide-text">Caption Three</div>
        </div>

        <a class="main-slide-prev" style="text-decoration:none;" onclick="plusSlides(-1)">❮</a>
        <a class="main-slide-next" style="text-decoration:none;" onclick="plusSlides(1)">❯</a>

    </div>
    <br>

    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <script>
        let slideIndex = 0;
        showSlides(slideIndex);
        setAutoSlides();

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mainSlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";

        }

        function setAutoSlides() {
            let i;
            let slides = document.getElementsByClassName("mainSlides");
            let dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            setTimeout(setAutoSlides, 4000);
        }
    </script>
</div>
