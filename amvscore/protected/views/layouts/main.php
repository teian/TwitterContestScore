<?php
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
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-darkly.min.css">    
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
    <title><?= CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<!-- NAVIGATION BEGIN -->
<?php 
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'brand' => 'AMVScore',
        'brandUrl' => '/',
        'collapse' => true,
        'fixed' =>'top',
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                //'type' => "navbar",
                'items' => array(
                    array(
                        'label' => 'Home', 
                        'url' => array('/site/index')
                    ),
                    array(
                        'label' => 'Contest', 
                        'url' => array('/Contest/index')
                    ),
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
                    array(
                        'label' => 'Users list',
                        'url' => array('/user'),
                        'visible' => !Yii::app()->user->isGuest
                    )
                ),
            ),
        ),
    )
);
?>
<!-- NAVIGATION END -->

<!-- CONTENT WRAPPER BEGIN -->
<div id="main">
    <div class="container">
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
        <div class="row">
            <hr/>
    		<footer>
    			Copyright &copy; <?php echo date('Y'); ?> by code-works.<br/>
    		</footer>
    	</div>

    </div>
</div>
<!-- CONTENT WRAPPER END -->

</body>
</html>