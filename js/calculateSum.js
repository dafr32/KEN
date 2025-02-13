function calculateSum(idTeacher) {
    var kontener = document.querySelector("#TeacherNadgodziny-ID"+idTeacher); 
    // console.log("#TeacherNadgodziny-ID"+idTeacher);                  
    var kl4 = kontener.querySelector("#kl4").value || 0;            
    var ileTygOkres = kontener.dataset.iletygokres;
    //wolne - blokowanie dnia
    for (var week = 1; week <= ileTygOkres; week++) {
        for (var i = 1; i <= 5; i++) {
            var element = kontener.querySelector("#wolne"+week + "-" + i);
            
            if (element){                   
                if (element.value !="") {               
                    element.classList.add("wolne");                    
                    kontener.querySelector("#planowe" + week + "-" + i).classList.add("wolne");
                    kontener.querySelector("#norma" + week + "-" + i).classList.add("wolne");                        
                    kontener.querySelector("#realizacja" + week + "-" + i).classList.add("wolne");
                    kontener.querySelector("#realizacja" + week + "-" + i).textContent = 0;                        

                    kontener.querySelector("#tdDorazne" + week + "-" + i).classList.add("wolne");
                    kontener.querySelector("#dorazne" + week + "-" + i).value = 0;
                    kontener.querySelector("#dorazne" + week + "-" + i).disabled = true;

                    kontener.querySelector("#tdIndyw" + week + "-" + i).classList.add("wolne");
                    kontener.querySelector("#indyw" + week + "-" + i).value = 0;
                    kontener.querySelector("#indyw" + week + "-" + i).disabled = true;

                    kontener.querySelector("#tdInne" + week + "-" + i).classList.add("wolne");
                    kontener.querySelector("#inne" + week + "-" + i).value = 0;
                    kontener.querySelector("#inne" + week + "-" + i).disabled = true;

                }else {
                    element.classList.remove("wolne");
                    kontener.querySelector("#planowe" + week + "-" + i).classList.remove("wolne");
                    kontener.querySelector("#norma" + week + "-" + i).classList.remove("wolne");  
                    kontener.querySelector("#realizacja" + week + "-" + i).classList.remove("wolne");  
                    
                    kontener.querySelector("#tdDorazne" + week + "-" + i).classList.remove("wolne");
                    kontener.querySelector("#tdIndyw" + week + "-" + i).classList.remove("wolne");
                    kontener.querySelector("#tdInne" + week + "-" + i).classList.remove("wolne");
                    kontener.querySelector("#dorazne" + week + "-" + i).disabled = false;
                    kontener.querySelector("#indyw" + week + "-" + i).disabled = false;
                    kontener.querySelector("#inne" + week + "-" + i).disabled = false;
                }
            }
        }
    }
            

    // -------------------------------------------------------------------------    
    // godziny planowe - tabela tydzień

    // for (var week = 1; week <= ileTygOkres; week++) {
    //     for (var d = 1; d <= 5; d++) {
    //         kontener.querySelector("#planowe" + week + "-" + d).textContent = kontener.querySelector("#d" + d).value;                
    //     }
    // }
   


    // -------------------------------------------------------------------------    
    // PLAN LEKCJI - tabelka główna
    // -------------------------------------------------------------------------    
    // suma godzin planowanych na tydzień - plan lekcji główny
    var inputFields = kontener.getElementsByClassName("day");
    var totalSum = 0;
    var ileDni = 0;
    for (var i = 0; i < inputFields.length; i++) {
        var g = parseInt(inputFields[i].value) || 0;            
        if (g > 0) ileDni++;
        totalSum += g;            
    }
    
    kontener.querySelector("#ileGodzin").textContent = totalSum;    
    
    // ile nadgodzin Plan
    var etat = parseInt(kontener.querySelector("#etatPlan").value);            
    var setNadg = 0;
    if (totalSum < etat)
        setNadg = 0;
    else
        setNadg = (totalSum - etat);

    // norma w ustawieniach
    kontener.querySelector("#setNadg").textContent = setNadg;

    // norma Plan
    var normaG = 0;
    if( ileDni > 0 ){
        normaG =  etat / ileDni;                         
    }
    
    // norma w ustawieniach 
    kontener.querySelector("#setNorma").textContent = normaG;

    // -------------------------------------------------------------------------        
    //  DANE w tabelkach tygodni
    // -------------------------------------------------------------------------    
    
    // var normaClasses = kontener.querySelectorAll(".zmiana");
    // for (var i = 0; i < normaClasses.length; i++) {
    //     var normaElements = normaClasses[i].querySelectorAll(".norma"); // Use querySelectorAll to get all elements with class .norma
    //     for (var j = 0; j < normaElements.length; j++) { // Loop through each .norma element
    //         normaElements[j].textContent = normaG; // Set the textContent of each .norma element
    //         // console.log("norma:" + normaG);
    //     }
    // }

              
    // suma norm w tygodniach
    // for (var week = 1; week <= ileTygOkres; week++) {        
    //     var etatElement = document.getElementById("etat-" + week);

    //     var totalEtat = etatElement.value;  
    //     console.log("etat:"+totalEtat);      
    //     document.querySelector("#sumaNorma" + week).textContent = totalEtat;
    // }
    

    // -------------------------------------------------------------------------    
    // suma godzin wypracowanych na tydzień - w tabelce

    var kontener = document.querySelector("#TeacherNadgodziny-ID"+idTeacher);     //cała strona formularza
    // var ileTygOkres = document.querySelectorAll(".tabelaTydzen").length;
    // console.log("ile:" + ileTygOkres);
    for (var week = 1; week <= ileTygOkres; week++) {
        var sumaZreal = 0;
        var z = 0.0;
        for (var d = 1; d <= 5; d++) {
            sumaZreal += parseInt(kontener.querySelector("#planowe" + week + "-" + d).value); 
        }
        kontener.querySelector("#sumaPlanowe" + week).textContent = parseInt(sumaZreal);                  
    }


    // -------------------------------------------------------------------------
    // Godziny zrealizowane   
    var kontener = document.querySelector("#TeacherNadgodziny-ID"+idTeacher);     //cała strona formularza
    for (var week = 1; week <= ileTygOkres; week++) {
        var sumaZreal = 0;
        var z = 0.0;
        for (var d = 1; d <= 5; d++) {

            var wolne = kontener.querySelector("#wolne" + week + "-" + d);                        
            var wypracowane = kontener.querySelector("#planowe" + week + "-" + d).value;              
            var norma = kontener.querySelector("#norma" + week + "-" + d).textContent;              
            var zrealizowane = kontener.querySelector("#realizacja" + week + "-" + d);                                                           
            
            var kontener2 = kontener.querySelector("#table-" + week); 
            var ileNadg = kontener2.getAttribute("data-nadg");
            // console.log("ile nadgodzin:" + ileNadg);
            var plan = kontener2.getAttribute("data-plan");
            // console.log("wolne:"+wolne.value) ;
            if (wolne.value != "" ){                
                z = 0;                
            } else {    
                // jeśli w planie jest 0 to 0                 
                if ( plan == "old") ilePlan = PlanOld["D"+d];
                else ilePlan = PlanNew["D"+d];

                // console.log("plan: "+ planIlePlan "+parseInt(ilePlan));
                if ( ilePlan == 0 ) z = 0;
                else z = parseFloat((wypracowane - norma).toFixed(1));                                                                
            }
            // console.log("realizacja" + week + "-" + d + "z:" + z);                
            zrealizowane.textContent = z;
            sumaZreal += z;   
            
        }
        // console.log("realizacja" + week + "-" + d + "z:" + sumaZreal);                        
        if (sumaZreal > 0 && sumaZreal > ileNadg){ 
            sumaZreal = ileNadg; 
        }else if (sumaZreal < 0){
            sumaZreal = 0;
        }
        // console.log("razemRealizacja" + week + "-" + "z:" + sumaZreal);            

        // kontener.querySelector("#razemRealizacjaFloat" + week).textContent = sumaZreal.toFixed(1);    
        kontener.querySelector("#razemRealizacja" + week).value = Math.round(sumaZreal);                    
    }


    // -------------------------------------------------------------------------
    // Godziny doraźne
    
    for (var week = 1; week <= ileTygOkres; week++) {
        var sumaDorazne = 0;
        for (var d = 1; d <= 5; d++) {
            var dorazne = kontener.querySelector("#dorazne" + week + "-" + d).value;
            // console.log("Dorazne:"+dorazne);                
            sumaDorazne += parseInt(dorazne) || 0;                
        }
        kontener.querySelector("#razemDorazne" + week).value = parseInt(sumaDorazne);
        
    }

    // -------------------------------------------------------------------------
    // Nauczanie indywidualne

    for (var week = 1; week <= ileTygOkres; week++) {
        var sumaIndyw = 0;            
        var z = 0;
        for (var x = 1; x <= 5; x++) {
            var indyw = kontener.querySelector("#indyw"+week + "-" + x)  
            if (indyw && indyw.value){
                sumaIndyw += parseInt(indyw.value) || 0;
            }
        }            
        kontener.querySelector("#razemIndyw" + week).value = sumaIndyw;    
    }

    // -------------------------------------------------------------------------
    // Inne godziny
    
    for (var week = 1; week <= ileTygOkres; week++) {
        var sInne = 0;
        for (var x = 1; x <= 5; x++) {
            var inne = kontener.querySelector("#inne" + week + "-" + x);
            if (inne && inne.value) {
                sInne += parseInt(inne.value) || 0;
            }
        }
        kontener.querySelector("#razemInne" + week).value = sInne;            
    }        

    // -------------------------------------------------------------------------    
    // Podsumowanie Tygodnia 
    
    for (var week = 1; week <= ileTygOkres; week++) {
        var s = 0;
        var s1 = parseFloat(kontener.querySelector("#razemRealizacja" + week).value);
        var s2 = parseFloat(kontener.querySelector("#razemDorazne" + week).value);
        var s3 = parseFloat(kontener.querySelector("#razemIndyw" + week).value);
        var s4 = parseFloat(kontener.querySelector("#razemInne" + week).value);

        s = parseFloat(s1+s2+s3+s4);
        // console.log(s + "t:" +week);
        kontener.querySelector("#razemWeek" + week).textContent = Math.round(s); 
    }

    // ------------------------------------------------------------------- -
    // podsumowania oKRESU
    
    var sumaR = 0;
    var sumaD = 0;
    var sumaInd = 0;
    var sumaInne = 0;
    for (var week = 1; week <= ileTygOkres; week++) {
        var s = 0;
        sumaR += Math.round(kontener.querySelector("#razemRealizacja" + week).value);            
        sumaD += parseInt(kontener.querySelector("#razemDorazne" + week).value);
        sumaInd += parseInt(kontener.querySelector("#razemIndyw" + week).value);
        sumaInne += parseInt(kontener.querySelector("#razemInne" + week).value);
        // console.log("podsumowanie:" + sumaD);
    }
    
    kontener.querySelector("#RazemPonad").textContent = sumaR;
    kontener.querySelector("#RazemDorazne").textContent = sumaD;
    kontener.querySelector("#RazemIndyw").textContent = sumaInd;
    kontener.querySelector("#RazemInne").textContent = sumaInne;
    
    
    var razemG = kontener.querySelector("#razemGodziny");
    var wyprac =  kontener.querySelector("#wypracowane4");    
    kontener.querySelector("#razemGodziny").textContent = sumaR +sumaD +sumaInd +sumaInne;    
    // kontener.querySelector("#wyplata").textContent = razemG.textContent - wyprac.textContent;
    kontener.querySelector("#wyplata").textContent = razemG.textContent - wyprac.textContent;
                                                     
    // ------------------------------------------------------------------- -
    // podsumowanie klasy 4
    var ileTyg = kontener.querySelector("#ileTygodniKl4").textContent;

    //totalsum - ilośc godzin w tygodniu
    //kl4 - ilośc godzin w klasa 4 
    //setNadg - ile nadgodzin w tygodniu
    
    if (kl4>0) 
        if (setNadg > 0 && kl4 > 0 ) {  
            var godzinyBezKlas4 = totalSum - kl4;    
            if (godzinyBezKlas4 >= etat)
                x = 0;
            else
                x =  ((etat - godzinyBezKlas4) * ileTyg);                   
            
            kontener.querySelector("#doWypracowania4").textContent = x;

            
            var g1 = kontener.querySelector("#wypracowane4").textContent;
            var g2 = kontener.querySelector("#RazemWypracowane4").textContent; 
            var g3 = kontener.querySelector("#doWypracowania4").textContent; 
            
            sss = g3 - g2 - g1;
            if (sss > 0)
                kontener.querySelector("#pozostalo4").textContent = g3 - g2 - g1;
            else
                kontener.querySelector("#pozostalo4").textContent = 0;               
        }    
}   