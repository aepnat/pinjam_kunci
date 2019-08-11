<div class="row" style="background-color:#222d32;margin-top:-20px;padding:20px 0">
    <div class="col-md-4 col-md-offset-5" style="">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $config['base_url']; ?>/img/avatar.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nama_lengkap']; ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>

      </div>

    </div>
</div>

<div class="row" style="background-color:#3c8dbc;margin-top:-20px;padding:35px 0">
</div>

<div class="row" style="margin-top:-20px;padding:20px 0;background-color:#222d32;">
    <div class="col-md-6 col-md-offset-3" style="">

        <div class="col-md-6 col-md-offset-3">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MENU</li>
                <?php echo implode('', $menu_items); ?>
            </ul>
        </div>


    </div>
</div>