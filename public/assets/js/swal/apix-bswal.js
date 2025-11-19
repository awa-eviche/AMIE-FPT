$('.apix-delete').on('click', function(e){
    e.preventDefault();
    var self = $(this);

    Swal.fire({
        title: 'Êtes vous sur?',
        text: "Cette suppression est définitive !",
        type: "danger",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Allons y!',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.value) {
            self.parents(".delete-form").submit();
        }
    })
});

$('.apix-confirm').on('click', function(e){
    console.log("Le e");
    console.log(e);
    e.preventDefault();
    var self = $(this);

    Swal.fire({
        title: 'Êtes vous sur?',
        text: "Confirmation de votre action",
        type: "warning2",
        showCancelButton: true,
        confirmButtonText: 'Je confirme !',
        cancelButtonText: 'Annuler',
        closeOnConfirm: true
    }).then((result) => {
        if (result.value) {
            self.parents(".apix-form").submit();
        }
    });
});