
<div id="creatorWHpage" style="background: white;padding: 10px;width: 97%;">
    <div id="aggregateContainer" >

    </div>
</div>

<script type="text/javascript">

    start();
    
    function start(){
        $.ajax({
               type: "POST",
               url: "sklad/ierarhyRequest.php",
               data: {action:'genIerarhy'},
               success: function(result){
                   $( "#aggregateContainer" ).html( result );
               }
           });
    }
    
    function addNewArea(){
         var area_name = document.querySelector("#addAreaText").value; 
        $.ajax({
               type: "POST",
               url: "sklad/ierarhyRequest.php",
               data: {action:'addArea',areaName:area_name},
               success: function(result){
                   //alert(result);
                   start();
               }
           });
    }
    
    function addNewAggr(id){
        var aggr_name = document.querySelector("#aggr_"+id).value; 
        $.ajax({
               type: "POST",
               url: "sklad/ierarhyRequest.php",
               data: {action:'addAggr',areaId:id, aggrName:aggr_name},
               success: function(result){
                   //alert(result);
                   start();
               }
           });
    }
    function addNewPlace(id){
        var place_name = document.querySelector("#place_"+id).value; 
        $.ajax({
               type: "POST",
               url: "sklad/ierarhyRequest.php",
               data: {action:'addPlace',placeId:id, placeName:place_name},
               success: function(result){
                   //alert(result);
                   start();
               }
           });
    }
    
</script>