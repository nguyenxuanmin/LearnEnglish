<section id="contact" class="section-contact" style="background: url('{{asset('library/client/bg_contact.webp')}}');">
    <div class="container">
        <div class="title-index">
            <span>Liên hệ</span>
        </div>
        <div class="row">
            <div class="col-xl-4 col-12 d-flex non-padding-right">
                <div class="item-contact-left">
                    <ul class="item-contact">
                        <li>{{$company[0]->name}}</li>
                        <li><i class="fa-solid fa-location-dot"></i> <span><b>Địa chỉ:</b> {{$company[0]->address}}</span></li>
                        <li><i class="fa-solid fa-phone"></i> <span><b>Hotline:</b> {{$company[0]->hotline}}</span></li>
                        <li><i class="fa-solid fa-envelope"></i> <span><b>Email:</b> {{$company[0]->email}}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-8 col-12 d-flex non-padding-left">
                <div class="item-contact-right">
                    <form id="formContact">
                        <input type="text" name="nameContact" placeholder="Họ và tên" class="form-control mb-3">
                        <input type="text" name="emailContact" placeholder="Email" class="form-control mb-3">
                        <textarea name="contentContact" rows="5" class="form-control mb-3" placeholder="Nội dung"></textarea>
                        <div class="text-center">
                            <button id="btnContact" class="btn btn-submit-contact">Gửi liên hệ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('#formContact').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var btn = document.getElementById('btnContact');
            btn.disabled = true;
            btn.innerText = 'Đang xử lý...';
            $.ajax({
                url: '{{route('contact')}}',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false, 
                success: function(response) {
                    var message = "";
                    var modalContact = new bootstrap.Modal(document.getElementById('modalAlert'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    if(response.success == true){
                        message = "<div class='msgSuccess'><i class='fa-solid fa-check'></i><span>Gửi liên hệ thành công.</span></div>";
                        modalContact.show();
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }else{
                        message = "<div class='msgError'><i class='fa-solid fa-circle-exclamation'></i><span>"+response.message+"</span></div>";
                        modalContact.show();
                        setTimeout(() => {
                            modalContact.hide();
                        }, 2000);
                    }
                    $('#showMessage').html(message);
                    btn.disabled = false;
                    btn.innerText = 'Gửi liên hệ';
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });
    });
</script>