<script>
    // button create post event
    $('body').on('click','#btn-delete-post', function(){
        let post_id = $(this).data('id');
        let token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, Hapus!',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('masuk yes confirm');
                
                $.ajax({
                    url: `/posts/${post_id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    
                    success: function(response) {
                        console.log('masuk success');

                        $('.modal').modal('hide');

                        //remove row of post on table
                        $(`#index_${post_id}`).remove();

                        // show success message
                        Swal.fire('Success', response.message, 'success', 1500);
                        // Swal.fire({
                        //     type: 'success',
                        //     icon: 'success',
                        //     title: `${response.message}`,
                        //     showConfirmButton: false,
                        //     timer: 3000,
                        // });
                    }
                });
            }
        })
    });
</script>