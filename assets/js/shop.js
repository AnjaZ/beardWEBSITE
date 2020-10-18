$(document).ready(function(){

    $(".addtocart").click(function(e){
        e.preventDefault();
        let vrednost=$(this).data('id');
        let akcija=$(this).data('akcija');
        

        shop(vrednost,akcija);
        
    })


     
});

function shop(value,akcija=null){
    console.log(value);
    $.ajax({
        url:"models/products.php",
        method:"POST",
        dataType:"text",
        data:{
          value:value,
          here:true
        },
        success:function(data){
            let podaci=JSON.parse(data);
            console.log(podaci);
            addToOrder(podaci.idProizvoda, podaci.putanja, podaci.naziv, podaci.cena)
            if(akcija!=null)
            {
                window.location.href = "/beard/index.php?page=Checkout";
            }
            else
            {
                location.reload();
            }    
        },
        error:function(xhr, error, status){
            console.log("greskeeeee");
           
        }
    });
  }

 //Fje za rad sa localstorage
function ordersIn()
{
    return JSON.parse(localStorage.getItem("korpa"));
}
function numberOfOrders(data)
{
    var brKolicina=0;
    data.forEach(function(elem){
        brKolicina=brKolicina+Number(elem.kolicina);
    })
    return brKolicina;
}
function totalPrice(data)
{
    var ukupnaCena=0;
    data.forEach(function(elem){
        ukupnaCena=ukupnaCena+(elem.kolicina*elem.cenaSaPopustom);
    })
    
    return Number(ukupnaCena);
}


//Glavna fja
function addToOrder(idProizvoda,putanjaSlike,nazivP,cenaPopust,kolicina=null)
{
    var idProizovda=idProizvoda;
    var putanjaMS=putanjaSlike;
    var nazivProizvoda=nazivP;
    var cenaSaPopustom=cenaPopust;
    var kolicina=kolicina;
    
    var order=ordersIn();
    if(order)
    {
        addToLocal(idProizovda,putanjaMS,nazivProizvoda,cenaSaPopustom,kolicina);
    }
    else
    {
        makeFirstOrder(idProizovda,putanjaMS,nazivProizvoda,cenaSaPopustom,kolicina);
    }




    function addToLocal(idProizovda,putanjaMS,nazivProizvoda,cenaSaPopustom,kolicina)
    {
        let orders=ordersIn();
        var duplikat=1;

        orders.forEach(function(elem){
            if(elem.idProizovda==idProizovda)
            {
                if(kolicina==null)
                {
                    elem.kolicina=elem.kolicina+1;
                }
                else
                {
                    elem.kolicina=Number(elem.kolicina)+kolicina;
                }
                duplikat=elem.kolicina;
            }
        })
        if(duplikat==1)
        {
            let orderJson=
            {
                "idProizovda":idProizovda,
                "putanjaMS":putanjaMS,
                "nazivProizvoda":nazivProizvoda,
                "cenaSaPopustom":cenaSaPopustom,
                "kolicina":1
            }
            orders.push(orderJson);
        }
        localStorage.setItem("korpa",JSON.stringify(orders));

    }

    function makeFirstOrder(idProizovda,putanjaMS,nazivProizvoda,cenaSaPopustom,kolicina)
    {
        let orders=[];
        if(kolicina==null)
        {
            orders[0]=
            {
                "idProizovda":idProizovda,
                "putanjaMS":putanjaMS,
                "nazivProizvoda":nazivProizvoda,
                "cenaSaPopustom":cenaSaPopustom,
                "kolicina":1
            };
        }
        else
        {
            orders[0]=
            {
                "idProizovda":idProizovda,
                "putanjaMS":putanjaMS,
                "nazivProizvoda":nazivProizvoda,
                "cenaSaPopustom":cenaSaPopustom,
                "kolicina":kolicina
            };
        }
        localStorage.setItem("korpa",JSON.stringify(orders));
    }
}
function deleteOrder(idProizvoda)
{
    var narudzbe=ordersIn();
    var rezultat=narudzbe.filter(function(elem){
        if(elem.idProizovda!=idProizvoda)
        {
            return elem;
        }
    });
    
    
    localStorage.setItem("korpa",JSON.stringify(rezultat));

    if(rezultat.length==0)
    {
        location.reload();
        deleteCart();
    }
    return false;
}
function updateOrder(data,novaKolicina,idP)
 {
	 var rez=data.filter(function(elem){

		 if(elem.idProizovda==idP)
		 {
			 elem.kolicina=Number(novaKolicina);
		 }
		 return elem;
	 })

	 localStorage.setItem("korpa",JSON.stringify(rez));
 }
function deleteCart()
{
    localStorage.removeItem("korpa");
}



//Inicijalno prikazivanje korpe


var narudzbe=ordersIn();

if(narudzbe!=null && narudzbe.length>0)
{
    var brojNaru=numberOfOrders(narudzbe);
    var ukupnaCena=totalPrice(narudzbe);  
    $(".brojukorpi").html(brojNaru);
}
else
{
    prikaziKorpu(0,"0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")
    prikazHoverKorpePrazna();
}