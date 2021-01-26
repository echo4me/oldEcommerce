<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?= lang('HOME_ADMIN'); ?></a>
    </div>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?= lang('CATEGORIES'); ?></a></li>
        <li><a href="items.php"><?= lang('ITEMS'); ?></a></li>
        <li><a href="members.php"><?= lang('MEMBERS'); ?></a></li>
        <li><a href="comments.php"><?= lang('COMMENTS'); ?></a></li>
        <li><a href="#"><?= lang('STATISTICS'); ?></a></li>
        <li><a href="#"><?= lang('LOGS'); ?></a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['Username'] ;?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="members.php?do=edit&userid=<?= $_SESSION['id'] ;?>"><?= lang('EDIT PROFILE'); ?></a></li>
            <li><a href="#"><?= lang('SETTINGS'); ?></a></li>
            <li><a href="logout.php"><?= lang('LOGOUT'); ?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

