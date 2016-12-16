<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Yii::$app->user->identity->buyer->picture->thumbnail; ?>" class="img-circle" alt="User Image"/>
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
                    ['label' => 'Ofertas', 'icon' => 'fa fa-shopping-bag', 'url' => ['/offer']],
                    ['label' => 'Categorias', 'icon' => 'fa fa-th', 'url' => ['/category']],
                    ['label' => 'Itens', 'icon' => 'fa  fa-tags', 'url' => ['/item']],
                    [
                        'label' => 'Clientes (Empresas)', 
                        'icon' => 'fa  fa-tags',
                        'url' => ['#'],
                        'visible' => Yii::$app->user->can('admin'),
                        'items' => [
                            ['label' => 'Ver Todos', 'icon' => 'fa fa-file-code-o', 'url' => ['/seller']],
                            ['label' => 'Cadastrar', 'icon' => 'fa fa-dashboard', 'url' => ['/seller/create']],
                        ],
                    ],
                    [
                        'label' => 'Clientes (Usuários)', 
                        'icon' => 'fa  fa-tags',
                        'url' => ['#'],
                        'visible' => Yii::$app->user->can('admin'),
                        'items' => [
                            ['label' => 'Administradores', 'icon' => 'fa  fa-tags', 'url' => ['/buyer/role-index', 'role' => 'administrator']],
                            ['label' => 'Vendedores', 'icon' => 'fa  fa-tags', 'url' => ['/buyer/role-index', 'role' => 'salesman']],
                            ['label' => 'Usuários', 'icon' => 'fa  fa-tags', 'url' => ['/buyer']],
                        ],
                    ],

                    /*['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],*/

                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
