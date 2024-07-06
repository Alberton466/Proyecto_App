<?php include("templates/header.php");?>
<style>
  .galeria{
    display: flex;
    width: 500px;
    height: 300px;
    margin: 0 auto;
  }
  .galeria img{
    width: 0px;
    flex-grow: 1;
    object-fit: cover;
    filter: brightness(80%);
    transition: .7s ease;
  }
  .galeria img:hover{
    width: 500px;
    opacity: 1;
    filter: brightness(100%);
  }
</style>

<div class="galeria">
  <img src="/app/libs/img/carrucel/imagen1.jpg" alt="">
  <img src="/app/libs/img/carrucel/imagen2.jpg" alt="">
  <img src="/app/libs/img/carrucel/imagen3.jpg" alt="">
  <img src="/app/libs/img/carrucel/imagen4.jpg" alt="">
  <img src="/app/libs/img/carrucel/imagen5.jpg" alt="">
</div>

<?php include("templates/footer.php");?>
