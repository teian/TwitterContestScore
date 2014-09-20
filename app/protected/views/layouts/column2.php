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
 * Inner part of the layout which includes a sidebar with portlet widget containing menu for CRUD.
 *
 * @var BackendController $this
 * @var string $content
 */

$this->beginContent('//layouts/main');
?>
<div class="col-md-2">
    <div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
	</div>
</div>
<div class="col-md-10">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>