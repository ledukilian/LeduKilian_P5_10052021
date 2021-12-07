/*!
 * Start Bootstrap - SB Admin 2 v4.1.3 (https://startbootstrap.com/theme/sb-admin-2)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin-2/blob/master/LICENSE)
 */

tinymce.init({
   selector: '#contenuArticle',
   menubar: false,
   toolbar: "formatselect | fontselect | bold italic strikethrough forecolor backcolor formatpainter | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link insertfile image | removeformat | code | addcomment | checklist | casechange",
   height: 360,
   branding: false,
});

function showModal(element) {
   data = element.dataset;
   modal = document.getElementById(data.target);
   // console.log(modal);
   // console.log(modal.getElementsByClassName('modal-content')[0].innerHTML);
   modal.getElementsByClassName('modal-body')[0].innerHTML = data.content;
   modal.getElementsByClassName('modal-title')[0].innerHTML = data.title;
   console.log(data);
   $('#modalAction').attr('action', data.action);
   $('#' + data.target).modal('show');
}

function loadForm(element) {
   data = element.dataset;
   $('#name').val(data.name);
   $('#link').val(data.link);
   $('#icon').val(data.icon);
   $('#formSocial').attr('action', '/admin/reseaux/'+data.id+'/edit/')
   $('#submitSocial').html('<i class="fas fa-pen mr-2"></i>Modifier')
}