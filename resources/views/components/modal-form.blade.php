<div id="{{ $id }}" class="modal fade" aria-hidden=true>
  <div class="modal-dialog modal-md">

    <!-- Modal -->
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4>{{ $title }}</h4>
      </div>

        <!-- Modal Body -->
        <div class="modal-body">

          {{ $slot }}

        </div> <!-- Fim do modal-body -->

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button class="btn btn-default pull-left" data-dismiss="modal" type="button" >Cancelar</button>
          <button id="{{ $btnID }}" class="btn btn-danger">Salvar</button>
        </div>

    </div> <!-- Fim Modal content -->
  </div>


</div>
