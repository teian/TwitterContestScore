<?php
/**
 * Inner part of the layout which includes a sidebar without portlet widget containing menu for CRUD.
 *
 * @var BackendController $this
 * @var string $content
 */

$this->beginContent('//layouts/main');
?>
<div class="col-md-12">
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>