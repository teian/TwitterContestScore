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