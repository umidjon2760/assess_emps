<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Саволлар буйича: 1019 <b>|</b>
    <span id = "saat" onload="currentTime()"></span>
    </div>
    <!-- Default to the left -->
    <strong>UNIVERSALBANK</strong>
</footer>
<script type="text/javascript">
    function currentTime() {
  let date = new Date(); 
  let hh = date.getHours();
  let mm = date.getMinutes();
  let ss = date.getSeconds();
  

   hh = (hh < 10) ? "0" + hh : hh;
   mm = (mm < 10) ? "0" + mm : mm;
   ss = (ss < 10) ? "0" + ss : ss;
    
   let time = hh + ":" + mm + ":" + ss ;

  document.getElementById("saat").innerHTML = time; 
  let t = setTimeout(function(){ currentTime() }, 1000); 

}

currentTime();
</script>
<style type="text/css">
    #saat
    {
        font-family: Century Gothic;
        /*font-size: 15pt;*/
        font-weight: bold;
        /*color: red;*/
    }
</style>