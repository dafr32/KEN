
<!-- <a id="back-to-top" href="#" data-target="html" class="scroll-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a> -->
<div class="p-2 mt-5 text-bg-dark text-right mt-auto copy" style="height:40px">WS IT v.3, projekt i wykonanie © Dariusz Frączkiewicz, 2023</div>
<script>

    var mybutton = document.getElementById("back-to-top");

    new WOW().init();

    // When the user clicks on the button, scroll to the top of the document
    function scrollToTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }

    function scrollFunction() {
        if (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }


    // window.onscroll = function() {
    //     scrollFunction();
    // };

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
