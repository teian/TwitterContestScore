<?php
/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/

/**
 * Main layout file for the whole backend.
 * It is based on Twitter Bootstrap classes inside HTML5Boilerplate.
 *
 * @var BackendController $this
 * @var string $content
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-flatly.css">    
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
    <title><?= CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<!-- NAVIGATION BEGIN -->
<?php 

$menu_items = array();

$main_menu = array(
    'class' => 'bootstrap.widgets.TbMenu',
    'items' => array(
        array(
            'label' => 'Home', 
            'url' => array('/site/index')
        ),
        array(
            'label' => 'Contest', 
            'url' => array('/Contest/index')
        ),
    ),
);
array_push($menu_items,$main_menu);

if(isset($this->menu) && sizeof($this->menu) > 0)
{
    $action_menu = array(
        'class' => 'bootstrap.widgets.TbMenu',
        'items' => array(
            array(
                'label' => 'Operations',
                'url' => array('#'),
                'visible' => !Yii::app()->user->isGuest,
                'items' => $this->menu,
            ), 
        )
    );

    array_push($menu_items,$action_menu);
}

$login_menu = array(
    'class' => 'bootstrap.widgets.TbMenu',
    'htmlOptions'=>array('class'=>'pull-right'),
    'items' => array(
        array(
            'label' => 'Login',
            'url' => array('/site/login'),
            'visible' => Yii::app()->user->isGuest
        ),
        array(
            'label' => 'Logout (' . Yii::app()->user->name . ')',
            'url' => array('/site/logout'),
            'visible' => !Yii::app()->user->isGuest
        ), 
    )
);

array_push($menu_items,$login_menu);

$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'brand' => Yii::app()->name,
        'brandUrl' => Yii::app()->request->baseUrl,
        'collapse' => true,
        'fixed' =>'top',
        'items' => $menu_items,
    )
);
?>
<!-- NAVIGATION END -->

<!-- CONTENT WRAPPER BEGIN -->
<div id="main">
    <div class="container-fluid">
        <?php if (isset($this->breadcrumbs)): ?>
            <?php $this->widget(
                'bootstrap.widgets.TbBreadcrumbs',
                array(
                    'links' => $this->breadcrumbs,
                )
            ); ?>
        <?php endif?>
    	<div class="row">
            <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->

            <!-- CONTENT BEGIN -->
    		<?php echo $content; ?>
            <!-- CONTENT END -->

        </div>
    </div>
</div>
<!-- CONTENT WRAPPER END -->

<!-- FOOTER -->
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <hr/>
                <p>Copyright &copy; <?php echo date('Y'); ?> by code-works.</p>
            </div>
        </div>
    </div>    
</footer>
<!-- FOOTER END -->
</body>
</html>