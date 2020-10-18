$(document).ready(function(){

    $(".addcardmore").click(function(e){
        e.preventDefault();
        let vrednost=$(this).data('id');
        let kolicina=parseInt($("#quantity").val());
        $.ajax({
            url:"models/products.php",
            method:"POST",
            dataType:"text",
            data:{
              value:vrednost,
              here:true
            },
            success:function(data){
                let podaci=JSON.parse(data);
                console.log(podaci);
                addToOrder(podaci.idProizvoda, podaci.putanja, podaci.naziv, podaci.cena,kolicina);
                location.reload();
            },
            error:function(xhr, error, status){
                console.log("greskeeeee");
               
            }
        });
        
    })

    if(narudzbe==null){
        let ispis=`<p class="prazna"> Vaša korpa je prazna </p> <a href="index.php?page=Prodavnica" class="prodavnica"> Prodavnica </a>`;
        $(".prazna").html(ispis);
        let ispis2=`<span>Ukupno</span>
        <span>0 Din</span>`;
        $(".total-price").html(ispis2);
        $(".dugme").css("display","none");
    }
    else{
        korpa(narudzbe);
        let cena=totalPrice(narudzbe);
        let ispis=`<span>Ukupno</span>
        <span>${cena} Din</span>`;
        $(".total-price").html(ispis);
    }

    $(".kolicinaNova").blur(function(){
        let vrednost= $(this).val();
        let idProizvoda=$(this).data('idp');
        updateOrder(narudzbe,vrednost,idProizvoda);
        location.reload();

    })

    $(".obrisi").click(function(e){
        e.preventDefault();
        let vrednost= $(this).data('id');

        deleteOrder(vrednost);
        location.reload();
    })

    
    //REGULARNI NARUDZBINA
    $("#zavrsi").click(function(e){
        e.preventDefault();
        var ime=$("#ime").val();
        var prezime=$("#prezime").val();
        var grad=$("#grad").val();
        var brojP=$("#pb").val();
        var ulica=$("#ulica").val();
        var brojS=$("#brojStana").val();
        var brojT=$("#brojTelefona").val();
        var mejl=$("#mejl").val();
        var inf=$("#inf").val();
        
        //console.log(ime,prezime,grad, brojP, ulica, brojS, brojT, mejl);

        //ime
        var regUser=/^[ČĆŠĐŽA-zčćšđž]{1,40}$/;
        //Prezime
        /*EMAIL */
        var regEmail=/^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/;
        /*PASS REG */
        //var regPass=/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        /* Grad */
        var regCty=/^[ČĆŠĐŽA-zčćšđž]+([\s-]?[ČĆŠĐŽA-zčćšđž]+)*$/;
        /* Ulica i broj*/
        var regAdr=/^[ČĆŠĐŽA-zčćšđž]+(\s+[ČĆŠĐŽA-zčćšđž0-9]+)*$/;
        /*ZIP CODE */
        var regZip=/^\d{5}(?:[-\s]\d{4})?$/;
        /*Apartman*/
        var regApt=/^[A-z\d\s]+$/;   
        /*Telefon*/
        var regTel=/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]+$/;

        /* Provera  */
        var resUser = regUser.test(ime);
        var resSurname = regUser.test(prezime);
        var resEmail=regEmail.test(mejl);
        var resGrad=regCty.test(grad);
        var resAdr=regAdr.test(ulica);
        var resZip= regZip.test(brojP);
        var resApt=regApt.test(brojS);
        var resTel= regTel.test(brojT);

        let error=0;
        
        if(resUser!=true){
            $("#imeLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#imeLabel").css("color","#fff");
            error+=0;
        }
        if(resSurname!=true){
            $("#preLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#preLabel").css("color","#fff");
            error+=0;
        }
        if(resEmail!=true){
            $("#mejlLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#mejlLabel").css("color","#fff");
            error+=0;
        }
        if(resGrad!=true){
            $("#gradLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#gradLabel").css("color","#fff");
            //error=true;
        }
        if(resZip!=true){
            $("#pbLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#pbLabel").css("color","#fff");
            //error=true;
        }
        if(resAdr!=true){
            $("#ulicaLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#ulicaLabel").css("color","#fff");
            //error=true;
        }
        if(resTel!=true){
            $("#brojLabel").css("color","#dc3545");
            error+=1;
        }else{
            $("#brojLabel").css("color","#fff");
            //error=true;
        }
        if($("input:radio[name='placanje']").prop("checked") == true){
            $("#plati").css("color","#fff");
            //error=true;
        }else{
            $("#plati").css("color","#dc3545");
            error+=1;
        }console.log(error);
        
        if(error==0){
            //console.log("usao u ajax");
            $.ajax({
                url:"models/InsertKor.php",
                method:"POST",
                data:{
                    ime:ime,
                    prezime:prezime,
                    grad:grad,
                    brojP:brojP,
                    ulica:ulica,
                    brojT:brojT,
                    brojS:brojS,
                    mejl:mejl,
                    insertKor:true,
                    narudzbe,
                    napomena:inf
                    
                },
                success: function(data, textStatus, xhr){
                    console.log("UPISAO SAM");
                    //console.log(xhr.status);
                    if(xhr.status == 200){
                        console.log("code uso SAM");
                        deleteCart();
                    }
                    console.log (data);
                    window.location.reload(true);
                },
                error: function(){
                    alert("NEUSPESNO");
                }
            })
        }
    })
    

});

function korpa(data){
    let ispis=``;
    data.forEach(element => {
        ispis+=`
        <tr class="text-center">
        <td class="product-remove"><a href="#" class='obrisi' data-id=${element.idProizovda}><span class="icon-close"></span></a></td>
        
        <td class="image-prod"><div class="img" style="background-image:url(assets/images/${element.putanjaMS});"></div></td>
        
        <td class="product-name">
            <h3>${element.nazivProizvoda}</h3>
          
        </td>
        
        <td class="price">${element.cenaSaPopustom}din</td>
        
        <td class="quantity">
            <div class="input-group mb-3">
            <input type="text" name="quantity" class="quantity form-control input-number kolicinaNova" value="${element.kolicina}" data-idp="${element.idProizovda}" min="1" max="100">
        </div>
        </td>
        
        <td class="total">${element.cenaSaPopustom * element.kolicina}</td>
        </tr>
        `;
    });
    $("#cart").html(ispis);

}


