<!-- Muestra fecha y hora actual -->

<?php
$Fecha = date('d-m-Y');  
$Hora = date(' h:i:s ', time());  
//echo "The current date and time are $DateAndTime.";
$esta='nada';
?>

<?php //echo $Fecha; ?>
<div class="container p-4">
    <div class="row">
    <div class="col-md-5 mx-auto">    
        
        <div style="text-align:center;padding:1em 0;"> 
            <h4> <!-- <a style="text-decoration:none;" href="https://www.zeitverschiebung.net/es/city/3435910"></a> -->
            </h4> <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=medium&timezone=America%2FArgentina%2FBuenos_Aires&show=hour_minute" width="100%" height="110" frameborder="1" seamless></iframe> 
        </div>
    
    </div>
    </div>
</div>


<!-- SCRIPTS (pa que funcione Bootstrap)-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>


</body>
</html>