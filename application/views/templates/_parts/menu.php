<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <a class="navbar-brand" href="#">CAFPE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url_lang('') ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?= site_url_lang('news') ?>">News</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="<?= site_url_lang('admin/articles') ?>">News</a>
            </div>
          </li>
          <li class="nav-item">
              <?= lang_switcher() ?>
          </li>
        </ul>
        <div class="col-auto admin-area-button">
            <?php if(logged_in()): ?>
                <a data-toggle="tooltip" title="<?= lang('logout') ?>" class="btn btn-success" href="<?= site_url_lang('admin/logout/'.base64_current_url_encode()) ?>">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </a>
            <?php else: ?>
                <a data-toggle="tooltip" title="<?= lang('admin_area') ?>" class="btn btn-success" href="<?= site_url_lang('admin/dashboard') ?>">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
