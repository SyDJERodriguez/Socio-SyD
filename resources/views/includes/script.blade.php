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
    //sucursales ocultas se muestran en select
    function mostrar() {
        let canal = document.getElementById('channel');
        let verdadero = canal.value;
        if (verdadero==1) {
            document.getElementById('muestra').style.display = 'flex';
            document.getElementById('branch_id').value = '';
        }
        else if (verdadero==2) {
            document.getElementById('muestra').style.display = 'none';
            document.getElementById('branch_id').value = 2;
        }
        else if (verdadero==3) {
            document.getElementById('muestra').style.display = 'none';
            document.getElementById('branch_id').value = 47;
        }
        else{
            document.getElementById('muestra').style.display = 'none';
        }
    }

    function mostrarMec() {
        let canal = document.getElementById('channelMec');
        let verdadero = canal.value;
        if (verdadero==1) {
            document.getElementById('muestraMec').style.display = 'flex';
            document.getElementById('branch_idMec').value = '';
        }else if (verdadero==2) {
            document.getElementById('muestraMec').style.display = 'none';
            document.getElementById('branch_idMec').value = 2;
        }
        else if (verdadero==3) {
            document.getElementById('muestraMec').style.display = 'none';
            document.getElementById('branch_idMec').value = 47;
        }
        else{
            document.getElementById('muestraMec').style.display = 'none';
        }
    }

    function mostrarGen() {
        let canal = document.getElementById('channelGen');
        let verdadero = canal.value;
        if (verdadero==1) {
            document.getElementById('muestraGen').style.display = 'flex';
            document.getElementById('branch_idGen').value = '';
        }
        else if (verdadero==2) {
            document.getElementById('muestraGen').style.display = 'none';
            document.getElementById('branch_idGen').value = 2;
        }
        else if (verdadero==3) {
            document.getElementById('muestraGen').style.display = 'none';
            document.getElementById('branch_idGen').value = 47;
        }
        else{
            document.getElementById('muestraGen').style.display = 'none';
        }
    }

    function mostrarBr() {
        let canal = document.getElementById('channelBr');
        let verdadero = canal.value;
        if (verdadero==1) {
            document.getElementById('muestraBr').style.display = 'flex';
            document.getElementById('branch_idBr').value = '';
        }
        else if (verdadero==2) {
            document.getElementById('muestraBr').style.display = 'none';
            document.getElementById('branch_idBr').value = 2;
        }
        else if (verdadero==3) {
            document.getElementById('muestraBr').style.display = 'none';
            document.getElementById('branch_idBr').value = 47;
        }
        else{
            document.getElementById('muestraBr').style.display = 'none';
        }
    }

    function mostrarCNT() {
        let canal = document.getElementById('channelCNT');
        let verdadero = canal.value;
        if (verdadero==1) {
            document.getElementById('muestraCNT').style.display = 'flex';
            document.getElementById('branch_idCNT').value = '';
        }
        else if (verdadero==2) {
            document.getElementById('muestraCNT').style.display = 'none';
            document.getElementById('branch_idCNT').value = 2;
        }
        else if (verdadero==3) {
            document.getElementById('muestraCNT').style.display = 'none';
            document.getElementById('branch_idCNT').value = 47;
        }
        else{
            document.getElementById('muestraCNT').style.display = 'none';
        }
    }

    function showselect() {
        let canal = document.getElementById('channelinv');
        let verdadero = canal.value;
        if (verdadero==1) {
            document.getElementById('showbranch').style.display = 'flex';
            document.getElementById('branch_idinv').value = '';
        }
        else if (verdadero==2) {
            document.getElementById('showbranch').style.display = 'none';
            document.getElementById('branch_idinv').value = 2;
        }
        else if (verdadero==3) {
            document.getElementById('showbranch').style.display = 'none';
            document.getElementById('branch_idinv').value = 47;
        }
        else{
            document.getElementById('showbranch').style.display = 'none';
        }
    }
    //Do not send without recaptcha
    window.onload = function() {
        var $recaptcha = document.querySelector('#g-recaptcha-response');

        if($recaptcha) {
            $recaptcha.setAttribute("required", "required");
        }
    };

    //popover for buttons modal
    $('#popoverDataindividual').popover();
    $('#popoverDatacolaboradores').popover();
    $('#popoverDatacadenas').popover();
    $('#popoverDatageneral').popover();
    $('#popoverOption').popover({ trigger: "hover" });

    $('#element').toast('show');

    function searchCustomerDataFromSAP(clientNumber) {
        $.ajax({
            type: "GET",
            url: "{{route('customer.searchCustomerDataFromSAP')}}",
            data: {
                'client_number': clientNumber
            },
            success: function(data) {
                if (data.ET_CUSTOMERS.length > 0) {
                    let cliente = data.ET_CUSTOMERS[0];

                    if (cliente.NAME1 && cliente.NAME1.trim() !== '') {
                        let nameParts = cliente.NAME1.trim().split(/\s+/);
                        const conectores = ['DE', 'DEL', 'LA', 'LAS', 'LOS', 'Y'];
                        let nombre = '';
                        let apellidoP = '';
                        let apellidoM = '';

                        if (nameParts.length === 1) {
                            nombre = nameParts[0];
                        }
                        else if (nameParts.length === 2) {
                            nombre = nameParts[0];
                            apellidoP = nameParts[1];
                        }
                        else {
                            // Detectar apellido materno (desde el final)
                            apellidoM = nameParts.pop();
                            // Si el anterior es conector, incluirlo
                            while (nameParts.length > 0 && conectores.includes(nameParts[nameParts.length - 1].toUpperCase())) {
                                apellidoM = nameParts.pop() + ' ' + apellidoM;
                            }
                            // 🔥 Detectar apellido paterno
                            apellidoP = nameParts.pop();
                            while (nameParts.length > 0 && conectores.includes(nameParts[nameParts.length - 1].toUpperCase())) {
                                apellidoP = nameParts.pop() + ' ' + apellidoP;
                            }
                            // 🔥 Lo demás es nombre
                            nombre = nameParts.join(' ');
                        }
                        $('input[id=nameGen]').val(nombre);
                        $('input[id=lastNameGen]').val(apellidoP);
                        $('input[id=secondLastNameGen]').val(apellidoM);
                        $('input[id=emailGen]').val(cliente.SMTP_ADDR1);
                        $('input[id=mobileGen]').val(cliente.TELF1);
                    }
                }
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    $(document).ready(function() {
        //get branch information with clientNumber
        $('#clientNumberBr').keyup(function () {
            let clientNumberBr = $('input[id=clientNumberBr').val();
            if (clientNumberBr.length === 8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.branchInformation')}}",
                    data: {'client_number': clientNumberBr},
                    success: function (data) {
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert_br")
                            .innerHTML='<button type="button" class="close alertClose" aria-hidden="true" >&times;</button>Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR <a href="#" data-toggle="modal" data-target="#modalForgotNum">¿Olvidaste tu número de cliente?</a>';
                            document.getElementById("form_alert_br").removeAttribute("hidden");
                            $(".alertClose").on("click", function (){document.getElementById("form_alert_br").hidden= true});
                            setTimeout(function (){document.getElementById("form_alert_br").hidden= true}, 5000);
                        }

                        let select = document.getElementById("branch_name");
                        try {
                            select.options.length = 0;

                            if(typeof data.length == "number" && data.length > 0){
                                data.forEach(element => {
                                    //select.options.add(new Option(element['branch_name'],element['branch_number']));
                                    let option =  document.createElement('option');
                                    option.value = element['branch'];
                                    option.innerHTML = element['branch_name'];
                                    select.appendChild(option);
                                });
                            }else{
                                select.innerHTML = '<option disabled selected value=""> SUCURSAL</option>';
                            }
                        } catch (e) {
                            //select.options.add(new Option();
                            select.innerHTML = '<option disabled selected value=""> SUCURSAL</option>';
                            console.error(e);
                        }
                        //console.log(data);

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });

        //Get owner's client number
        $("#client_number_pro").keyup(function() {
            let client_number_pro = $('input[id=client_number_pro]').val();
            if(client_number_pro.length===8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_pro},
                    success: function (data) {
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert")
                            .innerHTML='<button type="button" class="close alertClose" aria-hidden="true" >&times;</button>Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR <a href="#" data-toggle="modal" data-target="#modalForgotNum">¿Olvidaste tu número de cliente?</a>';
                            document.getElementById("form_alert").removeAttribute("hidden");
                            $(".alertClose").on("click", function (){document.getElementById("form_alert").hidden= true});
                            setTimeout(function (){document.getElementById("form_alert").hidden= true}, 5000);
                        }
                        $('input[id=namePro]').val(data['name']);
                        $('input[id=lastNamePro]').val(data['last_name']);
                        $('input[id=secondLastNamePro]').val(data['second_last_name']);
                        $('input[id=mobilePro]').val(data['mobile_number']);
                        $('input[id=emailPro]').val(data['email']);
                        $('input[id=companyPro]').val(data['company']);
                        $('input[id=rfc]').val(data['rfc']);
                        $('input[id=birthday]').val(data['birthday']);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });

        //Get the CNT's client number
        $("#client_number_cnt").keyup(function() {
            let client_number_mec = $('input[id=client_number_cnt]').val();
            if(client_number_mec.length===8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_mec},
                    success: function (data) {
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert_cnt").innerHTML='<button type="button" class="close alertClose" aria-hidden="true" >&times;</button> El número de cliente no se encuentra en la base de datos';
                            document.getElementById("form_alert_cnt").removeAttribute("hidden");
                            $(".alertClose").on("click", function (){document.getElementById("form_alert").hidden= true});
                            setTimeout(function (){document.getElementById("form_alert").hidden= true}, 5000);
                        }
                        /*$('input[id=nameCNT]').val(data['name']);
                        $('input[id=lastNameCNT]').val(data['last_name']);
                        $('input[id=secondLastNameCNT]').val(data['second_last_name']);
                        $('input[id=mobileCNT]').val(data['mobile_number']);
                        $('input[id=emailCNT]').val(data['email']);
                        $('input[id=birthdayCNT]').val(data['birthday']);*/
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });

        //Get the mechanic's client number
        $("#client_number_mec").keyup(function() {
            let client_number_mec = $('input[id=client_number_mec]').val();
            if(client_number_mec.length===8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_mec},
                    success: function (data) {
                        //console.log(data);
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert_mec")
                            .innerHTML='<button type="button" class="close alertClose" aria-hidden="true" >&times;</button>Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR';
                            document.getElementById("form_alert_mec").removeAttribute("hidden");
                            $(".alertClose").on("click", function (){document.getElementById("form_alert_mec").hidden= true});
                            setTimeout(function (){document.getElementById("form_alert_mec").hidden= true}, 5000);
                        }
                        /*$('input[id=nameMec]').val(data['name']);
                        $('input[id=lastNameMec]').val(data['last_name']);
                        $('input[id=secondLastNameMec]').val(data['second_last_name']);
                        $('input[id=mobileMec]').val(data['mobile_number']);
                        $('input[id=emailMec]').val(data['email']);
                        $('input[id=birthday]').val(data['birthday']);*/
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });

        //Get the general public client number
        $("#client_number_gen").keyup(function() {
            let client_number_gen = $('input[id=client_number_gen]').val();
            if(client_number_gen.length === 8) {
                let searchSpinner = document.getElementById("form_alert_search_spinner");
                searchSpinner.removeAttribute("hidden");
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_gen},
                    success: function(data) {
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            $.ajax({
                                type: "GET",
                                url: "{{route('customer.getCustomerSAP')}}",
                                data: {
                                    "cliente": '00' + client_number_gen
                                },
                                success: function(data) {
                                    if (data['Error']==='false') {
                                        searchCustomerDataFromSAP('00' + client_number_gen);
                                        searchSpinner.hidden = true;
                                    } else {
                                        searchSpinner.hidden = true;
                                        document.getElementById("form_alert_gen")
                                        .innerHTML='<button type="button" class="close alertClose" aria-hidden="true" >&times;</button>Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR';
                                        document.getElementById("form_alert_gen").removeAttribute("hidden");
                                        $(".alertClose").on("click", function (){document.getElementById("form_alert_gen").hidden= true});
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                    searchSpinner.hidden = true;
                                }
                            });
                            //setTimeout(function (){document.getElementById("form_alert_gen").hidden= true}, 5000);
                        }
                        else {
                            searchCustomerDataFromSAP('00' + client_number_gen);
                            searchSpinner.hidden = true;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        searchSpinner.hidden = true;
                    }
                });
            }
        });

        //Get the employee's client number
        $("#client_number_employee").keyup(function() {
            let client_number_employee = $('input[id=client_number_employee]').val();
            if(client_number_employee.length===8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_employee},
                    success: function (data) {
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert_employee")
                                .innerHTML='<button type="button" class="close alertClose" aria-hidden="true" >&times;</button>Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR';
                            document.getElementById("form_alert_employee").removeAttribute("hidden");
                            $(".alertClose").on("click", function (){document.getElementById("form_alert").hidden= true});
                            setTimeout(function (){document.getElementById("form_alert").hidden= true}, 5000);
                        }
                        /*$('input[id=nameMec]').val(data['name']);
                        $('input[id=lastNameMec]').val(data['last_name']);
                        $('input[id=secondLastNameMec]').val(data['second_last_name']);
                        $('input[id=mobileMec]').val(data['mobile_number']);
                        $('input[id=emailMec]').val(data['email']);
                        $('input[id=birthday]').val(data['birthday']);*/
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });
        //cadenas Form
        $('#cadenasForm').bind('submit', function() {

            let codeVerification = document.querySelector('#codeBr');
            let codeConfirm      = document.querySelector('#codeBrConfirm');
            let error_code       = document.querySelector('#error_code_br');

            if(codeConfirm.value === codeVerification.value) {
                let btnSend4 = $('#btnSend4');
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: function (data) {
                        btnSend4.prop('Enviando', 'Enviando');
                        btnSend4.html('disabled', true);
                    },
                    success: function (data) {
                        if (data['success'] === 'true') {
                            $('#modalCadenas').modal('hide');
                            $('#clientName').text('¡BIENVENIDO! ' + data['name'].toUpperCase());
                            $('#clientNumber').text('No. de Cliente ' + data['client_number']);
                            $('#clientMessage').text('En breve recibirás un correo y un mensaje SMS de activación');
                            $('#modalSuccess').modal('show');
                        } else if (data['success'] === 'false' && data['verify_email'] === 'false') {
                            document.getElementById("form_alert_email_br").innerHTML = 'El email ya se encuentra asociado a otro cliente';
                            document.getElementById("form_alert_email_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_email_br").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_client_number'] === 'false') {
                            document.getElementById("form_alert_br").innerHTML = 'Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR <a href="#" data-toggle="modal" data-target="#modalForgotNum">¿Olvidaste tu número de cliente?</a>';
                            document.getElementById("form_alert_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_br").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_password'] === 'false') {
                            document.getElementById("form_alert_pass_br").innerHTML = 'Las contraseñas no coinciden, por favor verifica ';
                            document.getElementById("form_alert_pass_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_pass_br").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_mobile_number'] === 'false') {
                            document.getElementById("form_alert_mobile_br").innerHTML = 'El número telefónico ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_mobile_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_mobile_br").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_email_number'] === 'false') {
                            document.getElementById("form_alert_br").innerHTML = 'El email ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_br").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_valid_mobile'] === 'false') {
                            document.getElementById("form_alert_phone_br").innerHTML = '<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                            document.getElementById("form_alert_phone_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_phone_br").hidden = true
                            }, 3500);
                            document.getElementById("form_alert_phone_text_br").innerHTML = 'El número telefónico no es válido. Verifica tus datos ';
                            document.getElementById("form_alert_phone_text_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_phone_text_br").hidden = true
                            }, 3500)
                        } else if (data['success'] === 'false' && data['verify_valid_dns'] === 'false') {
                            document.getElementById("form_alert_dns_br").innerHTML = 'Por favor proporciona un email válido';
                            document.getElementById("form_alert_dns_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns_br").hidden = true
                            }, 3500)
                        } else if (data['success'] === 'false' && data['verify_client'] === 'false') {
                            document.getElementById("form_alert_dns_br").innerHTML = 'El número de cliente y sucursal ya existen';
                            document.getElementById("form_alert_dns_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns_br").hidden = true
                            }, 3500)
                        } else if (data['success'] === 'false' && data['other'] === 'false') {
                            document.getElementById("form_alert_dns_br").innerHTML = data['error'];
                            document.getElementById("form_alert_dns_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns_br").hidden = true
                            }, 3500)

                        } else if (data['success'] === 'false' && data['bday'] === 'false') {
                            document.getElementById("form_alert_dns_br").innerHTML = data['error'];
                            document.getElementById("form_alert_dns_br").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns_br").hidden = true
                            }, 3500)

                        } else if (data['success'] === 'false') {
                            $('#modalCadenas').modal('hide');
                            $('#modalError').modal('show');
                        }
                    },
                    error: function (data) {
                        $('#modalErrorSession').modal('show');
                    }
                });
                // Nos permite cancelar el envio del formulario
                return false;
            }else{
                console.log('Not are the same code');
                error_code.innerHTML = 'El código de verificación es incorrecto';
                error_code.hidden    = false;
                setTimeout(() =>{error_code.hidden = true},3500);
                return false;
            }
        });

        //Owner's form
        $("#ownerForm").bind("submit",function() {
            let btn_owner = document.querySelector('#btnSend_owner');
            btn_owner.setAttribute('disabled','');
            let codeVerification = document.querySelector('#codeOw');
            let codeConfirm      = document.querySelector('#codeOwConfirm');
            let error_code       = document.querySelector('#error_code_ow');

            if(codeConfirm.value === codeVerification.value) {
                // We capture send button
                let btnSend = $("#btnSend");
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: $(this).serialize(),

                    success: function (data) {
                        //console.log(data);
                        if (data['success'] === 'true') {
                            $('#modal3').modal('hide');
                            $('#clientName').text('¡BIENVENIDO! ' + data['name'].toUpperCase());
                            $('#clientNumber').text('No. de Cliente ' + data['client_number']);
                            $('#clientMessage').text('En breve recibirás un correo y un mensaje SMS de activación');
                            $('#modalSuccess').modal('show');
                        } else if (data['success'] === 'false' && data['verify_client_number'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert").innerHTML = 'Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR <a href="#" data-toggle="modal" data-target="#modalForgotNum">¿Olvidaste tu número de cliente?</a>';
                            document.getElementById("form_alert").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert").hidden = true
                            }, 3000);

                        } else if (data['success'] === 'false' && data['verify_email'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_email").innerHTML = 'El email ya se encuentra asociado a otro cliente';
                            document.getElementById("form_alert_email").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_email").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_password'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_pass_pro").innerHTML = 'Las contraseñas no coinciden, por favor verifica ';
                            document.getElementById("form_alert_pass_pro").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_pass_pro").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_mobile_number'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_mobile").innerHTML = 'El número telefónico ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_mobile").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_mobile").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_email_number'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert").innerHTML = 'El email ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert").hidden = true
                            }, 3000);
                        } else if (data['success'] === 'false' && data['verify_valid_mobile'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_phone").innerHTML = '<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                            document.getElementById("form_alert_phone").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_phone").hidden = true
                            }, 3500);
                            document.getElementById("form_alert_phone_text").innerHTML = 'El número telefónico no es válido. Verifica tus datos ';
                            document.getElementById("form_alert_phone_text").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_phone_text").hidden = true
                            }, 3500)
                        } else if (data['success'] === 'false' && data['verify_valid_dns'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_dns").innerHTML = 'Por favor proporciona un email válido';
                            document.getElementById("form_alert_dns").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns").hidden = true
                            }, 3500)

                        } else if (data['success'] === 'false' && data['verify_client'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_dns").innerHTML = 'El número de cliente ya está en uso';
                            document.getElementById("form_alert_dns").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns").hidden = true
                            }, 3500)

                        } else if (data['success'] === 'false' && data['verify_data_branch'] === 'false') {
                            $('#modalSignUpInCadenas').modal('show');

                        } else if (data['success'] === 'false' && data['other'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_dns").innerHTML = data['error'];
                            document.getElementById("form_alert_dns").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns").hidden = true
                            }, 3500)

                        } else if (data['success'] === 'false' && data['bday'] === 'false') {
                            btn_owner.removeAttribute('disabled');
                            document.getElementById("form_alert_dns").innerHTML = data['error'];
                            document.getElementById("form_alert_dns").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_dns").hidden = true
                            }, 3500)

                        } else if (data['success'] === 'false') {
                            $('#modal3').modal('hide');
                            $('#modalError').modal('show');
                        }
                    },
                    error: function (data) {
                        //console.log(data);
                        //console.log(data['update']);
                        $('#modalErrorSession').modal('show');
                    }
                });
                // Nos permite cancelar el envio del formulario
                return false;
            }else{
                console.log('Not are the same code');
                error_code.innerHTML = 'El código de verificación es incorrecto';
                error_code.hidden    = false;
                setTimeout(() =>{error_code.hidden = true},3500);
                return false;
            }
        });

        //Mechanic's form
        $("#mechanicForm").bind("submit",function() {
            let btn_mechanic = document.querySelector('#btnSend_mechanic');
            btn_mechanic.setAttribute('disabled','');
            let codeVerification = document.querySelector('#codeMec');
            let codeConfirm      = document.querySelector('#codeMecConfirm');
            let error_code       = document.querySelector('#error_code');

            if(codeConfirm.value === codeVerification.value){
                // We capture send button
                //let btnSend = $("#btnSend").prop('disabled', true);
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data:$(this).serialize(),

                    success: function(data){
                        //console.log(data);
                        if(data['success']==='true'){
                            $('#modal5').modal('hide');
                            $('#clientName').text('¡BIENVENIDO! '+data['name'].toUpperCase());
                            $('#clientNumber').text('No. de Cliente '+data['client_number']);
                            $('#clientMessage').text('En breve recibirás un correo y un mensaje SMS de activación');
                            $('#modalSuccess').modal('show');
                        }else if (data['success']==='false' && data['verify_email']==='false') {
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_mec_email").innerHTML='El email ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_mec_email").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_mec_email").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_client_number']==='false') {
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_mec").innerHTML='Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR <a href="#" data-toggle="modal" data-target="#modalForgotNum">¿Olvidaste tu número de cliente?</a>';
                            document.getElementById("form_alert_mec").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_mec").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_password']==='false') {
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_mec_pass").innerHTML='Las contraseñas no coinciden, por favor verifica ';
                            document.getElementById("form_alert_mec_pass").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_mec_pass").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_mobile_number']==='false') {
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_mec_mobile").innerHTML='El número telefónico ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_mec_mobile").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_mec_mobile").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_email_number']==='false') {
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_mec").innerHTML='El email ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_mec").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_mec").hidden= true}, 3000);
                        }else if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_phone_mec").innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                            document.getElementById("form_alert_phone_mec").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_phone_mec").hidden= true}, 3500);
                            document.getElementById("form_alert_phone_text_mec").innerHTML='El número telefónico no es válido. Verifica tus datos';
                            document.getElementById("form_alert_phone_text_mec").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_phone_text_mec").hidden = true},3500)
                        }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_mec").innerHTML='Por favor proporciona un email válido';
                            document.getElementById("form_alert_dns_mec").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_mec").hidden = true},3500)

                        }else if(data['success']==='false' && data['verify_client']==='false'){
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_mec").innerHTML='El número de cliente ya está en uso';
                            document.getElementById("form_alert_dns_mec").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_mec").hidden = true},3500)

                        }else if(data['success']==='false' && data['verify_data_branch']==='false'){
                            $('#modalSignUpInCadenas').modal('show');

                        }else if(data['success']==='false' && data['other']==='false'){
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_mec").innerHTML=data['error'];
                            document.getElementById("form_alert_dns_mec").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_mec").hidden = true},3500)

                        }else if(data['success']==='false' && data['bday']==='false'){
                            btn_mechanic.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_mec").innerHTML=data['error'];
                            document.getElementById("form_alert_dns_mec").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_mec").hidden = true},3500)

                        }else if (data['success']==='false'){
                            $('#modal5').modal('hide');
                            $('#modalError').modal('show');
                            //console.log(data);
                        }
                    },
                    error: function(data){
                        $('#modalErrorSession').modal('show');

                    }
                });
                // Nos permite cancelar el envio del formulario
                return false;
            }else{
                console.log('Not are the same code');
                error_code.innerHTML = 'El código de verificación es incorrecto';
                error_code.hidden    = false;
                setTimeout(() =>{error_code.hidden = true},3500);
                return false;
            }
        });

        //Employees's form
        $("#employeeForm").bind("submit",function() {
            // We capture send button
            let btnSend = $("#btnSend");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),

                success: function(data){
                    if(data['success']==='true'){
                        $('#modalPositive').modal('hide');
                        $('#modalSuccessEmployee').modal('show');
                    }else if (data['success']==='false'){
                        $('#modalPositive').modal('hide');
                        $('#modalErrorEmployee').modal('show');
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //CNT's form
        $("#cntForm").bind("submit",function() {
            let codeVerification = document.querySelector('#codeCNT');
            let codeConfirm      = document.querySelector('#codeCNTConfirm');
            let error_code       = document.querySelector('#error_code_CNT');

            if(codeConfirm.value === codeVerification.value){
                // We capture send button
                let btnSend = $("#btnSend");
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data:$(this).serialize(),

                    success: function(data){
                        console.log(data);
                        if(data['success']==='true'){
                            $('#modal5').modal('hide');
                            $('#clientName').text('¡BIENVENIDO! '+data['name'].toUpperCase());
                            $('#clientNumber').text('No. de Cliente '+data['client_number']);
                            $('#clientMessage').text('En breve recibirás un correo y un mensaje SMS de activación');
                            $('#modalSuccess').modal('show');
                        }else if (data['success']==='false' && data['cnt_number']==='false') {
                            let errorCNT  = document.querySelector('#alertErrorCodeCNT');
                            errorCNT.hidden = false;
                            setTimeout( function () { errorCNT.hidden = true }, 3500)
                        }else if (data['success']==='false' && data['count_number']==='false') {
                            let limitCNT = document.querySelector('#alertLimitCNT');
                            limitCNT.hidden = false;
                            setTimeout(function (){ limitCNT.hidden= true }, 3000);
                        }else if (data['success']==='false' && data['verify_client_number']==='false') {
                            let cnCNT = document.querySelector('#alertErrorCNCNT');
                            cnCNT.hidden = false;
                            setTimeout(function (){ cnCNT.hidden= true }, 3000);
                        }else if (data['success']==='false' && data['verify_email']==='false') {
                            document.getElementById("form_alert_cnt_email").innerHTML='El email ya se encuentra asociado a otro cliente <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert_cnt_email").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_cnt_email").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_password']==='false') {
                            document.getElementById("form_alert_cnt_pass").innerHTML='Las contraseñas no coinciden, por favor verifica <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert_cnt_pass").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_cnt_pass").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_mobile_number']==='false') {
                            document.getElementById("form_alert_cnt_mobile").innerHTML='El número telefónico ya se encuentra asociado a otro cliente <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert_cnt_mobile").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_cnt_mobile").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_email_number']==='false') {
                            document.getElementById("form_alert_cnt").innerHTML='El email ya se encuentra asociado a otro cliente <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert_cnt").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_cnt").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['cnt_number']==='false') {
                            document.getElementById("form_alert_cnt_ncnt").innerHTML='Número CNT incorrecto <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert_cnt_ncnt").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_cnt_ncnt").hidden= true}, 3000);
                        }else if (data['success'] === 'false' && data['bday'] === 'false') {
                            document.getElementById("form_alert_cnt_ncnt").innerHTML = data['error'];
                            document.getElementById("form_alert_cnt_ncnt").removeAttribute("hidden");
                            setTimeout(function () {
                                document.getElementById("form_alert_cnt_ncnt").hidden = true
                            }, 3500)

                        }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                            document.getElementById("form_alert_dns_cnt").innerHTML='Por favor proporciona un email válido';
                            document.getElementById("form_alert_dns_cnt").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_cnt").hidden = true},3500)

                        }else if (data['success']==='false'){
                            $('#modal5').modal('hide');
                            $('#modalError').modal('show');
                        }
                    },
                    error: function(data){
                        $('#modalErrorSession').modal('show');
                    }
                });
            }

            // Nos permite cancelar el envio del formulario
            return false;
        });

        //General Public form
        $("#generalForm").bind("submit",function() {
            let btn_public = document.querySelector('#btnSend_public');
            btn_public.setAttribute('disabled','');
            let codeVerification = document.querySelector('#codeGen');
            let codeConfirm      = document.querySelector('#codeGenConfirm');
            let error_code       = document.querySelector('#error_code');

            if(codeConfirm.value === codeVerification.value){
                // We capture send button
                let btnSend = $("#btnSend");
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data:$(this).serialize(),

                    success: function(data){
                        //console.log(data);
                        if(data['success']==='true'){
                            $('#modalGeneral').modal('hide');
                            $('#clientName').text('¡BIENVENIDO! '+data['name'].toUpperCase());
                            $('#clientNumber').text('No. de Cliente '+data['client_number']);
                            $('#clientMessage').text('En breve recibirás un correo y un mensaje SMS de activación');
                            $('#modalSuccess').modal('show');
                        }else if (data['success']==='false' && data['verify_email']==='false') {
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_gen_email").innerHTML='El email ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_gen_email").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_gen_email").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_client_number']==='false') {
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_gen").innerHTML='Por favor ingrese un número de cliente válido. En caso de que no tenga o no recuerde su número de cliente, favor de contactar a su agente de ventas DAR <a href="#" data-toggle="modal" data-target="#modalForgotNum">¿Olvidaste tu número de cliente?</a>';
                            document.getElementById("form_alert_gen").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_gen").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_password']==='false') {
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_gen_pass").innerHTML='Las contraseñas no coinciden, por favor verifica ';
                            document.getElementById("form_alert_gen_pass").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_gen_pass").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_mobile_number']==='false') {
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_gen_mobile").innerHTML='El número telefónico ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_gen_mobile").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_gen_mobile").hidden= true}, 3000);
                        }else if (data['success']==='false' && data['verify_email_number']==='false') {
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_gen").innerHTML='El email ya se encuentra asociado a otro cliente ';
                            document.getElementById("form_alert_gen").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_gen").hidden= true}, 3000);
                        }else if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_phone_gen").innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                            document.getElementById("form_alert_phone_gen").removeAttribute("hidden");
                            setTimeout(function (){document.getElementById("form_alert_phone_gen").hidden= true}, 3500);
                            document.getElementById("form_alert_phone_text_gen").innerHTML='El número telefónico no es válido. Verifica tus datos';
                            document.getElementById("form_alert_phone_text_gen").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_phone_text_gen").hidden = true},3500)
                        }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_gen").innerHTML='Por favor proporciona un email válido';
                            document.getElementById("form_alert_dns_gen").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_gen").hidden = true},3500)

                        }else if(data['success']==='false' && data['verify_client']==='false'){
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_gen").innerHTML='El número de cliente ya está en uso';
                            document.getElementById("form_alert_dns_gen").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_gen").hidden = true},3500)

                        }else if(data['success']==='false' && data['verify_data_branch']==='false'){
                            $('#modalSignUpInCadenas').modal('show');

                        }else if(data['success']==='false' && data['other']==='false'){
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_gen").innerHTML=data['error'];
                            document.getElementById("form_alert_dns_gen").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_gen").hidden = true},3500)

                        }else if(data['success']==='false' && data['bday']==='false'){
                            btn_public.removeAttribute('disabled');
                            document.getElementById("form_alert_dns_gen").innerHTML=data['error'];
                            document.getElementById("form_alert_dns_gen").removeAttribute("hidden");
                            setTimeout(function(){document.getElementById("form_alert_dns_gen").hidden = true},3500)

                        }else if (data['success']==='false'){
                            $('#modalGeneral').modal('hide');
                            $('#modalError').modal('show');
                            //console.log(data);
                        }
                    },
                    error: function(data){
                        $('#modalErrorSession').modal('show');

                    }
                });
                // Nos permite cancelar el envio del formulario
                return false;
            }else{
                console.log('Not are the same code');
                error_code.innerHTML = 'El código de verificación es incorrecto';
                error_code.hidden    = false;
                setTimeout(() =>{error_code.hidden = true},3500);
                return false;
            }
        });

        //Signature Submit
        $('#signatureForm').bind("submit", function() {
            //capture de sendBtn
            //let btnSendSign = $('#confirmarSign');
            //let check = $("#terms");
            //alert(check);
            $.ajax({
                type: $(this).attr("method"),
                url:  $(this).attr("action"),
                data: $(this).serialize(),
                beforeSend: function () {
                    //console.log("ok")
                },
                success: function (data) {

                    if(data['success'] === 'true'){
                        $('#modalConfirmSign').modal('show');
                    }
                },
                error: function (data) {
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //AddEmployeeForm's form
        $("#addEmployeeForm").bind("submit",function() {
            // We capture send button
            let btnSend2 = $("#btnSend2");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend2.html("Enviando");
                    btnSend2.attr("disabled",true);
                },
                success: function(data){
                    //console.log(data);
                    btnSend2.html("Aceptar");
                    btnSend2.attr("disabled",false);
                    if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                        document.getElementById("form_alert_phone_AEF").innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                        document.getElementById("form_alert_phone_AEF").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_phone_AEF").hidden= true}, 3500);
                        document.getElementById("form_alert_phone_text_AEF").innerHTML='<p style="margin-bottom:0px">El número telefónico no es válido. Verifica tus datos</p>';
                        document.getElementById("form_alert_phone_text_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_phone_text_AEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                        document.getElementById("form_alert_dns_AEF").innerHTML='<p style="margin-bottom:0px">Por favor proporciona un email válido</p>';
                        document.getElementById("form_alert_dns_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_AEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['other']==='false'){
                        document.getElementById("form_alert_dns_AEF").innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        document.getElementById("form_alert_dns_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_AEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['bday']==='false'){
                        document.getElementById("form_alert_dns_AEF").innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        document.getElementById("form_alert_dns_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_AEF").hidden = true},3500)

                    }else{
                        window.location = "{{route('customer.employees')}}";
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        $("#addEmployeeFormbranch").bind("submit",function() {
            // We capture send button
            let btnSend2 = $("#btnSend2");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend2.html("Enviando");
                    btnSend2.attr("disabled",true);
                },
                success: function(data){
                    //console.log(data);
                    btnSend2.html("Aceptar");
                    btnSend2.attr("disabled",false);
                    if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                        document.getElementById("form_alert_phone_AEF").innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                        document.getElementById("form_alert_phone_AEF").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_phone_AEF").hidden= true}, 3500);
                        document.getElementById("form_alert_phone_text_AEF").innerHTML='<p style="margin-bottom:0px">El número telefónico no es válido. Verifica tus datos</p>';
                        document.getElementById("form_alert_phone_text_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_phone_text_AEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                        document.getElementById("form_alert_dns_AEF").innerHTML='<p style="margin-bottom:0px">Por favor proporciona un email válido</p>';
                        document.getElementById("form_alert_dns_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_AEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['other']==='false'){
                        document.getElementById("form_alert_dns_AEF").innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        document.getElementById("form_alert_dns_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_AEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['bday']==='false'){
                        document.getElementById("form_alert_dns_AEF").innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        document.getElementById("form_alert_dns_AEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_AEF").hidden = true},3500)

                    }else{
                        window.location = "{{route('addsuccess')}}";
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //UpdateDataForm's form
        $("#updateDataForm").bind("submit",function() {
            // We capture send button
            let btnSend3 = $("#btnSend3");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function (data) {
                    btnSend3.prop('Enviando','Enviando');
                    btnSend3.html('disabled',true);
                },
                success: function(data){
                    //console.log(data);
                    if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                        document.getElementById("form_alert_phone_UDF").innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                        document.getElementById("form_alert_phone_UDF").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_phone_UDF").hidden= true}, 3500);
                        document.getElementById("form_alert_phone_text_UDF").innerHTML='<p style="margin-bottom:0px">El número telefónico no es válido. Verifica tus datos</p>';
                        document.getElementById("form_alert_phone_text_UDF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_phone_text_UDF").hidden = true},3500)
                    }else if(data['success']==='false' && data['verify_password']==='false'){
                        document.getElementById("form_alert_pass_UDF").innerHTML='Las contraseñas no coinciden, por favor verifica';
                        document.getElementById("form_alert_pass_UDF").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_pass_UDF").hidden= true}, 3000);
                    }else if(data['success']==='false' && data['other']==='false'){
                        document.getElementById("form_alert_pass_UDF").innerHTML=data['error'];
                        document.getElementById("form_alert_pass_UDF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_pass_UDF").hidden = true},3500)

                    }else if(data['success']==='false' && data['bday']==='false'){
                        document.getElementById("form_alert_pass_UDF").innerHTML=data['error'];
                        document.getElementById("form_alert_pass_UDF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_pass_UDF").hidden = true},3500)

                    }else{
                        window.location = "{{route('customer.benefits')}}"
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //AddEmployeeForm's form
        $("#editEmployeeForm").bind("submit",function() {
            // We capture send button
            let btnSend2 = $("#btnSendEditEmployee");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend2.html("Enviando");
                    btnSend2.attr("disabled",true);
                },
                success: function(data){
                    //console.log(data);
                    btnSend2.html("Aceptar");
                    btnSend2.attr("disabled",false);
                    if(data['success']==='false' && data['verify_valid_mobile']==='false'){
                        document.getElementById("form_alert_phone_EEF").innerHTML='<div style="border: 1px solid black" class="input-group-text bg-danger text-white"> X </div>';
                        document.getElementById("form_alert_phone_EEF").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_phone_EEF").hidden= true}, 3500);
                        document.getElementById("form_alert_phone_text_EEF").innerHTML='<p style="margin-bottom:0px">El número telefónico no es válido. Verifica tus datos</p>';
                        document.getElementById("form_alert_phone_text_EEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_phone_text_EEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['verify_valid_dns']==='false'){
                        document.getElementById("form_alert_dns_EEF").innerHTML='<p style="margin-bottom:0px">Por favor proporciona un email válido</p>';
                        document.getElementById("form_alert_dns_EEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_EEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['other']==='false'){
                        document.getElementById("form_alert_dns_EEF").innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        document.getElementById("form_alert_dns_EEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_EEF").hidden = true},3500)
                    }else if(data['success']==='false' && data['bday']==='false'){
                        document.getElementById("form_alert_dns_EEF").innerHTML='<p style="margin-bottom:0px">'+data['error']+'</p>';
                        document.getElementById("form_alert_dns_EEF").removeAttribute("hidden");
                        setTimeout(function(){document.getElementById("form_alert_dns_EEF").hidden = true},3500)

                    }else{
                        window.location = "{{route('customer.employees')}}";
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //Restore Password
        $("#sendRestorePassword").bind("submit",function() {
            // We capture send button
            let btnSend = $("#sendRestorePassword");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend.val("Enviando");
                    btnSend.attr("disabled","disabled");
                },
                success: function(data){
                    if(data['success']==='true'){
                        $('#sendRestoreEmail').modal('show');
                    }else if (data['success']==='false'){
                        $('#modal3').modal('hide');
                        $('#modalError').modal('show');
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        $("#restoreForm").bind("submit",function() {
            let btnSend = $("#sendNewPass");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend.val("Enviando");
                    btnSend.attr("disabled","disabled");
                },
                success: function(data){
                    if(data['success']==='true'){
                        $('#restorePasswordSuccess').modal('show');
                    }else if (data['success']==='false'){
                        $('#modalError').modal('show');
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //Restore Account
        $("#sendRestoreAccount").bind("submit",function() {
            // We capture send button
            let btnSend = $("#sendRestorePassword");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend.val("Enviando");
                    btnSend.attr("disabled","disabled");
                },
                success: function(data){
                    if(data['success']==='true'){
                        $('#sendRestoreAccountSuccess').modal('show');
                    }else if (data['success']==='false'){
                        $('#modal3').modal('hide');
                        $('#modalError').modal('show');
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });

        //Active Account
        $("#restoreAccount").bind("submit",function() {
            let btnSend = $("#sendNewPass");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),
                beforeSend: function(){
                    btnSend.val("Enviando");
                    btnSend.attr("disabled","disabled");
                },
                success: function(data){
                    if(data['success']==='true'){
                        $('#restoreAccountSuccess').modal('show');
                    }else if (data['success']==='false'){
                        $('#modalError').modal('show');
                    }
                },
                error: function(data){
                    $('#modalErrorServer').modal('show');
                }
            });
            // Nos permite cancelar el envio del formulario
            return false;
        });
    });

    async function sendContact() {
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        const validate_form = document.forms['form-contact-us'].reportValidity();
        if (validate_form) {
            console.log('enviar formulario');
            let config = {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': window.CSRF_TOKEN
                },
                method: "POST",
                body: JSON.stringify({
                    name: document.getElementById('contact-name').value,
                    last_name: document.getElementById('contact-lastname').value,
                    email: document.getElementById('contact-email').value,
                    comment: document.getElementById('contact-comment').value
                })
            }
            try {
                const response = await fetch('/contact_us', config)
                const data = await response.json();
                if (data.status === 200) {
                    $('#modalContacto').modal('hide');
                    $('#contactModalSuccess').modal('show')
                } else {

                }
            } catch (error) {

            }
        }

    }


    //ADD MORE INPUTS TO THE FORM

    $('#btnAddBeneficiary').click(function() {

        console.log('llamando la función');
        let elements = document.getElementsByClassName("inputsBeneficiary");
        let count = 0;
        for (let i = 0; i<=elements.length; i++){
            count++;
            if (count === 2){
                $('#btnAddBeneficiary').attr('disabled', 'disabled')
            }
        }
        let  fields = '<div class="col-lg-12">\n' +
            '                                <h6>BENEFICIARIO '+ count+'</h6>\n' +
            '                            </div><div class="row inputsBeneficiary" id="inputsBeneficiary">\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="name[]"  placeholder="NOMBRE"\n' +
            '                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="lastname[]" placeholder="PRIMER APELLIDO"\n' +
            '                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
                '                            <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"\n' +
            '                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="parent[]" placeholder="PARENTESCO"\n' +
            '                                           pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <div class="input-group mb-2">\n' +
            '                                        <div class="input-group-prepend">\n' +
            '                                            <div class="input-group-text">%</div>\n' +
            '                                        </div>\n' +
            '                                        <input type="text" class="form-control" name="percent[]" placeholder="PORCENTAJE DESTINADO"\n' +
            '                                               pattern="[0-9].{1,2}"\n' +
            '                                               required maxlength="3">\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="phone[]" placeholder="No. TELEFÓNICO 10 DÍGITOS"\n' +
            '                                           pattern="[0-9]{10}"\n' +
            '                                           required  maxlength="10">\n' +
            '                                </div>\n' +
            '                            </div>';
        let padre = document.getElementById("beneficiaryParent");


        $('#beneficiaryParent').append(fields);
    });
</script>

<script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>


<script>

    function initMap(latitud, longitud, div) {
        let styledMapType = new google.maps.StyledMapType(
            [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#212121"
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#212121"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "administrative.country",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#9e9e9e"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#bdbdbd"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#181818"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#1b1b1b"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#2c2c2c"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#8a8a8a"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#373737"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#3c3c3c"
                        }
                    ]
                },
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#4e4e4e"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#616161"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#757575"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#000000"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#3d3d3d"
                        }
                    ]
                }
            ],
            {name: 'Styled Map'});


        let map = new google.maps.Map(document.getElementById(div), {
            center: {lat: latitud, lng: longitud},
            zoom: 14
        });
        let icon = {
            url: '{{asset('img/mapa/MARCADOR_MAPA.png')}}', // url
            scaledSize: new google.maps.Size(40, 55), // scaled size
            labelOrigin: new google.maps.Point(30, 70)
        };
        let marker = new google.maps.Marker({
            position:  {lat: latitud, lng: longitud},
            map: map,
            icon: icon
        });

        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
    }

    /* Helper function */
    function download_file(fileURL, fileName) {
        // for non-IE
        if (!window.ActiveXObject) {
            let save = document.createElement('a');
            save.href = fileURL;
            save.target = '_blank';
            let filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
            save.download = fileName || filename;
            if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
                document.location = save.href;
// window event not working here
            }else{
                let evt = new MouseEvent('click', {
                    'view': window,
                    'bubbles': true,
                    'cancelable': false
                });
                save.dispatchEvent(evt);
                (window.URL || window.webkitURL).revokeObjectURL(save.href);
            }
        }

        // for IE < 11
        else if ( !! window.ActiveXObject && document.execCommand)     {
            let _window = window.open(fileURL, '_blank');
            _window.document.close();
            _window.document.execCommand('SaveAs', true, fileName || fileURL)
            _window.close();
        }
    }

</script>

<script type="text/javascript">

    $(window).on("load", function() {

        html_map='<div id="map"></div>';
        $('.our-branches__content-address-map.sucursal').html(html_map);

        html_map_t='<div id="map_2"></div>';
        $('.our-branches__content-address-map.taller').html(html_map_t);


        $('.hero-slider').slick(
            {
                dots: true,
                infinite: true,
                speed: 600,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                prevArrow: false,
                nextArrow: false
            });

        $( ".our-history__see-more-link" ).click(function()
        {
            console.log("on click");
            if(!$(this).hasClass("active")){
                $( ".our-history__line--hidden" ).css("display", "flex");
                $(".our-history__see-more p").text("Ver menos");
                $(this).addClass("active");
                //$(".our-history__see-more").hide();
            }else{
                $( ".our-history__line--hidden" ).css("display", "none");
                $(".our-history__see-more p").text("Ver más");
                $(this).removeClass("active");
                //$(".our-history__see-more").hide();
            }
        });


        $('#option-one').change(function(){

            $('html, body').animate({
                scrollTop: $($(this).val()).offset().top
            }, 2000);

            $(this).val('Nosotros');
        });

        $('#option-two').change(function(){

            $('html, body').animate({
                scrollTop: $($(this).val()).offset().top
            }, 2000);

            $(this).val('Contacto');
        });

        $('.scroll-to').click(function()
        {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            }, 1000);
        });

        $('.catalogs').change(function()
        {
            if($(this).val().includes('descarga'))
            {
                download_file($(this).val().substring(9, 100), 'productos');
            }
            else
            {
                window.location = $(this).val();
            }
        });
        initMap(21.866939,-102.309124, "map");
        sucursales=JSON.parse('[{"region":"Bajio","pv":"Aguascalientes","sucursal":"0101-Aguascalientes","dar":"DAR Santa Elena","direccion":"Av. de los Maestros # 804, Fraccionamiento Jardines de Sta. Elena","cp":20236,"municipio":"Aguascalientes","estado":"Aguascalientes","lat":"21,866939","lon":"-102,309124","tel":"44-9140-5442 y 44-9978-1196","whats":"55-1016-8974","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Bajio","pv":"León","sucursal":"1101-León","dar":"DAR León","direccion":"Av. Universidad # 120 Bajos, Col. Lomas del Campestre","cp":37150,"municipio":"León","estado":"Guanajuato","lat":"21,148262","lon":"-101,704944","tel":"47-7718-3910","whats":"55-2730-6908","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Bajio","pv":"Juárez","sucursal":"1102-Juárez","dar":"DAR Juárez","direccion":"Av. Juárez # 1903, Col. Los Fresnos","cp":37390,"municipio":"León","estado":"Guanajuato","lat":"21,105149","lon":"-101,690525","tel":"47-7712-1563 y 47-7712-1633","whats":"55-3188-5310","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Bajio","pv":"Celaya","sucursal":"1103-Celaya","dar":"DAR Celaya","direccion":"Blvd. Adolfo López Mateos # 606 Ote, Zona Centro","cp":38000,"municipio":"Celaya","estado":"Guanajuato","lat":"20,5192737","lon":"-100,8064474","tel":"46-1608-0334 y 46-1159-0350 y 46-1688-2020","whats":"55-2197-6766","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Bajio","pv":"Queretaro","sucursal":"2201-Queretaro","dar":"DAR Corregidora","direccion":"Corregidora Norte # 913, Fraccionamiento Villas del Parque","cp":76168,"municipio":"Epigmenio González","estado":"Querétaro","lat":"20,617473","lon":"-100,390272","tel":"44-2246-1370 y 44-2246-2564","whats":"55-2197-9830","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Bajio","pv":"Pasteur","sucursal":"2202-Pasteur","dar":"DAR Pasteur","direccion":"Manuel Orozco y Berra # 101, Fraccionamiento Prados del Mirador","cp":76079,"municipio":"Querétaro","estado":"Querétaro","lat":"20,572233","lon":"-100,382584","tel":"44-2248-2762 y 44-2248-2764","whats":"446-124-0058","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Bajio","pv":"Satelite","sucursal":"2203-Satelite","dar":"DAR Satélite","direccion":"Av. De la Luz # 109-B, Satélite","cp":76110,"municipio":"Santiago de Querétaro","estado":"Querétaro","lat":"20,6393738","lon":"-100,4443626","tel":"44-2325-0448 y 44-2325-0449","whats":"55-2178-1740","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Tlalnepantla","sucursal":"0904-Tlalnepantla","dar":"DAR Tlalnepantla","direccion":"Av. Jesús Reyes Heroles # 123, Col. Valle Ceylan","cp":54150,"municipio":"Tlalnepantla","estado":"Estado de México","lat":"19,5378778","lon":"-99,18125","tel":"55-5389-1685 y 55-5388-7007","whats":"55-2249-2439","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Tizapan","sucursal":"0905-Tizapan","dar":"DAR Tizapán","direccion":"San Luis Potosí # 33 esq. Frontera, Col. Progreso Tizapán","cp":1080,"municipio":"Alvaro Obregón","estado":"Ciudad de México","lat":"19,341811","lon":"-99,197945","tel":"55-5550-4327 y 55-5550-7057","whats":"55-6077-5867","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Cuitlahuac","sucursal":"0907-Cuitlahuac","dar":"DAR Cuitláhuac","direccion":"Av. Cuitláhuac # 2909, Col. Obrero Popular","cp":2840,"municipio":"Azcapotzalco","estado":"Ciudad de México","lat":"19,463637","lon":"-99,177406","tel":"55-2465-0080 y 55-2465-1385 y 55-2465-0288","whats":"55-5198-4861","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Ecatepec","sucursal":"0909-Ecatepec","dar":"DAR Ecatepec","direccion":"Av. Adolfo López Mateos (antes R1) Lote 13, Mz. 4, Col. Faja de Oro","cp":55490,"municipio":"Ecatepec","estado":"Estado de México","lat":"19,533123","lon":"-99,047127","tel":"55-1541-1525 y 55-1541-0966 y 55-1541-0846","whats":"55-3102-8113","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Nezahualcóyotl","sucursal":"0910-Nezahualcóyotl","dar":"DAR Nezahualcóyotl","direccion":"Av. Texcoco S/N, entre Gral. Francisco Leyva y Gral Francisco O. Arce, Col. Juan Escutia","cp":9100,"municipio":"Iztapalapa","estado":"Estado de México","lat":"19.391044","lon":"-99.036932","tel":"55-5085-1863","whats":"55-1310-7677","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Toluca","sucursal":"1506-Toluca","dar":"DAR Toluca","direccion":"Av. José María Pino Suarez # 1602","cp":50190,"municipio":"Toluca","estado":"Estado de México","lat":"19,266165","lon":"-99,636844","tel":"72-2238-4564","whats":"55-4769-3295","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Cuautitlan 2","sucursal":"1508-Cuautitlan 2","dar":"DAR Irlanda","direccion":"Irlanda # 6, Centro Urbano Cuautitlán Izcalli","cp":54750,"municipio":"Cuautitlán Izcalli","estado":"Estado de México","lat":"19,660388","lon":"-99,209968","tel":"55-5831-4688","whats":"55-3198-5523","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Tultepec","sucursal":"1509-Tultepec","dar":"DAR Tultepec","direccion":"Carretera Cuautitlán Tultepec, Lote 21, Local 3, Col. Villas de Cuautitlán","cp":54857,"municipio":"Cuautitlán","estado":"Estado de México","lat":"19,6735","lon":"-99,162429","tel":"55-5831-4148","whats":"55-6105-9805","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Coacalco","sucursal":"1511-Coacalco","dar":"DAR Coacalco","direccion":"Vía José López Portillo # 109, Lote 1, Mza. “Y”, Fraccionamiento Unidad Coacalco Villa de las Flores 1ra. Sec.","cp":54948,"municipio":"Coacalco Berriozábal","estado":"Estado de México","lat":"19.632834","lon":"-99.093121","tel":"55-9154-7145","whats":"55-9165-1901","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Ecatepec","sucursal":"1512-Ecatepec 2","dar":"DAR Ecatepec 2","direccion":"Av. Jardines de Morelos # 249, Manzana 213, Lote 20","cp":55070,"municipio":"Ecatepec de Morelos","estado":"Estado de México","lat":"19,594966","lon":"-99,002129","tel":"55-5038-9626","whats":"55-9165-1497","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Saltillo","sucursal":"0501-Saltillo","dar":"DAR Saltillo","direccion":"Av. Mariano Abasolo # 1120, Col. Centro","cp":25000,"municipio":"Saltillo","estado":"Coahuila","lat":"25,426988","lon":"-100,988123","tel":"84-4410-3097 y 84-4410-3231","whats":"55-1196-9419","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Chihuahua","sucursal":"0601-Chihuahua","dar":"DAR Chihuahua","direccion":"Av. Ignacio Vallarta # 3905, Col. Granjas","cp":31100,"municipio":"Chihuahua","estado":"Chihuahua","lat":"28,662557","lon":"-106,0974","tel":"61-4412-1844","whats":"55-2194-8996","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Guadalupe","sucursal":"1901-Guadalupe","dar":"DAR Guadalupe","direccion":"Av. Benito Juárez # 3295, Col. Agua Nueva","cp":67180,"municipio":"Guadalupe","estado":"Nuevo León","lat":"25,675888","lon":"-100,220759","tel":"81-8398-7097 y 81-8398-6271 y 81-8367-8034","whats":"55-1130-7355","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Zuazua","sucursal":"1902-Zuazua","dar":"DAR Zuazua","direccion":"Zuazua # 533 Norte, Col. Centro","cp":64000,"municipio":"Monterrey","estado":"Nuevo León","lat":"25,679414","lon":"-100,307994","tel":"81-8375-9200 y 81-8375-9205 y 81-8375-9201 y 81-8375-9202 y 81-8375-9203","whats":"55-2663-6503","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Afganistan","sucursal":"1903-Afganistan","dar":"DAR Afganistán","direccion":"Av. Afganistán # 143, Col. Prados de la Cieneguita","cp":66636,"municipio":"Apodaca","estado":"Nuevo León","lat":"25,777876","lon":"-100,256359","tel":"81-8314-5348 y 81-8314-5047 y 81-8314-3122","whats":"55-9163-6623","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Aztlan","sucursal":"1904-Aztlan","dar":"DAR Aztlán","direccion":"Av. Aztlan # 5140, Col. Valle del Topo Chico","cp":64259,"municipio":"Monterrey","estado":"Nuevo León","lat":"25,726707","lon":"-100,343949","tel":"81-8373-2781 y 81-8373-3174","whats":"55-9163-7678","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Norte","pv":"Pablo de la Garza","sucursal":"1905-Pablo de la Garza","dar":"DAR Pablo de la Garza","direccion":"Pablo A. de la Garza # 1940, Col. Martínez","cp":64450,"municipio":"Monterrey","estado":"Nuevo León","lat":"25,690013","lon":"-100,287502","tel":"81-8191-9619 y 81-8191-9556","whats":"55-6132-2756","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Occidente","pv":"Zapopan","sucursal":"1401-Zapopan","dar":"DAR Zapopan","direccion":"Av. Juan Pablo II # 50, Col. El Vigía","cp":45130,"municipio":"Zapopan","estado":"Jalisco","lat":"20,72962","lon":"-103,39114","tel":"33-3636-1046 y 33-3636-0918 y 33-3656-8961","whats":"55-2197-6594, 55-1130-3021","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Occidente","pv":"Revolucion","sucursal":"1402-Revolucion","dar":"DAR Revolución","direccion":"Av. Revolución # 639, Col. Analco","cp":44450,"municipio":"Guadalajara","estado":"Jalisco","lat":"20,667545","lon":"-103,335409","tel":"33-3618-1428 y 33-3617-0115 y 33-3617-4020 y 33-3617-7658","whats":"55-1308-4991","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Occidente","pv":"Juan De Dios","sucursal":"1403-Juan De Dios","dar":"DAR Juan de Dios","direccion":"Juan de Dios Robledo # 563-B, Sector Libertad","cp":44380,"municipio":"Guadalajara","estado":"Jalisco","lat":"20,677645","lon":"-103,312126","tel":"33-3655-0613 y 33-3655-6748 y 33-3665-8620","whats":"55-2518-4978","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Occidente","pv":"Tlaquepaque","sucursal":"1404-Tlaquepaque","dar":"DAR Tlaquepaque","direccion":"Av. 8 de Julio # 3801 Local 1, Col. La Mezquitera","cp":45605,"municipio":"Tlaquepaque","estado":"Jalisco","lat":"20,61246","lon":"-103,375039","tel":"33-3144-5235 y 33-3144-5247 y 33-3144-5249","whats":"55-2197-8062","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Occidente","pv":"Culiacán","sucursal":"2501-Culiacán","dar":"DAR Culiacán","direccion":"Avenida Nicolás Bravo # 102, Colonia Jorge Almada","cp":80200,"municipio":"Culiacán","estado":"Sinaloa","lat":"24,803335","lon":"-107,402872","tel":"66-7764-4589","whats":"55-9165-1731","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Occidente","pv":"Hermosillo","sucursal":"2601-Hermosillo","dar":"DAR Hermosillo","direccion":"Calle Nayarit # 207, San Benito","cp":83190,"municipio":"Hermosillo","estado":"Sonora","lat":"29,09419","lon":"-110,965956","tel":"66-2110-5022","whats":"55-9165-1731","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Terrés","sucursal":"0901-Terrés","dar":"DAR Terrés","direccion":"Dr. José Terrés # 39, Col. Doctores","cp":6720,"municipio":"Cuauhtémoc","estado":"Ciudad de México","lat":"19,4166694","lon":"-99,14748333","tel":"55-5588-3744 y 55-5588-0435","whats":"55-2197-6523, 55-2701-4933, 55-2663-2208","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Iztapalapa","sucursal":"0902-Iztapalapa","dar":"DAR Iztapalapa","direccion":"Calz. Ermita Iztapalapa # 1090, Col. Barrio San Lucas","cp":9000,"municipio":"Iztapalapa","estado":"Ciudad de México","lat":"19,356882","lon":"-99,09712","tel":"55-5686-0062 y 55-5686-0362 y 55-5686-0173 y 55-2636-2187","whats":"55-9162-9812, 55-2672-0086","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Xochimilco","sucursal":"0903-Xochimilco","dar":"DAR Xochimilco","direccion":"Prolongación División del Norte # 5031, Col. San Lorenzo La Cebada","cp":16035,"municipio":"Xochimilco","estado":"Ciudad de México","lat":"19,277933","lon":"-99,12248","tel":"55-5641-6046 y 55-5676-1475 y 55-5641-6047","whats":"55-3950-8323","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Vertiz","sucursal":"0906-Vertiz","dar":"DAR Vertiz","direccion":"Dr. José María Vertiz # 224, Col. Doctores","cp":6720,"municipio":"Cuauhtémoc","estado":"Ciudad de México","lat":"19,416632","lon":"-99,147782","tel":"55-5578-2776 y 55-5588-7239","whats":"55-6071-5684","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Chalco","sucursal":"0908-Chalco","dar":"DAR Chalco","direccion":"Blvd. Cuauhtémoc Poniente, # 500, locales 6 y 7 Mz. 10 lte. 12, Colonia Ejidal Chalco","cp":56600,"municipio":"Chalco de Diaz Covarrubias","estado":"Estado de México","lat":"19,267042","lon":"-98,895846","tel":"55-5982-7887 y 55-5982-7912 y 55-5982-7906","whats":"55-1016-0250","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Puebla","sucursal":"2101-Puebla","dar":"DAR Puebla","direccion":"Municipio Libre # 1310, Col. Ex Rancho Vaquerías","cp":72464,"municipio":"Puebla","estado":"Puebla","lat":"19,005885","lon":"-98,241416","tel":"22-2583-2087 y 22-2583-2088 y 22-2583-2089","whats":"55-1307-7926","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Veracruz","sucursal":"3001-Veracruz","dar":"DAR Veracruz","direccion":"Av. Cuauhtémoc # 2513, Col. Cristobal Colón","cp":91755,"municipio":"Veracruz","estado":"Veracruz","lat":"19,193859","lon":"-96,151144","tel":"22-9155-3269 y 22-9155-3885 y 22-9155-3599","whats":"55-1011-9183","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Xalapa","sucursal":"3002-Xalapa","dar":"DAR Xalapa","direccion":"Avenida Lázaro Cárdenas # 967 antes 6, Col. Rafael Lucio","cp":91110,"municipio":"Xalapa","estado":"Veracruz","lat":"19,561686","lon":"-96,926559","tel":"22-8319-2090","whats":"55-3198-9781","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Morelos","sucursal":"0910-Morelos","dar":"DAR Plan de Ayala 2","direccion":"Av. Plan de Ayala # 1000, Vicente Guerrero","cp":62430,"municipio":"Cuernavaca","estado":"Morelos","lat":"18.9235613","lon":"-99.2180164","tel":"73-5145-5405","whats":"55-4377-0276","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Morelos","sucursal":"0910-Morelos","dar":"DAR Domingo Diez","direccion":"Av. Domingo Diez # 107, Lomas del Miraval","cp":62285,"municipio":"Cuernavaca","estado":"Morelos","lat":"18.93515","lon":"-99.23469","tel":"77-7177-2002, 77-7177-2003 y 77-7177-2004","whats":"77-7503-6623","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Toluca","sucursal":"1507-Toluca","dar":"DAR José López Portillo","direccion":"José López Portillo # 402, Javier Mina","cp":50010,"municipio":"Toluca","estado":"Estado de México","lat":"19,266165","lon":"-99,636844","tel":"72-2325-7522, 72-2325-7528 y 72-2288-2242","whats":"72-2794-7207","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Oaxaca","sucursal":"1507-DAR Oaxaca","dar":"DAR Oaxaca","direccion":"Calz. Francisco I Madero 539, Montes de Oca y Juan de la Barrera, Centro","cp":68000,"municipio":"Oaxaca de Juárez","estado":"Oaxaca","lat":"17.071579445065453","lon":"-96.73779018315786","tel":"95-1529-2493, 95-1529-2491 y 95-1529-2486","whats":"95-1465-4210","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Sureste","pv":"Oaxaca","sucursal":"1507-DAR Oaxaca 2","dar":"DAR Oaxaca 2","direccion":"Avenida Carretera Internacional # 67, local 1 entre Carretera A. Ixtlan y Miguel Hidalgo","cp":71320,"municipio":"San Sebastián Tutla","estado":"Oaxaca","lat":"17.064546601040032","lon":"-96.6758439890631","tel":"95-1524-7723, 95-1524-7724 y 95-1524-7725","whats":"95-1419-8356","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""},{"region":"Centro","pv":"Toluca","sucursal":"1506-Toluca","dar":"DAR Toluca 2","direccion":"José López Portillo #402","cp":50010,"municipio":"Toluca","estado":"Estado de México","lat":"19.320056347973367","lon":"-99.62895766250959","tel":"72-325-7522 y 72-325-7528 y 72-288-2242","whats":"72-794-7207","horario":"Lunes a Viernes de 9:00 am a 7:00 pm y Sábado de 9:00 am a 5:00 pm","taller":""}]');
        sucursales.sort(function (x, y) {
            let a = x.dar.toUpperCase(),
                b = y.dar.toUpperCase();
            return a == b ? 0 : a > b ? 1 : -1;
        });


        sucursales_estado=[];
        for (var i = 0; i < sucursales.length; i++) {
            if(sucursales_estado.indexOf(sucursales[i]['estado'])==-1){
                sucursales_estado.push(sucursales[i]['estado']);
                sucursales_estado.sort();
            }
        }

        html='';
        for (var i = 0; i < sucursales_estado.length; i++) {
            html+='<option value="'+sucursales_estado[i]+'">'+sucursales_estado[i]+'</option>';
        }
        $(".our-branches__content-estate-location-search-select.sucursal").html(html);

        estado_seleccionado=sucursales_estado[0];
        html='';
        for (var i = 0; i < sucursales.length; i++){
            if(estado_seleccionado==sucursales[i]['estado']){
                html+='<option value="'+sucursales[i]['dar']+'">'+sucursales[i]['dar']+'</option>';
            }
        }
        $(".our-branches__content-address-location-search-select.sucursal").html(html);

        $(".our-branches__content-address-location-search-select.sucursal").change(function(){
            select=$(this).val();
            for (var i = 0; i < sucursales.length; i++) {
                if(select==sucursales[i]['dar']){
                    suc_direccion='<p>'+sucursales[i]['direccion']+', C.P. '+sucursales[i]['cp']+', '+sucursales[i]['municipio']+', '+sucursales[i]['estado']+'</p> ';
                    $(".item_direccion.sucursal").html(suc_direccion);

                    horarios= sucursales[i]['horario'].split("y");
                    suc_horario='<p>'+horarios[0]+'</p> <p>'+horarios[1]+'</p> ';
                    $(".item_horario.sucursal").html(suc_horario);

                    telefonos= sucursales[i]['tel'].replace(/,/g,"y").split("y");
                    suc_tel="";
                    for (var j = 0; j < telefonos.length; j++) {
                        suc_tel+='<p>Tel: <a href="tel:'+telefonos[j].replace(/-| /g,'')+'">'+telefonos[j]+'</a>'+'</p>';
                    }
                    $(".item_tel.sucursal").html(suc_tel);

                    whats= sucursales[i]['whats'].split(",");
                    suc_whats="<p>";
                    for (var j = 0; j < whats.length; j++) {
                        if((whats.length-1)==j){
                            suc_whats+='<a target="_blank" href="https://api.whatsapp.com/send?phone=521'+ whats[j].replace(/-| /g,"") +'&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20SocioSyD®">'+whats[j]+'</a>';
                        }else{
                            suc_whats+='<a target="_blank" href="https://api.whatsapp.com/send?phone=521'+ whats[j].replace(/-| /g,"") +'&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20SocioSyD®">'+whats[j]+',</a>';
                        }
                    }
                    suc_whats+="</p>";
                    $(".item_whats.sucursal").html(suc_whats);

                    if(sucursales[i]['taller']!=""){
                        $(".item_servicio.sucursal").parent().css("display", "inherit");
                    }else{
                        $(".item_servicio.sucursal").parent().css("display", "none");
                    }

                    $(".our-branches__content-address-location-title.sucursal").text(whats= sucursales[i]['dar'])

                    lat=sucursales[i]['lat'].replace(",", ".");
                    lon=sucursales[i]['lon'].replace(",", ".");

                    html_map='<div id="map"></div>';
                    $('.our-branches__content-address-map.sucursal').html(html_map);
                    initMap(parseFloat(lat),parseFloat(lon), "map");


                }
            }
        });


        $(".our-branches__content-estate-location-search-select.sucursal").change(function(){
            estado_seleccionado=$(this).val();
            html='';
            cont=0;
            for (var i = 0; i < sucursales.length; i++) {
                if(estado_seleccionado==sucursales[i]['estado']){
                    html+='<option value="'+sucursales[i]['dar']+'">'+sucursales[i]['dar']+'</option>';
                    if(cont==0){
                        suc_direccion='<p>'+sucursales[i]['direccion']+', C.P. '+sucursales[i]['cp']+', '+sucursales[i]['municipio']+', '+sucursales[i]['estado']+'</p> ';
                        $(".item_direccion.sucursal").html(suc_direccion);

                        horarios= sucursales[i]['horario'].split("y");
                        suc_horario='<p>'+horarios[0]+'</p> <p>'+horarios[1]+'</p> ';
                        $(".item_horario.sucursal").html(suc_horario);

                        telefonos= sucursales[i]['tel'].replace(/,/g,"y").split("y");
                        suc_tel="";
                        for (var j = 0; j < telefonos.length; j++) {
                            suc_tel+='<p>Tel: <a href="tel:'+telefonos[j].replace(/-| /g,'')+'">'+telefonos[j]+'</a>'+'</p>';
                        }
                        $(".item_tel.sucursal").html(suc_tel);

                        whats= sucursales[i]['whats'].split(",");
                        suc_whats="<p>";
                        for (var j = 0; j < whats.length; j++) {
                            if((whats.length-1)==j){
                                suc_whats+='<a target="_blank" href="https://api.whatsapp.com/send?phone=521'+ whats[j].replace(/-| /g,"") +'&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20SocioSyD®">'+whats[j]+'</a>';
                            }else{
                                suc_whats+='<a target="_blank" href="https://api.whatsapp.com/send?phone=521'+ whats[j].replace(/-| /g,"") +'&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20SocioSyD®">'+whats[j]+'</a>';
                            }
                        }
                        suc_whats+="</p>";
                        $(".item_whats.sucursal").html(suc_whats);

                        if(sucursales[i]['taller']!=""){
                            $(".item_servicio.sucursal").parent().css("display", "inherit");
                        }else{
                            $(".item_servicio.sucursal").parent().css("display", "none");
                        }

                        $(".our-branches__content-address-location-title.sucursal").text(whats= sucursales[i]['dar'])

                        lat=sucursales[i]['lat'].replace(",", ".");
                        lon=sucursales[i]['lon'].replace(",", ".");

                        html_map='<div id="map"></div>';
                        $('.our-branches__content-address-map.sucursal').html(html_map);
                        initMap(parseFloat(lat),parseFloat(lon), "map");
                        cont++;
                    }
                }
            }
            $(".our-branches__content-address-location-search-select.sucursal").html(html);


        });

        talleres_estado=[];

        for (var i = 0; i < sucursales.length; i++) {
            if(talleres_estado.indexOf(sucursales[i]['estado'])==-1){
                if(sucursales[i]['taller']!=""){
                    talleres_estado.push(sucursales[i]['estado']);
                    talleres_estado.sort();
                }
            }
        }
    });
</script>

<script>
    const names = document.querySelectorAll(".nameInput");
    for(let i=0; i < names.length; i++){
        names[i].addEventListener("keypress", function(evt){
            if (evt.which >= 48 && evt.which <= 57) //no numbers allow
            {
                evt.preventDefault();
            }
        });
    }

    const mobiles = document.querySelectorAll(".mobileInput");
    for (let i = 0; i < mobiles.length; i++) {
        mobiles[i].addEventListener("keypress",function(evt){
            if (evt.which < 48 || evt.which > 57) //only numbers allow
            {
                evt.preventDefault();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        // autoplay video
        $('.playHomeVideo').on('click', function() {
            $('#modalVideo').modal('show');
            var video = document.getElementById("videoSocioSYD");
            video.play();
        });
        // Modal hidden event fired
        $('#modalVideo').on('hidden.bs.modal', function() {
            var video = document.getElementById("videoSocioSYD");
            video.pause();
            video.currentTime = 0;
        });
        // autoplay video
        $('.playBenefits').on('click', function() {
            var video = document.getElementById("videoBenefits");
            video.play();
        });
        // Modal hidden event fired (benefits)
        $('#modalVideoBenefits').on('hidden.bs.modal', function() {
            var video = document.getElementById("videoBenefits");
            video.pause();
            video.currentTime = 0;
        });
    });
</script>
<script>
    function playHomeVideo(videoName, isRemote) {
        //isRemote: 1 is remote in aws, 0 is local
        let element = document.getElementById('homeSource');
        if(element != null){
            element.parentNode.removeChild(element);
        }

        let source = document.createElement('source');
        let hrefVideo = '';

        if(isRemote == 0){
            hrefVideo = `{{ asset('video/${videoName}.mp4') }}`;
        }else{
            hrefVideo = `https://syd-files.s3.amazonaws.com/${videoName}.mp4`;
        }

        source.src = hrefVideo;
        source.id = "homeSource";
        source.type = 'video/mp4';

        let video = document.getElementById('videoSocioSYD');
        video.appendChild(source);
        video.load();

        $('#modalVideo').modal('show');
    }
</script>
<script>
    function playVideoBenefit(videoName) {
        let element = document.getElementById('benefitSource');
        if(element != null){
            element.parentNode.removeChild(element);
        }

        let hrefVideo = `{{ asset('video/${videoName}.mp4') }}`;
        let video = document.getElementById('videoBenefits');

        let source = document.createElement('source');
        source.id = "benefitSource";
        source.src = hrefVideo;
        source.type = "video/mp4";

        video.appendChild(source);
        video.load();

        //console.log($('#videoBenefits')[0].outerHTML)
        $("#modalVideoBenefits").modal('show');
    }
</script>
<script>
     function focusrfc(event) {
            if($('#'+event).val() == null) {
                document.getElementById(event).focus();
            }

            if($('#'+event).val().length <= 10) {
                document.getElementById(event).focus();
            }
        };
</script>

<!-- For send SMS code verification -->
<script>
    /* Detect when the Mobile input have 10 characters */

    /* this for mechanic */
    let mobileInput  = document.querySelector('#mobileMec');
    let inputCodeMec = document.querySelector('#codeMec');
    let alertCode    = document.querySelector('#alertSuccessCodeMec');
    let requiredCode = document.querySelector('#requiredSignal');
    let length       = 0;
    let hostName     = window.location.origin+"/send_sms_verification/";
    let codeConfirm  = document.querySelector('#codeMecConfirm');

    mobileInput.addEventListener('input', function() {
        length = mobileInput.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            console.log(this.response)
            if (this.readyState == 4 && this.status == 200) {
                codeConfirm.value = this.response;
            }
        };

        let url = hostName+mobileInput.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCode.hidden    = false;
        requiredCode.hidden = false;
        setTimeout(() =>{alertCode.hidden = true}, 3500);
        inputCodeMec.type = 'text';

        setTimeout(() => {
            inputCodeMec.value = codeConfirm.value;
        },15000);
    });

    /* Detect when the Mobile input have 10 characters */

    /* this for owners */
    let mobileI  = document.querySelector('#mobilePro');
    let inputCodeOw = document.querySelector('#codeOw');
    let alertCodeOw    = document.querySelector('#alertSuccessCodeOw');
    let requiredCodeOw = document.querySelector('#requiredSignalOw');
    let codeConfirmOw  = document.querySelector('#codeOwConfirm');

    mobileI.addEventListener('input', function () {
        length = mobileI.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            console.log(this.response)
            if (this.readyState == 4 && this.status == 200) {
                codeConfirmOw.value = this.response;
            }
        };

        let url = hostName+mobileI.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCodeOw.hidden    = false;
        requiredCodeOw.hidden = false;
        setTimeout(() =>{alertCodeOw.hidden = true}, 3500);
        inputCodeOw.type = 'text';

        setTimeout(() => {
            inputCodeOw.value = codeConfirmOw.value;
        },15000);
    });

    /* this for branches */
    let mobileBr  = document.querySelector('#mobileBr');
    let inputCodeBr = document.querySelector('#codeBr');
    let alertCodeBr    = document.querySelector('#alertSuccessCodeBr');
    let requiredCodeBr = document.querySelector('#requiredSignalBr');
    let codeConfirmBr  = document.querySelector('#codeBrConfirm');

    mobileBr.addEventListener('input', function() {
        length = mobileBr.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                codeConfirmBr.value = this.response;
            }
        };

        let url = hostName+mobileBr.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCodeBr.hidden    = false;
        requiredCodeOw.hidden = false;
        setTimeout(() =>{alertCodeBr.hidden = true}, 3500);
        inputCodeBr.type = 'text';

        setTimeout(() => {
            inputCodeBr.value = codeConfirmBr.value;
        },15000);
    });

    /* this for General Public */
    let mobileGen  = document.querySelector('#mobileGen');
    let inputCodeGen = document.querySelector('#codeGen');
    let alertCodeGen    = document.querySelector('#alertSuccessCodeGen');
    let requiredCodeGen = document.querySelector('#requiredSignalGen');
    let codeConfirmGen  = document.querySelector('#codeGenConfirm');

    mobileGen.addEventListener('input', function() {
        length = mobileGen.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                codeConfirmGen.value = this.response;
            }
        };

        let url = hostName+mobileGen.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCodeGen.hidden    = false;
        requiredCodeGen.hidden = false;
        setTimeout(() => {
            alertCodeGen.hidden = true
        }, 3500);
        inputCodeGen.type = 'text';

        setTimeout(() => {
            inputCodeGen.value = codeConfirmGen.value;
        }, 15000);
    });

    /* this for CNT */
    let mobileCNT  = document.querySelector('#mobileCNT');
    let inputCodeCNT = document.querySelector('#codeCNT');
    let alertCodeCNT    = document.querySelector('#alertSuccessCodeCNT');
    let requiredCodeCNT = document.querySelector('#requiredSignalCNT');
    let codeConfirmCNT  = document.querySelector('#codeCNTConfirm');
    let codeHidden = document.querySelector('#code_hidden')

    mobileCNT.addEventListener('input', function() {
        length = mobileCNT.value.length;
        if ( length < 10 ) return null;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                codeConfirmCNT.value = this.response;
            }
        };

        let url = hostName+mobileCNT.value;
        xhttp.open("GET", url, true);
        xhttp.send();

        alertCodeCNT.hidden    = false;
        requiredCodeCNT.hidden = false;
        setTimeout(() => {
            alertCodeCNT.hidden = true
        }, 3500);
        codeHidden.style.paddingTop = "1rem";
        inputCodeCNT.type = 'text';

        setTimeout(() => {
            inputCodeCNT.value = codeConfirmCNT.value;
        }, 15000);
    });

    let cntNumber = document.querySelector('#cnt_number');
    let errorCNT  = document.querySelector('#alertErrorCodeCNT');
    cntNumber.addEventListener('input', function() {
        if ( cntNumber.value.length < 7 ) return null;

        if(cntNumber.value !== 'INA2022') {
            errorCNT.hidden = false;
            setTimeout(function() {
                errorCNT.hidden = true
            }, 3500);
        }
    });
</script>
