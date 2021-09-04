<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    
<div class="container">
    <a class="btn btn-success" href="javascript:void(0)" id="createNewCliente"> Create Nuevo Cliente</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nit</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Fecha de Nacimiento</th>
                <th width="300px">Accion</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="clienteForm" name="clienteForm" class="form-horizontal">
                   <input  name="id_cliente" id="id_cliente">
                    
                   <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nit</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nit" name="nit" placeholder="Enter Nit" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Enter Nombre" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Apellido</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Enter Apellido" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Direccion</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Enter Direccion" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Telefono</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Enter Telefono" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Fecha de Nacimiento</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Enter Fecha_nacimiento" value="" maxlength="50" required="">
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Guardar Cambios
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
<script type="text/javascript">
  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('cliente.index') }}",
        columns: [
            {data: 'id_cliente', name: 'id_cliente'},
            {data: 'nit', name: 'nit'},
            {data: 'nombre', name: 'nombre'},
            {data: 'apellido', name: 'apellido'},
            {data: 'direccion', name: 'direccion'},
            {data: 'telefono', name: 'telefono'},
            {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#createNewCliente').click(function () {
        $('#saveBtn').val("Crear Cliente");
        $('#id_cliente').val('');
        $('#clienteForm').trigger("Reiniciar");
        $('#modelHeading').html("Crear Nuevo Cliente");
        $('#ajaxModel').modal('show');
    });
    $('body').on('click', '.editCliente', function () {
      var id_cliente = $(this).data('id');
      $.get("{{ route('cliente.index') }}" +'/' + id_cliente +'/edit', function (data) {
          $('#modelHeading').html("Editar Libro");
          $('#saveBtn').val("Editar Libro");
          $('#ajaxModel').modal('show');
          $('#id_cliente').val(data.id);
          $('#title').val(data.title);
          $('#author').val(data.author);
      })
   });
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Guardar');
    
        $.ajax({
          data: $('#clienteForm').serialize(),
          url: "{{ route('cliente.store') }}",
          type: "POST",
          dataType: 'json',

          success: function (data) {
            
              $('#clienteForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('error');
          }
      });
    });
    
    $('body').on('click', '.deleteCliente', function () {
     
        var id_cliente = $(this).data("id");
        confirm("Estas seguro de eliminar el libro !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('cliente.store') }}"+'/'+id_cliente,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>
</body>
</html>