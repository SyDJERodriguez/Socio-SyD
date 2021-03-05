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

        //Get owner's client number
        $("#client_number_pro").keyup(function(){
            let client_number_pro = $('input[id=client_number_pro]').val();
            if(client_number_pro.length===8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_pro},
                    success: function (data) {
                        console.log(data);
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert").innerHTML='El número de cliente no se encuentra en la base de datos. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert").removeAttribute("hidden");
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

        //Get the mechanic's client number
        $("#client_number_mec").keyup(function(){
            let client_number_mec = $('input[id=client_number_mec]').val();
            if(client_number_mec.length===8){
                $.ajax({
                    type: "GET",
                    url: "{{route('customer.information')}}",
                    data: {'client_number': client_number_mec},
                    success: function (data) {
                        console.log(data);
                        if (data['success']==='false' && data['verify_client_number']==='false') {
                            document.getElementById("form_alert_mec").innerHTML='El número de cliente no se encuentra en la base de datos. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                            document.getElementById("form_alert_mec").removeAttribute("hidden");
                        }
                        $('input[id=nameMec]').val(data['name']);
                        $('input[id=lastNameMec]').val(data['last_name']);
                        $('input[id=secondLastNameMec]').val(data['second_last_name']);
                        $('input[id=mobileMec]').val(data['mobile_number']);
                        $('input[id=emailMec]').val(data['email']);
                        $('input[id=birthday]').val(data['birthday']);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });

        //Owner's form
        $("#ownerForm").bind("submit",function(){
            // We capture send button
            let btnSend = $("#btnSend");
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data:$(this).serialize(),

                success: function(data){
                    console.log(data);
                    if(data['success']==='true'){
                        $('#modal3').modal('hide');
                        $('#clientName').text('¡BIENVENIDO! '+data['name'].toUpperCase());
                        $('#clientNumber').text('No. de Cliente '+data['client_number']);
                        $('#clientMessage').text('En breve recibirás un email de activación.');
                        $('#modalSuccess').modal('show');
                    }else if (data['success']==='false' && data['verify_email']==='false') {
                        document.getElementById("form_alert").innerHTML='El email ya se encuentra registrado. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert").removeAttribute("hidden");
                    }else if (data['success']==='false' && data['verify_password']==='false') {
                        document.getElementById("form_alert").innerHTML='Las contraseñas no coinciden, por favor verifique. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert").removeAttribute("hidden");
                    }else if (data['success']==='false' && data['verify_mobile_number']==='false') {
                        document.getElementById("form_alert").innerHTML='El número telefónico ya se encuentra asociado a otro cliente. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert").hidden= true}, 3000);
                    }else if (data['success']==='false' && data['verify_email_number']==='false') {
                        document.getElementById("form_alert").innerHTML='El email ya se encuentra asociado a otro cliente. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert").hidden= true}, 3000);
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

        //Mechanic's form
        $("#mechanicForm").bind("submit",function(){
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
                        $('#clientMessage').text('En breve recibirás un email de activación.');
                        $('#modalSuccess').modal('show');
                    }else if (data['success']==='false' && data['verify_email']==='false') {
                        document.getElementById("form_alert_mec").innerHTML='El email ya se encuentra registrado. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert_mec").removeAttribute("hidden");
                    }else if (data['success']==='false' && data['verify_password']==='false') {
                        document.getElementById("form_alert_mec").innerHTML='Las contraseñas no coinciden, por favor verifique. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert_mec").removeAttribute("hidden");
                    }else if (data['success']==='false' && data['verify_mobile_number']==='false') {
                        document.getElementById("form_alert_mec").innerHTML='El número telefónico ya se encuentra asociado a otro cliente. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert_mec").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_mec").hidden= true}, 3000);
                    }else if (data['success']==='false' && data['verify_email_number']==='false') {
                        document.getElementById("form_alert_mec").innerHTML='El email ya se encuentra asociado a otro cliente. <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>';
                        document.getElementById("form_alert_mec").removeAttribute("hidden");
                        setTimeout(function (){document.getElementById("form_alert_mec").hidden= true}, 3000);
                    }else if (data['success']==='false'){
                        $('#modal5').modal('hide');
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

        //Restore Password
        $("#sendRestorePassword").bind("submit",function(){
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
                    console.log(data);
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

        $("#restoreForm").bind("submit",function(){
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
                    console.log(data);
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
        $("#sendRestoreAccount").bind("submit",function(){
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
                    console.log(data);
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
        $("#restoreAccount").bind("submit",function(){
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
                    console.log(data);
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
            '                                           pattern="[A-Za-z].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="lastname[]" placeholder="PRIMER APELLIDO"\n' +
            '                                           pattern="[A-Za-z].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
                '                            <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="second_lastname[]" placeholder="SEGUNDO APELLIDO"\n' +
            '                                           pattern="[A-Za-z].{2,}"\n' +
            '                                           required maxlength="30">\n' +
            '                                </div>\n' +
            '                                <div class="col-lg-6 py-2">\n' +
            '                                    <input type="text" class="form-control" name="parent[]" placeholder="PARENTESCO"\n' +
            '                                           pattern="[A-Za-z].{2,}"\n' +
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
         console.log(padre);

        $('#beneficiaryParent').append(fields);
    });
</script>
