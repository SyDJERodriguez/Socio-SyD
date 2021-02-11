<!DOCTYPE html>
<html lang="es">
    <head>
        @include('includes.head')
    </head>
    <body>
        <!-- Header - Navbar Start -->
        @include('includes.header')
        <!-- Header - Navbar End -->

        <!-- Content Start -->
        @yield('content')
        <!-- Content End -->

        <!-- Footer Start -->
        @include('includes.footer')
        <!-- Footer End -->
        <!--    jquery cdn      -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!--    bootstrap js    -->
        <script src="{{asset('js/bootstrap.js')}}" crossorigin="anonymous"></script>
        <script>
            // Add active class to the current button (highlight it)
            let header = document.getElementById("main-menu");
            let btns = header.getElementsByClassName("nav-link");
            for (let i = 0; i < btns.length; i++) {
                btns[i].addEventListener("click", function() {
                    let current = document.getElementsByClassName("active");
                    current[0].className = current[0].className.replace(" active", "");
                    this.className += " active";
                });
            }

            $('#element').toast('show');

            $(document).ready(function(){
                $("#client_number_mec").keyup(function(){
                    let client_number_mec = $('input[id=client_number_mec]').val();
                    if(client_number_mec.length===8){
                        $.ajax({
                            type: "GET",
                            url: "{{route('customer.information')}}",
                            data: {'client_number': client_number_mec},
                            success: function (data) {
                                console.log(data);
                                $('input[id=nameMec]').val(data['name']);
                                $('input[id=lastNameMec]').val(data['last_name']);
                                $('input[id=secondLastNameMec]').val(data['second_last_name']);
                                $('input[id=mobileMec]').val(data['mobile_number']);
                                $('input[id=emailMec]').val(data['email']);
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                });
                $("#client_number_pro").keyup(function(){
                    let client_number_pro = $('input[id=client_number_pro]').val();
                    if(client_number_pro.length===8){
                        $.ajax({
                            type: "GET",
                            url: "{{route('customer.information')}}",
                            data: {'client_number': client_number_pro},
                            success: function (data) {
                                console.log(data);
                                $('input[id=namePro]').val(data['name']);
                                $('input[id=lastNamePro]').val(data['last_name']);
                                $('input[id=secondLastNamePro]').val(data['second_last_name']);
                                $('input[id=mobilePro]').val(data['mobile_number']);
                                $('input[id=emailPro]').val(data['email']);
                                $('input[id=companyPro]').val(data['company']);
                            },
                            error: function(error){
                                console.log(error);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>
