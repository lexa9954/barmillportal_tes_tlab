<div id="debug"></div>


<div id="creatorWHpage" style="background: white;padding: 10px;width: 97%;">
    <div class="createWarehouse" >
        <h1 >Имя склада</h1>
        <input type="text" id="nameWH"/>
        <hr>
        <h1 >Количество стелажей</h1>
        <input type="text" id="countRfield"/>
        <input type="button"  value="Далее" onclick="createStelaj()"/>
        <div style="padding: 0 50px;" id="rack_cont"></div>
        <br>
        <a href="/SOFT/app.config" download>скачать</a>
        <input type="button" class="knopka"  value="СОЗДАТЬ СКЛАД" onclick="addWareHouse()"/>

    </div>
</div>

<script>
    var cr; //Количество стелажей
    
    const polki = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L","M","N","O","P","Q","R","S","T","U","W","X","Y","Z"];
    
    function createStelaj(){
        var countR = document.getElementById('rack_cont');
        var countRfield = document.getElementById('countRfield');
        cr = countRfield.value;
        var creater = "";
        
        for(var i=0;i<cr;i++){
            creater += "<div style=\"border-style: solid; padding: 50px; margin: 10px 0\">";
            creater +="<h1 >Имя стелажа</h1>";
            creater += "<input type=\"text\" id=\"nameRack"+i+"\"/><br>";
            creater +="<h1 >Количество полок</h1>";
            creater += "<input type=\"text\" id=\"countPfield"+i+"\"/><br>";  
            creater += "<input type=\"button\"  value=\"Далее\" onclick=\"createPolki("+i+")\"/>"; 
            
            creater += "<div style=\"padding: 0 50px;\" id=\"polki_cont"+i+"\"></div><br>";
            creater += "<input type=\"button\" style=\"margin: inherit;\"  value=\"предварительный просмотр\" onclick=\"createVisualRack("+i+")\"/>"; 
            
            creater +="<div style=\"border-style: solid; width:300px; height:300px; text-align: -webkit-center;\" id=\"rack_"+i+"\"></div><br>";
            
            creater +="</div>";
            
            countR.innerHTML = creater;
        }
        
    }
    
    function createPolki(id){
        var countP = document.getElementById('polki_cont'+id);
        var countPfield = document.getElementById('countPfield'+id);
        var cp=countPfield.value;
        var creater = "";
        
        for(var i=0;i<cp;i++){
            creater +="<h1 >Полка "+polki[i]+"</h1>";
            creater += "<div style=\"padding: 0 50px;\">";
            creater +="<h1 >Количество мест</h1>";
            creater += "<input type=\"text\" id=\"maxMfield"+id+"_"+i+"\"/><br>";   
            creater +="</div>";
            
            countP.innerHTML = creater;
        }
        
    }
    
    function createVisualRack(id){
        var oldDiv = document.getElementById('rack_'+id);
        var countPfield = document.getElementById('countPfield'+id);
        var cp=countPfield.value;
        oldDiv.innerHTML = '';
        
        for(var i=0;i<cp;i++){
            var element = document.createElement("ul");
            element.classList.add('rack');
            element.style.height = 290/cp+"px";
            
            var countMfield = document.getElementById('maxMfield'+id+"_"+i);
            var cm = countMfield.value;
            for(var j=0;j<cm;j++){
                element.innerHTML += "<li style=\"width:"+(290/cm)+"px; vertical-align: middle;\">"+polki[i]+(j+1)+"</li>";
            }
            

            oldDiv.appendChild(element);
        }

    }
    
    function addWareHouse(){
        var wh_name = document.getElementById("nameWH").value;
        var count_rack = document.getElementById("countRfield").value;
        
        var wh_id;
        
        $.ajax({
          type: "POST",
          url: "sklad/CreateWH.php",
          data: {action:'addWH',whName:wh_name},
          success: function(result){
             wh_id = result;
                      for(var i =0;i<count_rack;i++){
                        var rack_name = document.getElementById("nameRack"+i).value;
                        var cp = document.getElementById("countPfield"+i).value;
                          var mesto_str ="";
                        for(var j=0;j<cp;j++){
                            mesto_str += document.getElementById("maxMfield"+i+"_"+j).value +"_";
                        }
                          mesto_str = mesto_str.slice(0, -1);
                        $.ajax({
                          type: "POST",
                          url: "sklad/CreateWH.php",
                          data: {action:'addRack',whId:wh_id,rackName:rack_name,shelvesCount:cp,mestoStr:mesto_str},
                          success: function(result){
                             console.log(result);
                              alert("ГОТОВО✅");
                            }
                          });

                    }
              
            }
          });
        

        
        
        
    }
</script>