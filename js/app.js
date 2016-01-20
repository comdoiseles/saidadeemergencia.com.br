---
---

{% include_relative jquery-2.1.4.min.js %}
{% include_relative bootstrap.min.js %}
{% include_relative wow.min.js %}

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

    // Navbar
    $(".navbar-nav li a").click(collapseNavbar);


    // Sidebar
    $('#play-wrapper').click(openSidebar);
    $('#page').mouseover(closeSidebar);
    $(document).keyup(function(e) {
      if (e.keyCode == 27) {
        closeSidebar();
      }
    });

  });

  function openSidebar() {
    $("#wrapper").toggleClass("toggled");
  }

  function closeSidebar() {
    $("#wrapper").attr('class', 'toggled');
  }

  function collapseNavbar() {
    $(".navbar-collapse").collapse('hide');
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
    $.ajax({
      url: '//formspree.io/contato@saidadeemergencia.com.br',
      method: 'POST',
      dataType: 'json',
      data: {
        nome: $(form).find('input[name="nome"]').val(),
        email: $(form).find('input[name="email"]').val(),
        mensagem: $(form).find('textarea[name="mensagem"]').val()
      },
      success: function() {
        $('#alert')
          .removeClass('alert-danger')
          .addClass('alert-success')
          .text('Obrigado! Recebemos a sua mensagem!')
          .show();
      },
      error: function() {
        $('#alert')
          .removeClass('alert-success')
          .addClass('alert-danger')
          .text('Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde!')
          .show();
      },
      complete: function() {
        form.reset();
        btnEnviar.button('reset');
      }
    });
  }

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-72649582-1', 'auto');
  ga('send', 'pageview');

})();
