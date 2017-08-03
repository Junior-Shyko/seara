<div  id="modal_signup_confirmation" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div id="modal_signup_confirmation_header" class="modal-header">
        <h4 class="modal-title text-center"></h4>
      </div>
      <div id="modal_signup_confirmation_body" class="modal-body">
        <div id="modal_signup_confirmation_content" class="seara-hide">
          <h4>Parabéns!</h4>
          <p class="text-justify">Agora só resta aguardar enquanto as informações de seu cadastro são avaliadas, você deve receber nos próximos
            minutos um email com mais informações.</p>
            <p><strong>Seara Contabilidade</strong></p>
          </div>
        </div>
        <div class="modal-footer hidden">
          <button id="modal_signup_confirmation_button" type="button" class="btn btn-default" data-href="{{url('/')}}">
            Ok, Entendi!
          </button>
        </div>
      </div>
    </div>
  </div>

  @push('stylesheets')
  <style>
  .seara-hide {
    visibility: hidden;
  }
  </style>
  @endpush
