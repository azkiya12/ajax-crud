<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT POST</h5>
                
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="name" class="control-label">Title</label>
                    <input type="text" class="form-control" id="title-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Content</label>
                    <textarea class="form-control" id="content-edit" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-content-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Body->button event Edit post Click
    $('body').on('click', '#btn-edit-post', function() {
        //variable ini mengambil data dari atribut data-id didalam button EDIT
        let post_id = $(this).data('id');

        //fetch/mengambil data detail Post di server with ajax
        $.ajax({
            url: `/posts/${post_id}`,
            type: "GET",
            cache: false,
            success: function(response){
                // jika berhasil maka
                // fill data to form modal
                $('#post_id').val(response.data.id);
                $('#title-edit').val(response.data.title);
                $('#content-edit').val(response.data.content);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action UPDATE post Modal
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let post_id = $('#post_id').val();
        let title = $('#title-edit').val();
        let content = $('#content-edit').val();
        let token = $("#meta[name='csrf-token']").attr("content");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        //ajax
        $.ajax({
            url: `/posts/${post_id}`,
            type: "PUT",
            cache: false,
            data: {
                "title": title,
                "content": content,
            },
            // jika proses PUT berhasil maka 
            // jalankan promise success
            success: function(response) {
                // console.log("sukses masuk");
                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    time: 2000
                });

                //data post element unutk me-replace row berdasarkan ID
                let post= `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.title}</td>
                        <td>${response.data.content}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" 
                                id="btn-edit-post" 
                                data-id="${response.data.id}" 
                                class="btn btn-primary btn-sm">EDIT
                            </a>
                            <a href="javascrip:void(0)" 
                                id="btn-delete-post" 
                                data-id="${response.data.id}" 
                                class="btn btn-danger btn-sm">DELETE
                            </a>
                        </td>
                    </tr>
                `;
                
                // append to post data
                $(`#index_${response.data.id}`).replaceWith(post);

                //close modal
                $('#modal-edit').modal('hide');
            },

            error:function(error){
                if(error.responseJSON.title[0]) {

                    //show alert
                    $('#alert-title-edit').removeClass('d-none');
                    $('#alert-title-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-title-edit').html(error.responseJSON.title[0]);
                } 

                if(error.responseJSON.content[0]) {

                    //show alert
                    $('#alert-content-edit').removeClass('d-none');
                    $('#alert-content-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-content-edit').html(error.responseJSON.content[0]);
                }
                console.log('Error pada:', error);
            }
        });
    });
</script>