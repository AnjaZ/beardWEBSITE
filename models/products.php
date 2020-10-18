<?php
//echo "tu sam";
    header("Content-type:application/json");
    include "../config/connection.php";
    if(isset($_POST["here"])){
        $value = $_POST["value"];
        $upit ="SELECT * FROM proizvodi p INNER JOIN slike s ON p.idSlike=s.idSlike WHERE idProizvoda=:id";
        $izvrsenje=$conn->prepare($upit); 
        $izvrsenje->bindParam(":id",$value);
        $rezultat=$izvrsenje->execute();
        $proizvodi=$izvrsenje->fetch();
        echo (json_encode($proizvodi));
    }
   
    