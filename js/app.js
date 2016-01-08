(function() {
  'use strict';
  $(document).ready(function() {
    new WOW().init();
    $('.carousel').carousel({});
    $('a[href*=#]:not([href=#]):not(.carousel-control):not(.nav-tabs li a)').click(onClickLink);
    $('#contato-form').submit(onSubmitForm);

    // Active tabs
    $('.nav-tabs a').click(function(e) {
      e.preventDefault()
      $(this).tab('show')
    })

    // Sidebar
    $('#play-wrapper').click(openSidebar);
    $('#page').mouseover(closeSidebar);
    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        closeSidebar();
      }
    });

  });

  function openSideBar(){
    $("#wrapper").toggleClass("toggled");
  }

  function closeSidebar() {
    $("#wrapper").attr('class', 'toggled');
  }

  function onClickLink() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - 60
        }, 1000);
        return false;
      }
    }
  }

  function onSubmitForm(event) {
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
  }
})();
