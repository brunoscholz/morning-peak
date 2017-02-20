<?php

use backend\components\Utils;

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <?php if(!Yii::$app->user->isGuest): ?>
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Utils::safePicture(Yii::$app->user->identity->buyer->picture, 'thumbnail'); ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username; ?></p>
                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu OndeTem', 'options' => ['class' => 'header']],
                    ['label' => 'Painel', 'icon' => 'fa fa-dashboard', 'url' => ['/dashboard']],
                    [
                        'label' => 'Ofertas',
                        'icon' => 'fa fa-shopping-bag',
                        'url' => ['#'],
                        'items' => [
                            // filter by selected seller
                            ['label' => 'Ver Todas', 'icon' => 'fa fa-eye', 'url' => ['/offers'], 'visible' => Yii::$app->user->can('vendor')],
                            //['label' => 'Catálogos', 'icon' => 'fa fa-eye', 'url' => ['/offer']],
                            //['label' => 'Nova Oferta', 'icon' => 'fa fa-cart-plus', 'url' => ['/offer/create'], 'visible' => Yii::$app->user->can('vendor')],
                        ],
                    ],
                    [
                        'label' => 'Categorias',
                        'icon' => 'fa  fa-th',
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Ver Todas', 'icon' => 'fa fa-eye', 'url' => ['/categories'], 'visible' => Yii::$app->user->can('user')],
                            ['label' => 'Sugerir Nova', 'icon' => 'fa fa-plus-circle', 'url' => ['/categories/category/sugest'], 'visible' => Yii::$app->user->can('user')],
                            ['label' => 'Nova Categoria', 'icon' => 'fa fa-plus', 'url' => ['/categories/category/create'], 'visible' => Yii::$app->user->can('admin')],
                        ],
                    ],
                    [
                        'label' => 'Itens',
                        'icon' => 'fa  fa-shopping-basket',
                        'url' => ['/items'],
                        'visible' => Yii::$app->user->can('vendor'),
                    ],
                    [
                        'label' => 'Clientes (Empresas)', 
                        'icon' => 'fa  fa-building',
                        'url' => ['#'],
                        'visible' => Yii::$app->user->can('admin'),
                        'items' => [
                            ['label' => 'Ver Todos', 'icon' => 'fa fa-eye', 'url' => ['/sellers']],
                            ['label' => 'Cadastrar', 'icon' => 'fa fa-user-plus', 'url' => ['/sellers/seller/create']],
                        ],
                    ],
                    [
                        'label' => 'Clientes (Usuários)', 
                        'icon' => 'fa  fa-users',
                        'url' => ['#'],
                        'visible' => Yii::$app->user->can('admin'),
                        'items' => [
                            ['label' => 'Administradores', 'icon' => 'fa  fa-eye', 'url' => ['/buyers/buyer/role-index', 'role' => 'administrator']],
                            ['label' => 'Vendedores', 'icon' => 'fa  fa-eye', 'url' => ['/buyers/buyer/role-index', 'role' => 'salesman']],
                            ['label' => 'Usuários', 'icon' => 'fa  fa-eye', 'url' => ['/buyers']],
                            ['label' => 'Cadastrar', 'icon' => 'fa fa-user-plus', 'url' => ['/users/create']],
                        ],
                    ],

                    /*['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],*/

                    ['label' => 'Entrar', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Sair', 'url' => ['site/logout'], 'visible' => !Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

        <!-- else ... -->
        <?php endif; ?>

    </section>

</aside>
