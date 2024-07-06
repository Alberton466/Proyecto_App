</main>
<br />
<footer>
  <div style="width: 100%; overflow: hidden;">
    <img style="width: 100%; height: auto;" src="/app/libs/img/ISR-footer.png" />
  </div>
  <!-- place footer here -->
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
  integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
  integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
<script>
  $(document).ready(function () {
    $("#tabla_id").DataTable({
      "pageLength": 5,
      lengthMenu: [
        [10, 25, 30],
        [10, 25, 30]
      ],
      "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
      }
    }
    );
  }
  );
</script>

<script>

function borrar(id){
    Swal.fire({
    title: 'Deseas borra el registro?',
    showCancelButton: true,
    confirmButtonText: 'Si, eliminar'
}).then((result) => {
  if (result.isConfirmed) {
    window.location="index.php?textID="+id;
  } 
})
}

</script>

<script>
  function ocultarMensaje() {
    const mensaje = document.getElementById('mensaje');
    if (mensaje) {
      mensaje.style.display = 'none';
    }
  }

  setTimeout(ocultarMensaje, 4000);
</script>

</body>

</html>