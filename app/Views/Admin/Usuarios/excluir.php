  <!-- Extendendo o layout principal -->
  <?= $this->extend('Admin/layout/principal'); ?>

  <?= $this->section('titulo'); ?>

  <?php echo $titulo; ?>

  <?= $this->endSection(); ?>




  <?= $this->section('estilos'); ?>


  <?= $this->endSection(); ?>





  <?= $this->section('conteudo'); ?>
  <div class="row">


      <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">

              <div class="card-header bg-primary pb-0 pt-4">
                  <h4 class="card-title text-white"><?= esc($titulo); ?></h4>
              </div>

              <div class="card-body">

                  <?php if(session()->has('errors_model')): ?>

                  <ul>
                      <?php foreach(session('errors_model') as $error) : ?>

                      <li class="text-danger"><?php echo $error ?></li>

                      <?php endforeach; ?>
                  </ul>


                  <?php endif; ?>



                  <?php echo form_open("admin/usuarios/excluir/$usuario->id"); ?>

                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Atenção!</strong> Tem certeza da exclusão do usuário <strong><?php echo esc($usuario->nome);?></strong> ?
                  </div>

                  <button type="submit" class="btn btn-danger mr-2 btn-sm">
                      <i class="mdi mdi-trash-can btn-icon-prepend"></i>
                      Excluir
                  </button>

                  <a href="<?= site_url("admin/usuarios/show/$usuario->id"); ?>" class="btn btn-info btn-sm mr-2">
                      <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                      Voltar
                  </a>

                  <?php echo form_close(); ?>



              </div>
          </div>
      </div>


      <?= $this->endSection(); ?>






      <?= $this->section('scripts'); ?>

      <script src="<?= site_url('admin/vendors/mask/jquery.mask.min.js'); ?>"></script>
      <script src="<?= site_url('admin/vendors/mask/app.js'); ?>"></script>




      <?= $this->endSection(); ?>