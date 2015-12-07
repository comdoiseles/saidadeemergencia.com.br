(function() {
  'use strict';
  $(document).ready(function() {
    new WOW().init();
    $('.carousel').carousel({});

    $('#contato-form').submit(function(event) {
      event.preventDefault();
      var form = this;
      var btnEnviar = $(form).find('.btn-enviar');

      btnEnviar.button('loading');
      $.post('https://formkeep.com/f/719de3dc7fcb', {
        nome: $(form).find('input[name="nome"]').val(),
        email: $(form).find('input[name="email"]').val(),
        mensagem: $(form).find('textarea[name="mensagem"]').val()
      }, function() {
        $('#alert')
          .removeClass('alert-danger')
          .addClass('alert-success')
          .text('Obrigado! Recebemos a sua mensagem!')
          .show();
      }).fail(function() {
        $('#alert')
          .removeClass('alert-success')
          .addClass('alert-danger')
          .text('Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde!')
          .show();
      }).always(function() {
        form.reset();
        btnEnviar.button('reset');
      })

    });
  });
})();
