$(document).ready(function(){

    $("#posalji").click(function(){
        console.log("usao");
        var validno = true;
        var gre=[];
        var ime = $("#imeK").val();
        var reIme = /^[A-z]{2,14}(\s[A-Z][a-z]{2,14})*$/;
        if(!reIme.test(ime)){
          validno = false;
        }
        var email = $("#mejlK").val();
        var reEmail =  /^\w+([\.\-]\w+)*@\w+([\.\-]\w+)*(\.\w{2,4})+$/;
        if(!reEmail.test(email)){
          validno = false;
        }
        var naslov = $("#naslov").val();
        if(naslov.length <1){
          validno = false;
        }
        var poruka=$("#poruka").val();
        if(poruka == ""){
          validno = false;
        }
        if(validno){
          $.ajax({
            url:"models/kontakt.php",
            method:"post",
            type:"json",
            data:{
              ime:ime,
              email:email,
              naslov:naslov,
              poruka:poruka,
              posalji: true
            },
            success: function(data){
              console.log("usao");
              //window.location.reload(true);
            },
            error: function(){
                alert("NEUSPESNO");
            }
          })
        }
      })
        

});