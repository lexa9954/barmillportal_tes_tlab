<div style="display:inline-flex; width:100%; place-content: space-between;">
    <div class="WH_right_column" id="column_review" style="width:700px; flex-grow: 0;">  	
          		<!-- Плитка с каталогом -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Галерея</div>
				        <div id="catalogCloseId" class="barClose">
                    			
				</div>
			</div>
			<div class="barContent" style="    height: 500px;" id="catalogContent">
                
                
                <!-- Slideshow container -->
                <div class="slideshow-container">

                  <!-- Full-width images with number and caption text -->
                  <div class="mySlides fade">
                    <div class="numbertext">1 / 6</div>
                    <img src="img/SPC/1.JPG" style="width:100%">
                  </div>
                    
                <div class="mySlides fade">
                    <div class="numbertext">2 / 6</div>
                    <img src="img/SPC/2.JPG" style="width:100%">
                  </div>
                    
                                      <div class="mySlides fade">
                    <div class="numbertext">3 / 6</div>
                    <img src="img/SPC/3.JPG" style="width:100%">
                  </div>
                    
                                      <div class="mySlides fade">
                    <div class="numbertext">4 / 6</div>
                    <img src="img/SPC/4.JPG" style="width:100%">
                  </div>
                    
                                      <div class="mySlides fade">
                    <div class="numbertext">5 / 6</div>
                    <img src="img/SPC/5.JPG" style="width:100%">
                  </div>
                    
                                      <div class="mySlides fade">
                    <div class="numbertext">6 / 6</div>
                    <img src="img/SPC/6.JPG" style="width:100%">
                  </div>


                  <!-- Next and previous buttons -->
                  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                  <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br>

                <!-- The dots/circles -->
                <div style="text-align:center">
                  <span class="dot" onclick="currentSlide(1)"></span>
                  <span class="dot" onclick="currentSlide(2)"></span>
                  <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                  <span class="dot" onclick="currentSlide(5)"></span>
                  <span class="dot" onclick="currentSlide(6)"></span>
                </div>
                
				<!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
			</div>
		</div> 
    </div>
    
<div style="width:300px;" class="WH_right_column" >  	
          		<!-- Плитка с каталогом -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Телеграмм боты</div>
				        <div id="catalogCloseId" class="barClose">
                
				</div>
			</div>
            
			<div class="barContent" style="max-height:500px;">
                
                <div class="barContent" style=" overflow:auto;display: flex;"  id="botsContent">
                   <img src="img/AMT_WH.jpg" style="max-width::50%;height: auto;">
                    <img src="img/AMT_Exam.jpg" style="max-width::50%;height: auto;">
                </div>
                
			</div>
            
		</div> 
    </div>


<div style="width:300px; flex-grow: 0; " class="WH_right_column" id="column_review">  	
          		<!-- Плитка с каталогом -->
		<div class="bar" id="catalog">
			<div class="barHeader">
				<div class="barLogo">
  					<?php	require "sklad/sys_img/catalog.svg";?>
				</div>
				<div class="barTitle">Новости</div>
				        <div id="catalogCloseId" class="barClose">
                
				</div>
			</div>
            
			<div class="barContent" style="max-height:500px;">
                
                <div class="barContent" style="height:80%; overflow:auto"  id="newsContent">
                    <!-- В данный блок интегрируется "tableGeneratorMaterials.php" посредством AJAX -->		
                </div>
                
                <?php
                if(!empty($_COOKIE['name'])){
                    echo "<div style=\"height:15%; margin-top: 25px;\">";
                    echo "<input id=\"text_news\" type=\"text\" style=\" width:100%\"></textarea>";
                    echo "<button class=\"knopka\" style=\"margin-top: 10px;\" onclick=\"add_news()\">Добавить новость</button>";
                    echo "</div>";
                }
                
                ?>
                
			</div>
            
		</div> 
    </div>
</div>
<script>
    $(document).ready(function(){
        DocumentReady();
        showSlides_auto();
    });
    
    function DocumentReady(){
            $.ajax({
               type: "POST",
               url: "interface/Generate_CentrContent.php",
               data: {page:'News'},
               success: function(result){
                   newsContent.innerHTML = result ;
               }
           });
    }
    function add_news(){
            $.ajax({
               type: "POST",
               url: "interface/Generate_CentrContent.php",
               data: {page:'add_news',text_news:text_news.value},
               success: function(result){
                   DocumentReady();
               }
           });
    }
    
    
    var slideIndex = 0;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
    


function showSlides_auto() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides_auto, 5000); // Меняйте изображение каждые 2 секунды
}
    
</script>